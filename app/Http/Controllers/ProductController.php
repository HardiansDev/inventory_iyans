<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\ProductIn;
use App\Models\Pic;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
// use Barryvdh\DomPDF\Facade as PDF;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $datacategory = Category::all();
        $datasupplier = Supplier::all();


        $products = !empty($search)
            ? Product::where('name', 'LIKE', '%' . $search . '%')
            ->with('category')
            ->paginate(5)
            ->onEachSide(2)
            : Product::with('category')
            ->orderBy('created_at', 'DESC')
            ->paginate(5)
            ->onEachSide(2);

        return view('product.index', compact('products', 'search', 'datacategory', 'datasupplier'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $datacategory = Category::all();
        $datasupplier = Supplier::all();
        $datapic = Pic::all();

        return view('product.create', compact('datacategory', 'datasupplier', 'datapic'));
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
                'supplier_id' => 'nullable|exists:suppliers,id',
                'pic_id' => 'nullable|exists:pics,id',
                'price' => 'required|numeric',
                // 'status' => 'required|max:50',
                'stock' => 'required|string|max:50',
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
                'supplier_id.exists' => 'Supplier yang dipilih tidak valid.',
                'pic_id.exists' => 'PIC yang dipilih tidak valid.',

                'price.required' => 'Harga wajib diisi.',
                'price.numeric' => 'Harga harus berupa angka.',

                'stock.required' => 'Stok wajib diisi.',
                'stock.string' => 'Stok harus berupa teks.',
                'stock.max' => 'Stok tidak boleh lebih dari 50 karakter.',

            ]
        );

        // Handle photo upload (if any)
        if ($request->hasFile('photo')) {
            $filename = time() . '_' . $request->file('photo')->getClientOriginalName();
            $request->file('photo')->move(public_path('fotoproduct'), $filename);
            $validatedData['photo'] = $filename;
        }

        // Create product with validated data
        Product::create($validatedData);

        return redirect()->route('product.index')->with('success', 'Product added successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::with(['category', 'supplier', 'pic'])->findOrFail($id);

        return view('product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $datacategory = Category::all();
        $datasupplier = Supplier::all();
        $datapic = Pic::all();

        return view('product.edit', compact('product', 'datacategory', 'datasupplier', 'datapic'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:50',
            // Ensure unique code, except for the current product
            'code' => 'required|string|max:50|unique:products,code,' . $id,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'category_id' => 'nullable|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'pic_id' => 'nullable|exists:pics,id',
            'price' => 'required|numeric',
            'stock' => 'required|string|max:50',
        ]);

        // Find the product by ID
        $product = Product::findOrFail($id);

        // Handle photo upload (if present)
        if ($request->hasFile('photo')) {
            // Delete old photo if it exists
            if ($product->photo) {
                unlink(public_path('fotoproduct/' . $product->photo));  // Delete the old photo
            }

            // Upload new photo
            $filename = time() . '_' . $request->file('photo')->getClientOriginalName();
            $request->file('photo')->move(public_path('fotoproduct'), $filename);
            $validatedData['photo'] = $filename;
        }

        // Update the product with validated data
        $product->update($validatedData);

        // Redirect with success message
        return redirect()->route('product.index')->with('success', 'Product successfully updated.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product successfully deleted.');
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

    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            Product::whereIn('id', $ids)->delete();
            return response()->json(['success' => true, 'message' => 'Produk terpilih berhasil dihapus!']);
        }
        return response()->json(['success' => false, 'message' => 'Tidak ada produk yang dipilih.']);
    }
}
