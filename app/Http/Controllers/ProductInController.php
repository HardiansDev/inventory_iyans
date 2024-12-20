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
        // Validasi input
        $validated = $request->validate([
            'product_id' => 'required|array',
            'product_id.*' => 'exists:products,id',
            'supplier_id' => 'required|array',
            'supplier_id.*' => 'nullable|exists:suppliers,id',
            'category_id' => 'required|array',
            'category_id.*' => 'nullable|exists:categories,id',
            'date' => 'required|array',
            'date.*' => 'date',
            'qty' => 'required|array',
            'qty.*' => 'integer|min:1',
            'recipient' => 'required|array',
            'recipient.*' => 'string|max:255',
        ]);

        // Loop data untuk menyimpan ke database
        foreach ($request->product_id as $key => $productId) {
            \App\Models\ProductIn::create([
                'product_id' => $productId,
                'supplier_id' => $request->supplier_id[$key],
                'category_id' => $request->category_id[$key],
                'date' => $request->date[$key],
                'qty' => $request->qty[$key],
                'recipient' => $request->recipient[$key],
            ]);
        }

        return redirect()->route('productin.index')->with('success', 'Data produk masuk berhasil ditambahkan!');
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

        if ($status === 'diterima') {
            // Pastikan hanya memperbarui stok jika status sebelumnya adalah 'menunggu'
            if ($productIn->status === 'menunggu') {
                if ($product->stock >= $productIn->qty) {
                    // Kurangi stok produk sesuai dengan qty yang diterima
                    $product->stock -= $productIn->qty;
                    $productIn->status = 'diterima'; // Update status di ProductIn
                    $product->status = 'produk diterima'; // Update status di Product
                    $product->save(); // Simpan perubahan stok dan status produk
                } else {
                    return redirect()->back()->with('error', 'Stok tidak mencukupi!');
                }
            }
        } elseif ($status === 'ditolak') {
            if ($productIn->status === 'menunggu') {
                $productIn->status = 'ditolak'; // Update status di ProductIn
                $product->status = 'produk ditolak'; // Update status di Product
                $product->save(); // Simpan perubahan status produk
            }
        }

        // Simpan perubahan pada ProductIn
        $productIn->save();

        // Redirect kembali dengan pesan sukses
        return redirect()->route('productin.index')->with('success', 'Status berhasil diperbarui!');
    }
}
