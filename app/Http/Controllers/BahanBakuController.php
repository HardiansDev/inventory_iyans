<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\Category;
use App\Models\Satuan;
use App\Models\Supplier;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class BahanBakuController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $query = BahanBaku::with(['supplier', 'category', 'satuan']);

        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%")
                ->orWhereHas('supplier', fn ($q) => $q->where('name', 'LIKE', "%{$search}%"))
                ->orWhereHas('category', fn ($q) => $q->where('name', 'LIKE', "%{$search}%"))
                ->orWhereHas('satuan', fn ($q) => $q->where('nama_satuan', 'LIKE', "%{$search}%"));
        }

        $bahanBakus = $query->paginate(10);

        return view('bahan_baku.index', compact('bahanBakus', 'search'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $categories = Category::all();
        $satuans = Satuan::all();

        return view('bahan_baku.create', compact('suppliers', 'categories', 'satuans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'category_id' => 'nullable|exists:categories,id',
            'satuan_id' => 'nullable|exists:satuans,id',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        BahanBaku::create($request->all());

        return redirect()->route('bahan_baku.index')->with('success', 'Bahan Baku berhasil ditambahkan.');
    }

    public function show($id)
    {
        $bahanBaku = BahanBaku::with(['supplier', 'category', 'satuan'])->findOrFail($id);

        return view('bahan_baku.show', compact('bahanBaku'));
    }

    public function edit($id)
    {
        $bahanBaku = BahanBaku::findOrFail($id);
        $suppliers = Supplier::all();
        $categories = Category::all();
        $satuans = Satuan::all();

        return view('bahan_baku.edit', compact('bahanBaku', 'suppliers', 'categories', 'satuans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'category_id' => 'nullable|exists:categories,id',
            'satuan_id' => 'nullable|exists:satuans,id',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $bahanBaku = BahanBaku::findOrFail($id);
        $bahanBaku->update($request->all());

        return redirect()->route('bahan_baku.index')->with('success', 'Bahan Baku berhasil diupdate.');
    }

    public function destroy($id)
    {
        $bahanBaku = BahanBaku::findOrFail($id);
        $bahanBaku->delete();

        return redirect()->route('bahan_baku.index')->with('success', 'Bahan Baku berhasil dihapus.');
    }

    public function reportPdf()
    {
        $bahanBaku = BahanBaku::all();

        $pdf = Pdf::loadView('bahan_baku.report_pdf', compact('bahanBaku'));

        return $pdf->stream('laporan-bahan-baku.pdf');
    }
}
