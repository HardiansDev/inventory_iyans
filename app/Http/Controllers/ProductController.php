<?php

namespace App\Http\Controllers;


use App\Models\Product;
use App\Models\Category;
use App\Models\Satuan;

use Illuminate\Http\Request;
use App\Exports\ProductsExport;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;



class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $search = $request->query('search');
        $categoryName = $request->query('category');

        $datacategory = Category::all();
        $satuans = Satuan::all();

        $query = Product::with(['category', 'productins']);

        // Filter kategori jika dipilih
        if (!empty($categoryName)) {
            $query->whereHas('category', function ($q) use ($categoryName) {
                $q->where('name', $categoryName);
            });
        }

        // Filter pencarian nama produk jika diisi
        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
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
            'code' => 'required|string|max:50|unique:products,code,' . $id,
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

        // Ambil data produk, dengan atau tanpa filter kategori
        $products = $category ? Product::whereHas('category', function ($query) use ($category) {
            $query->where('name', $category);
        })->get() : Product::all();

        // Ekspor ke Excel atau PDF sesuai dengan permintaan
        if ($exportType == 'excel') {
            return Excel::download(new ProductsExport($products), 'products.xlsx');
        }

        if ($exportType == 'pdf') {
            // Render ke view PDF
            return PDF::loadView('pdf.products', compact('products'))->download('products.pdf');
        }
    }

    public function bulkDelete(Request $request)
    {
        $ids = explode(',', $request->input('ids'));
        Product::whereIn('id', $ids)->delete();

        return redirect()->route('product.index')->with('success', 'Produk terpilih berhasil dihapus.');
    }


    // ini pdf per showing data
    public function downloadPdf(Request $request)
    {
        // Validasi input
        $ids = $request->input('ids');
        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'Tidak ada data terpilih.'], 400);
        }

        // Ambil data berdasarkan ID yang dikirim
        $products = Product::whereIn('id', $ids)->get();

        // Render PDF menggunakan view
        $pdf = PDF::loadView('pdf.products', ['products' => $products]);

        // Kirim file PDF ke browser
        return $pdf->download('Produk_Terpilih.pdf');
    }

    // ini excel per showing data
    public function downloadExcel(Request $request)
    {
        // Validasi input
        $ids = $request->input('ids');
        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'Tidak ada data terpilih.'], 400);
        }

        // Ambil data berdasarkan ID yang dikirim
        $products = Product::whereIn('id', $ids)->get();

        // Gunakan Export untuk membuat file Excel
        return Excel::download(new ProductsExport($products), 'Produk_Terpilih.xlsx');
    }
}
