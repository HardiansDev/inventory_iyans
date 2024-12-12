<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductIn;
use App\Models\Supplier;
use App\Models\Category;
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
    public function store(Request $request)
    {
        // Validasi input dari form
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',  // pastikan produk ada
            'qty' => 'required|numeric|min:1',               // pastikan qty valid
            'date' => 'required|date',
            'recipient' => 'required|string',
        ]);

        // Ambil data produk berdasarkan ID yang dipilih
        $product = Product::findOrFail($request->product_id);

        // Cek apakah stok mencukupi
        if ($product->stock < $validated['qty']) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi!');
        }

        // Kurangi stok berdasarkan qty
        $product->stock -= $validated['qty'];
        $product->save();

        // Proses menyimpan data produk masuk
        ProductIn::create([
            'product_id' => $validated['product_id'],
            'supplier_id' => $request->supplier_id,
            'category_id' => $request->category_id,
            'date' => $validated['date'],
            'recipient' => $validated['recipient'],
            'qty' => $validated['qty'],
            'status' => 'Produk Masuk',  // Status produk masuk
        ]);

        // Redirect setelah sukses
        return redirect()->route('productin.index')->with('success', 'Produk berhasil ditambahkan!');
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
        // Validasi status
        $validated = $request->validate([
            'status' => 'required|in:terima,tolak',  // Validasi status yang hanya boleh "terima" atau "tolak"
        ]);

        // Cari data product_in berdasarkan ID
        $productIn = ProductIn::findOrFail($id);

        // Perbarui status produk masuk
        $productIn->status = $validated['status'];
        $productIn->save();

        // Perbarui status produk di tabel product jika diterima
        $product = $productIn->product;

        if ($validated['status'] == 'terima') {
            // Jika diterima, update status produk menjadi "terima"
            $product->status = 'produk diterima';  // Atur status produk menjadi "produk diterima"
            $product->save();
        } elseif ($validated['status'] == 'tolak') {
            // Jika ditolak, update status produk menjadi "produk ditolak"
            $product->status = 'produk ditolak';  // Atur status produk menjadi "produk ditolak"
            $product->save();
        }

        // Redirect setelah status diperbarui
        return redirect()->route('productin.index')->with('success', 'Status produk berhasil diperbarui!');
    }
}
