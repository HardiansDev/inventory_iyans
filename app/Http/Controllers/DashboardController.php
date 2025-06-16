<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductIn;
use App\Models\SalesDetail;
use App\Models\User;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik dashboard
        $totalProduk = Product::count();
        $produkMasuk = ProductIn::sum('qty');
        $produkKeluar = SalesDetail::sum('qty');
        $totalUser = User::count();

        // Data Produk (stok per produk)
        $products = Product::select('name', 'stock')->get();
        $productNames = $products->pluck('name');
        $productStocks = $products->pluck('stock');

        // Produk Masuk (group by product name)
        $inData = ProductIn::with('product')
            ->selectRaw('product_id, SUM(qty) as total_qty')
            ->groupBy('product_id')
            ->get();

        $inLabels = $inData->map(fn($item) => $item->product->name ?? 'Produk Tidak Ditemukan');
        $inQtys = $inData->pluck('total_qty');

        // Produk Keluar (group by sales -> productIn -> product)
        $outData = SalesDetail::with('sales.productIn.product')
            ->selectRaw('sales_id, SUM(qty) as total_qty')
            ->groupBy('sales_id')
            ->get();

        $outLabels = $outData->map(
            fn($item) =>
            $item->sales->productIn->product->name ?? 'Produk Tidak Ditemukan'
        );
        $outQtys = $outData->pluck('total_qty');

        return view('dashboard', compact(
            'totalProduk',
            'produkMasuk',
            'produkKeluar',
            'totalUser',
            'productNames',
            'productStocks',
            'inLabels',
            'inQtys',
            'outLabels',
            'outQtys'
        ));
    }
}
