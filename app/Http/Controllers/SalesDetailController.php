<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\SalesDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SalesDetailController extends Controller
{
    public function processPayment(Request $request)
    {
        $validated = $request->validate([
            'sales' => 'required|array',
            'sales.*.id' => 'required|exists:sales,id',
            'sales.*.qty' => 'required|integer|min:1',
            'date_order' => 'required|date',
            'discount_id' => 'nullable|exists:discounts,id',
            'amount' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'subtotal' => 'required|numeric|min:0',
            'change' => 'required|numeric|min:0',
            'transaction_number' => 'required',
            'invoice_number' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $stokKurang = [];

            foreach ($validated['sales'] as $item) {
                $sales = Sales::with('productIn.product')->findOrFail($item['id']);
                if ($sales->qty < $item['qty']) {
                    $stokKurang[] = $sales->productIn->product->name ?? 'Produk ID: ' . $sales->product_ins_id;
                }
            }

            if (!empty($stokKurang)) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Stok tidak mencukupi untuk: ' . implode(', ', $stokKurang),
                ], 422);
            }

            foreach ($validated['sales'] as $item) {
                $sales = Sales::with('productIn.product')->findOrFail($item['id']);
                $sales->qty -= $item['qty'];
                $sales->save();
                app(\App\Http\Controllers\ProductInController::class)->updateStatusPenjualan($sales->productIn);


                $product = $sales->productIn->product;

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
