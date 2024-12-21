<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Sales;
use App\Models\Salesdetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SalesDetailController extends Controller
{
    public function processPayment(Request $request)
    {
        dd($request->all());
        try {
            $request->validate([
                'amount' => 'nullable|numeric',
                'discount' => 'nullable|numeric|min:0|max:100',
                'total_price' => 'required|numeric',
                'products' => 'required|array',
                'products.*.name' => 'required|string',
                'products.*.qty' => 'required|integer|min:1',
                'products.*.price' => 'required|numeric|min:0',
            ]);

            $now = Carbon::now();
            $discount = $request->input('discount') ?? 0;
            $totalPrice = $request->input('total_price');
            $discountedTotal = $totalPrice - ($totalPrice * ($discount / 100));
            $invoiceNumber = 'INV-' . $now->format('YmdHis');
            $transactionNumber = rand(100000, 999999);

            DB::beginTransaction();

            $sales = new Sales();
            $sales->date_order = $now;
            $sales->invoice_number = $invoiceNumber;
            $sales->transaction_number = $transactionNumber;
            $sales->subtotal = $discountedTotal;
            $sales->amount = $request->input('amount');
            $sales->change = $request->input('amount') - $discountedTotal;
            $sales->save();

            foreach ($request->input('products') as $product) {
                $salesDetail = new SalesDetail();
                $salesDetail->sales_id = $sales->id;
                $salesDetail->date_order = $now;
                $salesDetail->discount_id = $discount;
                $salesDetail->amount = $request->input('amount');
                $salesDetail->total = $product['qty'] * $product['price'];
                $salesDetail->subtotal = $discountedTotal;
                $salesDetail->change = $request->input('amount') - $discountedTotal;
                $salesDetail->transaction_number = $transactionNumber;
                $salesDetail->invoice_number = $invoiceNumber;
                $salesDetail->name = $product['name'];
                $salesDetail->qty = $product['qty'];
                $salesDetail->price = $product['price'];
                $salesDetail->save();
            }

            DB::commit();

            $request->session()->put('printData', [ // Simpan di session
                'invoice_number' => $invoiceNumber,
                'date_order' => $now,
                'products' => $request->input('products'),
                'subtotal' => $discountedTotal,
                'amount' => $request->input('amount'),
                'change' => $request->input('change'),
            ]);

            return response()->json(['success' => true]); // Response sukses
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e); // Log error untuk debugging
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat memproses pembayaran.'], 500);
        }
    }

    public function printStruk(Request $request)
    {
        $printData = $request->session()->get('printData');
        $request->session()->forget('printData'); // Hapus data dari session

        if (!$printData) {
            return redirect('/sales')->with('error', 'Data struk tidak tersedia.');
        }

        return view('print_struk', compact('printData'));
    }
}
