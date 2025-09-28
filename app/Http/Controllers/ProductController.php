<?php

namespace App\Http\Controllers;

use App\Exports\ProductsExport;
use App\Models\Category;
use App\Models\Product;
use App\Models\Satuan;
use Barryvdh\DomPDF\Facade\Pdf;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $categoryName = $request->query('category');

        $satuans = Satuan::all();

        // Ambil semua kategori
        $datacategory = Category::query();

        // Ambil kategori yang dipakai oleh bahan baku
        $excludedCategoryIds = \App\Models\BahanBaku::pluck('category_id')->toArray();

        // Filter supaya kategori bahan baku tidak muncul di dropdown product
        if (!empty($excludedCategoryIds)) {
            $datacategory->whereNotIn('id', $excludedCategoryIds);
        }

        $datacategory = $datacategory->get();

        $query = Product::with(['category', 'productins']);

        // Filter kategori jika dipilih
        if (!empty($categoryName)) {
            $query->whereHas('category', function ($q) use ($categoryName) {
                $q->where('name', $categoryName);
            });
        }

        // Filter pencarian nama produk jika diisi
        if (!empty($search)) {
            $query->where('name', 'like', '%'.$search.'%');
        }

        // Ambil nilai perPage dari query string, default 5
        $perPage = request()->query('perPage', 5);

        // Ambil produk sesuai filter, urut terbaru
        $products = $query->orderBy('created_at', 'DESC')->paginate($perPage);

        // Hitung qty diterima dan ditolak
        $products->getCollection()->transform(function ($product) {
            $product->qty_diterima = $product->productins->where('status', 'diterima')->sum('qty');
            $product->qty_ditolak = $product->productins->where('status', 'ditolak')->sum('qty');

            return $product;
        });

        return view('product.index', compact('products', 'search', 'datacategory', 'satuans'));
    }

    public function getProductDetails($productId)
    {
        // Ambil data produk berdasarkan ID
        $product = Product::findOrFail($productId);

        // Kirimkan data category_id sebagai response JSON
        return response()->json([
            'category_id' => $product->category_id,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $datacategory = Category::all();
        $satuans = Satuan::all();

        return view('product.create', compact('datacategory', 'satuans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'name' => 'required|string|max:30',
                'code' => 'required|string|max:50',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'category_id' => 'nullable|exists:categories,id',
                'price' => 'required|numeric',
                'stock' => 'required|string|max:50',
                'satuan_id' => 'nullable|exists:satuans,id',
            ],
            [
                'name.required' => 'Nama produk wajib diisi.',
                'name.string' => 'Nama produk harus berupa teks.',
                'name.max' => 'Nama produk tidak boleh lebih dari 30 karakter.',

                'code.required' => 'Kode produk wajib diisi.',
                'code.string' => 'Kode produk harus berupa teks.',
                'code.max' => 'Kode produk tidak boleh lebih dari 50 karakter.',

                'photo.image' => 'Foto harus berupa file gambar.',
                'photo.mimes' => 'Foto hanya boleh memiliki format jpeg, png, atau jpg.',
                'photo.max' => 'Ukuran foto tidak boleh lebih dari 2 MB.',

                'category_id.exists' => 'Kategori yang dipilih tidak valid.',

                'price.required' => 'Harga wajib diisi.',
                'price.numeric' => 'Harga harus berupa angka.',

                'stock.required' => 'Stok wajib diisi.',
                'stock.string' => 'Stok harus berupa teks.',
                'stock.max' => 'Stok tidak boleh lebih dari 50 karakter.',
                'satuan_id.exists' => 'Satuan yang dipilih tidak valid.',
            ]
        );

        if ($request->hasFile('photo')) {
            $uploadedFileUrl = Cloudinary::upload($request->file('photo')->getRealPath())->getSecurePath();
            $validatedData['photo'] = $uploadedFileUrl; // langsung URL
        }

        Product::create($validatedData);

        return redirect()->route('product.index')->with('success', 'Produk ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::with(['category'])->findOrFail($id);

        return view('product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $datacategory = Category::all();
        $satuans = Satuan::all();

        return view('product.edit', compact('product', 'datacategory', 'satuans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:50',
            'code' => 'required|string|max:50|unique:products,code,'.$id,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric',
            'stock' => 'required|string|max:50',
            'satuan_id' => 'nullable|exists:satuans,id',
        ]);

        $product = Product::findOrFail($id);

        if ($request->hasFile('photo')) {
            // Hapus foto lama (kalau sebelumnya pakai Cloudinary juga)
            if ($product->photo) {
                Cloudinary::destroy($product->photo); // jika simpan public_id
            }

            $uploadedFileUrl = Cloudinary::upload($request->file('photo')->getRealPath())->getSecurePath();
            $validatedData['photo'] = $uploadedFileUrl;
        }

        $product->update($validatedData);

        // Redirect with success message
        return redirect()->route('product.index')->with('success', 'Produk Telah di Update.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('product.index')->with('success', 'Produk Telah di Hapus.');
    }

    public function export(Request $request)
    {
        $category = $request->input('category');
        $exportType = $request->input('export_type');

        // Ambil data produk + relasi
        $products = Product::with(['category', 'satuan'])
            ->when($category, function ($query) use ($category) {
                $query->whereHas('category', function ($q) use ($category) {
                    $q->where('name', $category);
                });
            })
            ->get();

        // Cek dulu apakah relasi sudah jalan
        // dd($products->first()->satuan);

        // Ekspor ke Excel
        if ($exportType === 'excel') {
            return Excel::download(
                new ProductsExport($products),
                'products.xlsx'
            );
        }

        // Ekspor ke PDF
        if ($exportType === 'pdf') {
            $pdf = Pdf::loadView('pdf.products', compact('products'));

            return $pdf->download('products.pdf');
        }

        return back()->with('error', 'Jenis export tidak valid.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = explode(',', $request->input('ids'));
        Product::whereIn('id', $ids)->delete();

        return redirect()->route('product.index')->with('success', 'Produk terpilih berhasil dihapus.');
    }
}
