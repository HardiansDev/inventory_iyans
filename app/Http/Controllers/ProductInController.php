<?php

namespace App\Http\Controllers;


use App\Models\ProductIn;
use Illuminate\Http\Request;

class ProductInController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Ambil semua data produk masuk, dengan data produk yang terkait
        $productIns = ProductIn::with(['product', 'product.category'])->get();

        // Kirim data ke view
        return view('productin.index', compact('productIns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',  // Pastikan produk ada
            'qty' => 'required|numeric|min:1',             // Pastikan qty valid
            'date' => 'required|date',
            'recipient' => 'required|string',
        ]);

        ProductIn::create([
            'product_id' => $validated['product_id'],
            'supplier_id' => $request->supplier_id,
            'category_id' => $request->category_id,
            'date' => $validated['date'],
            'recipient' => $validated['recipient'],
            'qty' => $validated['qty'],
            'status' => 'menunggu',  // Status default "menunggu"
        ]);

        return redirect()->route('productin.index')->with('success', 'Produk berhasil ditambahkan dan sedang menunggu persetujuan.');
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


    public function updateStatus(Request $request, $id)
    {
        $productIn = ProductIn::findOrFail($id);

        // Ambil data produk terkait
        $product = $productIn->product;

        // Cek status yang diterima dari request
        $status = $request->input('status');

        if ($status === 'diterima') {
            // Kurangi stok produk utama berdasarkan qty dari ProductIn
            $product->stock - $productIn->qty;

            // Pastikan stok tidak menjadi negatif
            if ($product->stock < 0) {
                return redirect()->back()->with('error', 'Stok tidak mencukupi!');
            }

            // Update status di tabel produk
            $product->status = 'produk diterima';
        } elseif ($status === 'ditolak') {
            // Tidak ada perubahan pada stok jika ditolak
            $product->status = 'produk ditolak';
        }

        // Simpan perubahan pada produk utama
        $product->save();

        // Update status di tabel ProductIn
        $productIn->status = $status;
        $productIn->save();

        return redirect()->route('productin.index')->with('success', 'Status berhasil diperbarui!');
    }
}
