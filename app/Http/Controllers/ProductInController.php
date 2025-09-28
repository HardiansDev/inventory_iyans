<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductIn;
use App\Models\Sales;
// use App\Models\Satuan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductInController extends Controller
{
    public function showConfirmation($id)
    {
        $permintaan = ProductIn::with('product')->findOrFail($id);

        return view('product_in.confirm', compact('permintaan'));
    }

    public function approve($id)
    {
        $request = ProductIn::findOrFail($id);

        if ($request->status !== 'menunggu') {
            return redirect()->back()->with('error', 'Permintaan sudah diproses.');
        }

        $product = Product::find($request->product_id);
        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        // Kurangi stok produk
        if ($product->stock < $request->qty) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi.');
        }

        $product->stock -= $request->qty;
        $product->save();

        // Update status permintaan
        $request->status = 'disetujui';
        $request->recipient = Auth::user()->name;
        $request->save();

        // Cek jumlah notifikasi tersisa
        $pendingRequests = ProductIn::where('status', 'menunggu')->count();

        if ($pendingRequests > 3) {
            return redirect()->route('notifications.superadmin')->with('success', 'Permintaan disetujui');
        }

        return redirect()->route('product.index')->with('success', 'Permintaan disetujui');
    }

    public function reject($id, Request $request)
    {
        $request->validate([
            'catatan' => 'required|string|max:255',
        ]);

        $permintaan = ProductIn::findOrFail($id);
        $permintaan->update([
            'status' => 'ditolak',
            'catatan' => $request->catatan,
        ]);

        // Cek jumlah notifikasi tersisa
        $pendingRequests = ProductIn::where('status', 'menunggu')->count();
        if ($pendingRequests > 3) {
            return redirect()->route('notifications.superadmin')->with('error', 'Permintaan ditolak.');
        }

        return redirect()->route('product.index')->with('error', 'Permintaan ditolak.');
    }

    public function index()
    {
        $perPage = request()->query('perPage', 10);
        $query = ProductIn::with(['product.category', 'sales'])->orderBy('date', 'desc');

        // Filter Kategori
        if (request()->filled('category')) {
            $query->whereHas('product', function ($q) {
                $q->where('category_id', request('category'));
            });
        }

        // Filter Status Produk (diterima, ditolak, menunggu)
        if (request()->filled('status_produk')) {
            $query->where('status', request('status_produk'));
        }

        // Filter Status Penjualan (habis, jual)
        if (request()->filled('status_penjualan')) {
            $query->where('status_penjualan', request('status_penjualan'));
        }

        // Filter Harga
        if (request()->filled('min_price') || request()->filled('max_price')) {
            $min = request('min_price') ?? 0;
            $max = request('max_price') ?? 999999999;

            $query->whereHas('product', function ($q) use ($min, $max) {
                $q->whereBetween('price', [$min, $max]);
            });
        }

        // Filter Qty
        if (request()->filled('min_qty') || request()->filled('max_qty')) {
            $min = request('min_qty') ?? 0;
            $max = request('max_qty') ?? 999999;

            $query->whereBetween('qty', [$min, $max]);
        }

        if (request()->filled('search')) {
            $search = request('search');
            $query->whereHas('product', function ($q) use ($search) {
                $q->where('name', 'like', '%'.$search.'%');
            });
        }

        $productIns = $query->paginate($perPage)->appends(request()->query());
        $categories = \App\Models\Category::all();

        return view('productin.index', compact('productIns', 'categories'));
    }

    public function storeProductIn(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|array',
            'product_id.*' => 'exists:products,id',
            'supplier_id' => 'required|array',
            'supplier_id.*' => 'nullable|exists:suppliers,id',
            'category_id' => 'required|array',
            'category_id.*' => 'nullable|exists:categories,id',
            'date' => 'required|array',
            'date.*' => 'required|date',
            'qty' => 'required|array',
            'qty.*' => 'required|integer|min:1',
        ]);

        foreach ($validated['product_id'] as $index => $productId) {
            $requesterName = auth()->user()->name;
            $parsedDate = Carbon::createFromFormat('m/d/Y', $validated['date'][$index])->format('Y-m-d');
            ProductIn::create([
                'product_id' => $productId,
                'supplier_id' => $validated['supplier_id'][$index],
                'category_id' => $validated['category_id'][$index],
                'date' => $parsedDate,
                'qty' => $validated['qty'][$index],

                'requester_name' => $requesterName,
                'status' => 'menunggu',
            ]);
        }

        return redirect()->route('productin.index')
            ->with('success', 'Data produk masuk berhasil ditambahkan dan sedang menunggu persetujuan.');
    }

    public function create()
    {
        $products = Product::all();

        // Kirim data produk ke view
        return view('productin.create', compact('products'));
    }

    public function destroy($id)
    {
        $productIn = ProductIn::with('sales.salesDetails')->findOrFail($id);

        //  Cek stok toko dari semua relasi sales
        $stokToko = $productIn->sales->sum('qty'); // Jumlahkan seluruh qty di sales

        if ($stokToko > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak bisa dihapus karena masih memiliki stok di toko ('.$stokToko.' tersedia).',
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
            'message' => 'Produk berhasil dihapus karena stok di toko sudah habis.',
        ]);
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
                'message' => 'Stok utama produk tidak mencukupi.',
            ], 400);
        }

        $productIn->qty += $qtyTambah;
        $productIn->save();

        $product->stock -= $qtyTambah;
        $product->save();

        // $this->updateStatusPenjualan($productIn);

        // ✅ SELALU RETURN JSON, jangan cek $request->ajax()
        return response()->json([
            'success' => true,
            'message' => 'Stok berhasil ditambahkan ke gudang.',
        ]);
    }

    public function addStockKeToko(Request $request, $productInId)
    {
        try {
            $productIn = ProductIn::with('product')->findOrFail($productInId);
            $qty = (int) $request->input('qty', 1);

            if ($productIn->qty < $qty) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok di gudang tidak mencukupi!',
                ], 400);
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

            $this->updateStatusPenjualan($productIn);

            return response()->json([
                'success' => true,
                'message' => 'Stok berhasil ditambahkan ke toko.',
                'stok_gudang' => $productIn->qty,
                'stok_toko' => $productIn->sales()->sum('qty'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function bulkDelete(Request $request)
    {
        $ids = explode(',', $request->input('ids'));
        ProductIn::whereIn('id', $ids)->delete();

        return redirect()->route('productin.index')->with('success', 'Produk Masuk terpilih berhasil dihapus.');
    }

    public function updateStatusPenjualan(ProductIn $productIn)
    {
        $sales = $productIn->sales()->first();

        if ($sales) {
            $stokToko = $productIn->sales()->sum('qty'); // Pastikan pakai sum()
            if ($stokToko == 0) {
                $productIn->status_penjualan = 'stok habis terjual';
            } elseif ($stokToko < 10) {
                $productIn->status_penjualan = 'stok tinggal dikit';
            } else {
                $productIn->status_penjualan = 'sedang dijual';
            }
        } else {
            $productIn->status_penjualan = 'belum dijual';
        }

        $productIn->save();
    }

    public function sale(Request $request, $id)
    {
        try {
            $productIn = ProductIn::with('product', 'sales')->findOrFail($id);

            $qty = (int) $request->input('qty', 0);

            if ($qty < 1) {
                return response()->json(['success' => false, 'message' => 'Qty minimal 1'], 400);
            }

            if ($qty > $productIn->qty) {
                return response()->json(['success' => false, 'message' => 'Stok gudang tidak cukup'], 400);
            }

            // cek apakah produk sudah ada di sales (etalase toko)
            $sales = Sales::where('product_ins_id', $productIn->id)->first();

            if ($sales) {
                $sales->qty += $qty;
                $sales->save();
            } else {
                Sales::create([
                    'product_ins_id' => $productIn->id,
                    'qty' => $qty,
                ]);
            }

            // kurangi stok gudang
            $productIn->qty -= $qty;

            // 🔥 Update status_penjualan
            $stokToko = $productIn->sales->sum('qty') + $qty; // stok yang ada di toko setelah ditambah
            if ($stokToko <= 0) {
                $productIn->status_penjualan = 'stok habis terjual';
            } elseif ($stokToko <= 3) { // misal threshold dikit = 3
                $productIn->status_penjualan = 'stok tinggal dikit';
            } else {
                $productIn->status_penjualan = 'sedang dijual';
            }

            $productIn->save();

            return response()->json([
                'success' => true,
                'message' => "Produk {$productIn->product->name} berhasil dipindahkan ke etalase penjualan (toko).",
                'stokToko' => $stokToko,
                'statusPenjualan' => $productIn->status_penjualan,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
