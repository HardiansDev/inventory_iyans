<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductIn;
use App\Models\Sales;
use App\Models\SalesDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SalesDetailController extends Controller
{
    public function processPayment(Request $request)
    {
        $request->validate([
            'sales' => 'required|array',
            'sales.*.id' => 'required|exists:sales,id', // karena stok ambil dari sales
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

            // Validasi stok semua produk dulu
            $stokKurang = [];
            foreach ($request->sales as $item) {
                $sales = Sales::with('productIn.product')->findOrFail($item['id']);
                if ($sales->qty < $item['qty']) {
                    $stokKurang[] = $sales->productIn->product->name ?? 'Produk ID: ' . $sales->product_ins_id;
                }
            }

            if (!empty($stokKurang)) {
                return back()->with('error', 'Stok tidak mencukupi untuk produk: ' . implode(', ', $stokKurang));
            }

            // Jika stok cukup, proses simpan
            foreach ($request->sales as $item) {
                $sales = Sales::with('productIn.product')->findOrFail($item['id']);
                $product = $sales->productIn->product; // ← tambahkan ini

                // Kurangi stok penjualan
                $sales->qty -= $item['qty'];
                $sales->save();

                // Simpan detail transaksi
                $salesDetail = new SalesDetail();
                $salesDetail->sales_id = $sales->id;
                $salesDetail->transaction_number = $request->transaction_number;
                $salesDetail->invoice_number = $request->invoice_number;
                $salesDetail->date_order = $request->date_order;
                $salesDetail->discount_id = $request->discount_id;
                $salesDetail->amount = $request->amount;
                $salesDetail->total = $request->total;
                $salesDetail->subtotal = $request->subtotal;
                $salesDetail->change = $request->change;
                $salesDetail->qty = $item['qty'];
                $salesDetail->price = $sales->productIn->product->price;
                $salesDetail->save();
            }

            DB::commit();

            return redirect()->route('print.receipt', ['transaction_number' => $request->transaction_number])
                ->with('success', 'Pembayaran berhasil diproses!');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error saat proses pembayaran: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan dalam proses pembayaran.');
        }
    }

    public function printReceipt($transaction_number)
    {
        $salesDetails = SalesDetail::where('transaction_number', $transaction_number)
            ->with('sales.productIn.product') // Relasi salesdetail -> sales -> product_in -> product
            ->get();

        if ($salesDetails->isEmpty()) {
            return redirect()->route('sales.index')->with('error', 'Struk tidak ditemukan.');
        }

        $invoice = $salesDetails->first();

        return view('penjualan.receipt', compact('salesDetails', 'invoice'));
    }
}
