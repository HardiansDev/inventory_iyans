<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\ProductIn;
use App\Models\SalesDetail;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Ambil hanya produk yang belum dihapus (softdelete) dari product_in
        $sales = Sales::with(['productIn' => function ($query) {
            $query->whereNull('deleted_at'); // Ambil product_in yang belum di-soft-delete
        }])->whereHas('productIn', function ($query) {
            $query->whereNull('deleted_at');
        })->get();

        return view('sales.index', compact('sales'));
    }



    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'product_ins_id' => 'required|exists:product_ins,id',
            'qty' => 'required|integer|min:1',
        ]);

        // Mendapatkan produk yang bersangkutan dari tabel productin
        $productIn = ProductIn::find($validatedData['product_ins_id']);

        // Mengurangi stok produk
        if ($productIn->qty >= $validatedData['qty']) {
            // Simpan data penjualan ke tabel sales
            Sales::create([
                'product_ins_id' => $validatedData['product_ins_id'],
                'qty' => $validatedData['qty'],
            ]);

            // Kurangi stok produk di tabel productin
            $productIn->qty -= $validatedData['qty'];
            $productIn->save();
            app(\App\Http\Controllers\ProductInController::class)
                ->updateStatusPenjualan($productIn);

            return redirect()->route('productin.index')->with('success', 'Produknya Berhasil Ditambahkan.');
        } else {

            return redirect()->back()->with('error', 'Stok produk tidak cukup.');
        }
    }





    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function s(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
