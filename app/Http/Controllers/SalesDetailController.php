<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\SalesDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;

class SalesDetailController extends Controller
{
    public function index()
    {
        // Ambil semua transaksi unik berdasarkan transaction_number
        $transactionNumbers = SalesDetail::select('transaction_number')
            ->distinct()
            ->orderByDesc('date_order')
            ->paginate(10); // <-- Pagination di sini

        // Ambil data lengkap untuk tiap transaksi
        $salesDetails = $transactionNumbers->map(function ($item) {
            $group = SalesDetail::with(['sales.productIn.product', 'discount'])
                ->where('transaction_number', $item->transaction_number)
                ->get();

            $first = $group->first();

            // Hitung subtotal semua item (price × qty)
            $subtotal = $group->sum(fn($i) => $i->price * $i->qty);

            // Ambil diskon jika ada
            $discountPercentage = optional($first->discount)->nilai ?? 0;
            $discountAmount = ($subtotal * $discountPercentage) / 100;

            // Total akhir setelah diskon
            $finalTotal = $subtotal - $discountAmount;

            // Gabung semua nama produk dalam transaksi
            $productNames = $group->map(fn($i) => optional(optional($i->sales->productIn)->product)->name)
                ->filter()
                ->unique()
                ->take(3)
                ->implode(', ');
            if ($group->count() > 3) $productNames .= ' ...';

            return (object) [
                'transaction_number' => $first->transaction_number,
                'invoice_number' => $first->invoice_number,
                'date_order' => $first->date_order,
                'metode_pembayaran' => $first->metode_pembayaran,
                'product_names' => $productNames,
                'discount' => $discountAmount,
                'total' => $finalTotal,
            ];
        });

        return view('transaksi.index', [
            'salesDetails' => $salesDetails,
            'pagination' => $transactionNumbers, // kirim pagination info
        ]);
    }




    public function processPayment(Request $request)
    {
        $validated = $request->validate([
            'sales' => 'required|array',
            'sales.*.sales_id' => 'required|exists:sales,id',
            'sales.*.qty' => 'required|integer|min:1',
            'date_order' => 'nullable|date',
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
            $itemsToInsert = [];

            foreach ($validated['sales'] as $item) {
                $sales = Sales::with(['productIn' => fn ($q) => $q->withTrashed()->with('product')])->findOrFail($item['sales_id']);

                if ($sales->qty < $item['qty']) {
                    $stokKurang[] = optional(optional($sales->productIn)->product)->name ?? 'Produk tidak ditemukan';
                }
            }

            if (!empty($stokKurang)) {
                DB::rollBack();

                return response()->json(['success' => false, 'message' => 'Stok tidak cukup untuk: '.implode(', ', $stokKurang)], 422);
            }

            foreach ($validated['sales'] as $item) {
                $sales = Sales::with(['productIn' => fn ($q) => $q->withTrashed()->with('product')])->findOrFail($item['sales_id']);
                $product = optional(optional($sales->productIn)->product);

                if (!$product || !$product->price) {
                    throw new \Exception('Produk tidak valid atau harga belum ditentukan.');
                }

                $qty = $item['qty'];
                $price = $product->price;
                $subtotal = $price * $qty;

                $sales->qty -= $qty;
                $sales->save();

                app(ProductInController::class)->updateStatusPenjualan($sales->productIn);

                $itemsToInsert[] = [
                    'sales_id' => $sales->id,
                    'transaction_number' => $validated['transaction_number'],
                    'invoice_number' => $validated['invoice_number'],
                    'date_order' => now(),
                    'discount_id' => $validated['discount_id'],
                    'amount' => $validated['amount'],
                    'total' => $validated['total'],
                    'subtotal' => $subtotal,
                    'change' => $validated['change'],
                    'qty' => $qty,
                    'price' => $price,
                    'metode_pembayaran' => $validated['metode_pembayaran'],
                    'created_by' => Auth::id(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            SalesDetail::insert($itemsToInsert);

            // Jika metode QRIS, generate Snap token
            if ($validated['metode_pembayaran'] === 'qris') {
                $orderId = 'TRX-'.uniqid();

                $params = [
                    'transaction_details' => [
                        'order_id' => $orderId,
                        'gross_amount' => max(1000, (int) $validated['total']),
                    ],
                    'callbacks' => [
                        'finish' => route('print.receipt', ['transaction_number' => $validated['transaction_number']]),
                    ],
                ];

                try {
                    Log::info('ORDER ID:', [$orderId]);
                    Log::info('GROSS:', [$validated['total']]);

                    $snapToken = Snap::getSnapToken($params);
                    DB::commit();

                    return response()->json([
                        'success' => true,
                        'snap_token' => $snapToken,
                        'metode_pembayaran' => 'qris',
                        'transaction_url' => route('print.receipt', ['transaction_number' => $validated['transaction_number']]),
                        ...$validated,
                    ]);
                } catch (\Exception $e) {
                    DB::rollBack();

                    return response()->json([
                        'success' => false,
                        'message' => 'Midtrans Snap error: '.$e->getMessage(),
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'metode_pembayaran' => 'cash',
                'transaction_url' => route('print.receipt', ['transaction_number' => $validated['transaction_number']]),
                ...$validated,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses transaksi.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function printReceipt($transaction_number)
    {
        $salesDetails = SalesDetail::where('transaction_number', $transaction_number)
            ->with(['sales.productIn.product', 'discount'])
            ->get();

        if ($salesDetails->isEmpty()) {
            return redirect()->route('sales.index')->with('error', 'Struk tidak ditemukan.');
        }

        $invoice = $salesDetails->first();

        $subtotal = $salesDetails->sum(fn ($item) => $item->qty * $item->price);

        $discountPercentage = optional($invoice->discount)->nilai ?? 0;
        $discount = ($subtotal * $discountPercentage) / 100;

        $total = $subtotal - $discount;

        $amount = $invoice->amount;
        $change = $invoice->change;

        $paymentMethod = $invoice->metode_pembayaran;

        return view('penjualan.receipt', compact(
            'salesDetails',
            'invoice',
            'subtotal',
            'discount',
            'total',
            'amount',
            'change',
            'paymentMethod'
        ));
    }

    public function storeSalesDetail(Request $request)
    {
        $validated = $request->validate([
            'sales_id' => 'required|exists:sales,id',
            'transaction_number' => 'required|string',
            'invoice_number' => 'required|string',
            'date_order' => 'required|date',
            'discount_id' => 'nullable|exists:discounts,id',
            'amount' => 'required|numeric',
            'total' => 'required|numeric',
            'subtotal' => 'required|numeric',
            'change' => 'required|numeric',
            'qty' => 'required|integer',
            'price' => 'required|numeric',
            'metode_pembayaran' => 'required|in:cash,qris',
        ]);

        $validated['created_by'] = Auth::id();
        $validated['created_at'] = now();
        $validated['updated_at'] = now();

        SalesDetail::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Detail penjualan berhasil disimpan.',
            'transaction_number' => $validated['transaction_number'], // ← HARUS ADA
        ]);
    }
}
