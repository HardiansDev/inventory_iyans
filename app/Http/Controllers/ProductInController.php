<?php

namespace App\Http\Controllers;


use App\Models\ProductIn;
use App\Models\Product;
use App\Models\Sales;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Log;


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
        $productIns = ProductIn::with(['product', 'product.category', 'sales'])->orderBy('date', 'asc')->get();
        $categories = \App\Models\Category::all();
        // Kirim data ke view
        return view('productin.index', compact('productIns', 'categories'));
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
        $productIn = ProductIn::with('sales.salesDetails')->findOrFail($id);

        //  Cek stok toko dari semua relasi sales
        $stokToko = $productIn->sales->sum('qty'); // Jumlahkan seluruh qty di sales

        if ($stokToko > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak bisa dihapus karena masih memiliki stok di toko (' . $stokToko . ' tersedia).'
            ], 400);
        }

        //  Putuskan relasi salesDetails dan hapus sales
        foreach ($productIn->sales as $sale) {
            $sale->salesDetails()->update(['sales_id' => null]);
            $sale->delete();
        }

        $productIn->delete(); // Hapus data produk masuk

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dihapus karena stok di toko sudah habis.'
        ]);
    }






    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:diterima,ditolak',
            'catatan' => 'required_if:status,ditolak'
        ], [
            'catatan.required_if' => 'Catatan wajib diisi jika produk ditolak.'
        ]);

        $productIn = ProductIn::findOrFail($id);
        $product = $productIn->product;
        $status = $request->input('status');

        if ($status === 'diterima') {
            if ($productIn->status === 'menunggu') {
                if ($product->stock >= $productIn->qty) {
                    $product->stock -= $productIn->qty;
                    $product->status = 'produk diterima';
                    $productIn->status = 'diterima';
                    $product->save();
                } else {
                    $msg = 'Stok tidak mencukupi!';
                    return $request->expectsJson()
                        ? response()->json(['success' => false, 'message' => $msg])
                        : back()->with('error', $msg);
                }
            }
            $productIn->catatan = null;
        } elseif ($status === 'ditolak') {
            if ($productIn->status === 'menunggu') {
                $product->status = 'produk ditolak';
                $productIn->status = 'ditolak';
                $productIn->catatan = $request->input('catatan');
                $product->save();
            }
        }

        $productIn->save();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diperbarui!',
            ]);
        }

        return redirect()->route('productin.index')->with('success', 'Status berhasil diperbarui!');
    }



    public function addStock(Request $request, $id)
    {
        $productIn = ProductIn::with('product')->findOrFail($id);
        $product = $productIn->product;

        $qtyTambah = (int) $request->input('tambah_qty', 1);

        if ($product->stock < $qtyTambah) {
            // ⛔ RETURN ERROR JSON untuk AJAX
            return response()->json([
                'success' => false,
                'message' => 'Stok utama produk tidak mencukupi.'
            ], 400);
        }

        $productIn->qty += $qtyTambah;
        $productIn->save();

        $product->stock -= $qtyTambah;
        $product->save();

        // ✅ SELALU RETURN JSON, jangan cek $request->ajax()
        return response()->json([
            'success' => true,
            'message' => 'Stok berhasil ditambahkan ke gudang.'
        ]);
    }

    public function addStockKeToko(Request $request, $productInId)
    {
        $productIn = ProductIn::with('product')->findOrFail($productInId);
        $qty = (int) $request->input('qty', 1);

        if ($productIn->qty < $qty) {
            $msg = 'Stok di gudang tidak mencukupi!';
            return $request->ajax()
                ? response()->json(['success' => false, 'message' => $msg])
                : back()->with('error', $msg);
        }

        $existingSales = Sales::where('product_ins_id', $productIn->id)->first();

        if ($existingSales) {
            $existingSales->qty += $qty;
            $existingSales->save();
        } else {
            Sales::create([
                'product_ins_id' => $productIn->id,
                'qty' => $qty,
            ]);
        }

        $productIn->qty -= $qty;
        $productIn->save();

        if ($request->ajax()) {

            return response()->json([
                'success' => true,
                'message' => 'Stok berhasil ditambahkan ke toko.',
                'redirect_url' => route('productin.index')
            ]);
        }


        return back()->with('success', 'Stok berhasil ditambahkan ke toko.');
    }


    public function deleteSelected(Request $request)
    {
        $ids = $request->input('ids');

        if (!$ids || !is_array($ids)) {
            return response()->json(['success' => false, 'message' => 'Tidak ada produk yang dipilih.']);
        }

        $blocked = [];
        foreach ($ids as $id) {
            $productIn = ProductIn::with('sales')->find($id);
            if ($productIn && $productIn->sales->isNotEmpty()) {
                $blocked[] = $productIn->product->name ?? 'Produk Tanpa Nama';
            }
        }

        if (!empty($blocked)) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak bisa menghapus produk berikut karena sudah ada data penjualan: ' . implode(', ', $blocked)
            ]);
        }

        ProductIn::whereIn('id', $ids)->delete();

        return response()->json(['success' => true, 'message' => 'Produk terpilih berhasil dihapus!']);
    }
}
