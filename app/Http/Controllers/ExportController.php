<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;


class ExportController extends Controller
{
    // Export PDF
    public function pdf(Request $request)
    {
        $ids = explode(',', $request->ids);
        $products = Product::whereIn('id', $ids)->get();

        $pdf = PDF::loadView('exports.products-pdf', compact('products'));

        return $pdf->download('data-produk-terpilih.pdf');
    }

    // Export Excel
    public function excel(Request $request)
    {
        $ids = explode(',', $request->ids);

        $products = Product::with(['category', 'supplier'])->whereIn('id', $ids)->get();
        return Excel::download(new ProductsExport($products), 'data-produk-terpilih.xlsx');
    }
}
