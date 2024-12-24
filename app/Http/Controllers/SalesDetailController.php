<?php

namespace App\Http\Controllers;

use App\Models\ProductIn;
use App\Models\Sales; // Import model Sales
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
            'sales.*.id' => 'required|exists:product_ins,id',
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

            // Simpan data produk di tabel `sales` terlebih dahulu
            foreach ($request->sales as $saleData) {
                $sale = new Sales();
                $sale->product_ins_id = $saleData['id'];
                $sale->qty = $saleData['qty'];
                $sale->save();

                // Simpan data di tabel `salesdetails` dengan sales_id
                $salesDetail = new SalesDetail();
                $salesDetail->sales_id = $sale->id; // Gunakan ID dari tabel sales
                $salesDetail->transaction_number = $request->transaction_number;
                $salesDetail->invoice_number = $request->invoice_number;
                $salesDetail->date_order = $request->date_order;
                $salesDetail->discount_id = $request->discount_id;
                $salesDetail->amount = $request->amount;
                $salesDetail->total = $request->total;
                $salesDetail->subtotal = $request->subtotal;
                $salesDetail->change = $request->change;
                $salesDetail->save();
            }

            DB::commit();

            return redirect()->route('print.receipt', ['transaction_number' => $request->transaction_number])
                ->with('success', 'Pembayaran berhasil diproses!');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error saat memproses pembayaran:', ['error' => $e->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
