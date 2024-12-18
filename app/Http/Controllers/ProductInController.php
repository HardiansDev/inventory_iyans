<?php

namespace App\Http\Controllers;


use App\Models\ProductIn;
use App\Models\Product;
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


    public function storeProductIn(Request $request)
    {
        $data = $request->all();

        // Pastikan supplier_id dan category_id adalah array, bukan string
        foreach ($data['supplier_id'] as $key => $value) {
            // Jika menggunakan Eloquent atau DB Query untuk insert, pastikan field menerima array
            ProductIn::create([
                'product_id' => $data['product_id'][$key],
                'date' => $data['date'][$key],
                'qty' => $data['qty'][$key],
                'recipient' => $data['recipient'][$key],
            ]);
        }

        return redirect()->route('productin.index')->with('success', 'Produk Masuk Berhasil Disimpan!');
    }

    public function create()
    {
        $products = Product::all();

        // Kirim data produk ke view
        return view('productin.create', compact('products'));
    }

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
        // Cari ProductIn berdasarkan ID
        $productIn = ProductIn::findOrFail($id);

        // Ambil data produk terkait
        $product = $productIn->product;

        // Cek status yang diterima dari request
        $status = $request->input('status');

        // Update status berdasarkan status yang diterima
        if ($status === 'diterima') {
            // Kurangi stok produk utama berdasarkan qty dari ProductIn
            $product->stock -= $productIn->qty;

            // Pastikan stok tidak menjadi negatif
            if ($product->stock < 0) {
                return redirect()->back()->with('error', 'Stok tidak mencukupi!');
            }

            // Update status produk menjadi 'produk diterima'
            $product->status = 'produk diterima';
        } elseif ($status === 'ditolak') {
            // Tidak ada perubahan pada stok jika ditolak
            $product->status = 'produk ditolak';
        }

        // Jika stok produk sudah habis, ubah status produk menjadi 'semua produk telah diterima'
        if ($product->stock == 0) {
            $product->status = 'semua produk telah diterima';
        }

        // Simpan perubahan pada produk utama
        $product->save();

        // Refresh produk untuk memastikan data terbaru
        $product->refresh();


        // Debugging: Tampilkan data produk setelah status diubah
        // dd($product);
        // dd($product);

        // Update status di tabel ProductIn
        $productIn->status = $status;
        $productIn->save();

        return redirect()->route('productin.index')->with('success', 'Status berhasil diperbarui!');
    }
}
