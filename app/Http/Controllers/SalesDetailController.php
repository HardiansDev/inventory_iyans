<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\SalesDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Midtrans\Snap;
use Midtrans\Config;

class SalesDetailController extends Controller
{
    public function processPayment(Request $request)
    {
        $validated = $request->validate([
            'sales' => 'required|array',
            'sales.*.sales_id' => 'required|exists:sales,id',
            'sales.*.qty' => 'required|integer|min:1',
            'date_order' => 'required|date',
            'discount_id' => 'nullable|exists:discounts,id',
            'amount' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'subtotal' => 'required|numeric|min:0',
            'change' => 'required|numeric|min:0',
            'transaction_number' => 'required',
            'invoice_number' => 'required',
            'metode_pembayaran' => 'required|in:cash,qris',
        ]);

        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = config('midtrans.isSanitized');
        Config::$is3ds = config('midtrans.is3ds');

        try {
            DB::beginTransaction();

            $stokKurang = [];

            foreach ($validated['sales'] as $item) {
                $sales = Sales::with(['productIn' => function ($query) {
                    $query->withTrashed()->with('product');
                }])->findOrFail($item['sales_id']);

                if ($sales->qty < $item['qty']) {
                    $productName = optional(optional($sales->productIn)->product)->name ?? 'Produk tidak ditemukan';
                    $stokKurang[] = $productName;
                }
            }

            if (!empty($stokKurang)) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Stok tidak mencukupi untuk: ' . implode(', ', $stokKurang),
                ], 422);
            }

            if ($validated['metode_pembayaran'] === 'qris') {
                $orderId = uniqid('TRX-');

                $params = [
                    'transaction_details' => [
                        'order_id' => $orderId,
                        'gross_amount' => max(1, (int) $validated['total']),
                    ]
                ];

                $snapToken = Snap::getSnapToken($params);
                $url = route('print.receipt', ['transaction_number' => $validated['transaction_number']]);

                DB::commit();

                return response()->json([
                    'success' => true,
                    'snap_token' => $snapToken,
                    'transaction_number' => $validated['transaction_number'],
                    'invoice_number' => $validated['invoice_number'],
                    'date_order' => $validated['date_order'],
                    'discount_id' => $validated['discount_id'],
                    'amount' => $validated['amount'],
                    'total' => $validated['total'],
                    'subtotal' => $validated['subtotal'],
                    'change' => $validated['change'],
                    'sales' => $validated['sales'],
                    'metode_pembayaran' => $validated['metode_pembayaran'],
                    'transaction_url' => $url,
                ]);
            }

            foreach ($validated['sales'] as $item) {
                $sales = Sales::with(['productIn' => function ($query) {
                    $query->withTrashed()->with('product');
                }])->findOrFail($item['sales_id']);

                $sales->qty -= $item['qty'];
                $sales->save();

                app(\App\Http\Controllers\ProductInController::class)->updateStatusPenjualan($sales->productIn);

                $product = optional(optional($sales->productIn)->product);

                if (!$product || !$product->price) {
                    throw new \Exception('Produk tidak valid atau harga belum ditentukan.');
                }

                SalesDetail::create([
                    'sales_id' => $sales->id,
                    'transaction_number' => $validated['transaction_number'],
                    'invoice_number' => $validated['invoice_number'],
                    'date_order' => $validated['date_order'],
                    'discount_id' => $validated['discount_id'],
                    'amount' => $validated['amount'],
                    'total' => $validated['total'],
                    'subtotal' => $validated['subtotal'],
                    'change' => $validated['change'],
                    'qty' => $item['qty'],
                    'price' => $product->price,
                    'metode_pembayaran' => $validated['metode_pembayaran'],
                ]);
            }

            DB::commit();

            $url = route('print.receipt', ['transaction_number' => $validated['transaction_number']]);

            return response()->json([
                'success' => true,
                'transaction_url' => $url,
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Pembayaran gagal: ' . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi.',
            ], 500);
        }
    }

    public function storeSalesDetail(Request $request)
    {
        $validated = $request->validate([
            'sales' => 'required|array',
            'sales.*.sales_id' => 'required|exists:sales,id',
            'sales.*.qty' => 'required|integer|min:1',
            'date_order' => 'required|date',
            'discount_id' => 'nullable|exists:discounts,id',
            'amount' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'subtotal' => 'required|numeric|min:0',
            'change' => 'required|numeric|min:0',
            'transaction_number' => 'required',
            'invoice_number' => 'required',
            'metode_pembayaran' => 'required|in:qris',
        ]);

        try {
            DB::beginTransaction();

            foreach ($validated['sales'] as $item) {
                $sales = Sales::with(['productIn' => function ($query) {
                    $query->withTrashed()->with('product');
                }])->findOrFail($item['sales_id']);

                $product = optional(optional($sales->productIn)->product);

                if (!$product || !$product->price) {
                    throw new \Exception('Produk tidak valid atau harga belum ditentukan.');
                }

                if ($sales->qty >= $item['qty']) {
                    $sales->qty -= $item['qty'];
                    $sales->save();

                    app(\App\Http\Controllers\ProductInController::class)->updateStatusPenjualan($sales->productIn);
                } else {
                    throw new \Exception('Stok tidak cukup untuk produk: ' . ($product->name ?? 'Produk tidak ditemukan'));
                }

                SalesDetail::create([
                    'sales_id' => $sales->id,
                    'transaction_number' => $validated['transaction_number'],
                    'invoice_number' => $validated['invoice_number'],
                    'date_order' => $validated['date_order'],
                    'discount_id' => $validated['discount_id'],
                    'amount' => $validated['amount'],
                    'total' => $validated['total'],
                    'subtotal' => $validated['subtotal'],
                    'change' => $validated['change'],
                    'qty' => $item['qty'],
                    'price' => $product->price,
                    'metode_pembayaran' => $validated['metode_pembayaran'],
                ]);
            }

            DB::commit();

            $url = route('print.receipt', ['transaction_number' => $validated['transaction_number']]);

            return response()->json([
                'success' => true,
                'transaction_url' => $url,
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal menyimpan detail penjualan setelah QRIS sukses: ' . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan detail pembayaran. Silakan hubungi admin.',
            ], 500);
        }
    }

    public function printReceipt($transaction_number)
    {
        $salesDetails = SalesDetail::where('transaction_number', $transaction_number)
            ->with('sales.productIn.product')
            ->get();

        if ($salesDetails->isEmpty()) {
            return redirect()->route('sales.index')->with('error', 'Struk tidak ditemukan.');
        }

        $invoice = $salesDetails->first();

        return view('penjualan.receipt', compact('salesDetails', 'invoice'));
    }
}
