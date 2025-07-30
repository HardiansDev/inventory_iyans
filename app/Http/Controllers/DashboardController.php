<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductIn;
use App\Models\SalesDetail;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
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

        // Penjualan Harian by Produk
        $dailySales = SalesDetail::with('sales.productIn.product')
            ->selectRaw('DATE(salesdetails.created_at) as date, products.name as product_name, SUM(salesdetails.qty) as total')
            ->join('sales', 'sales.id', '=', 'salesdetails.sales_id')
            ->join('product_ins', 'product_ins.id', '=', 'sales.product_ins_id')
            ->join('products', 'products.id', '=', 'product_ins.product_id')
            ->groupBy(DB::raw('DATE(salesdetails.created_at)'), 'products.name')
            ->orderBy('date')
            ->get();

        $groupedDaily = [];
        foreach ($dailySales as $sale) {
            $groupedDaily[$sale->product_name][$sale->date] = $sale->total;
        }
        $allDates = $dailySales->pluck('date')->unique()->sort()->values();
        $dailyLabels = $allDates->map(fn($d) => Carbon::parse($d)->isoFormat('D MMMM Y (dddd)'));
        $dailyByProduct = [];
        foreach ($groupedDaily as $product => $data) {
            $values = [];
            foreach ($allDates as $date) {
                $values[] = $data[$date] ?? 0;
            }
            $dailyByProduct[] = [
                'label' => $product,
                'data' => $values,
                'backgroundColor' => 'rgba(' . rand(50, 255) . ',' . rand(50, 255) . ',' . rand(50, 255) . ',0.6)'
            ];
        }
        $dailyValues = $dailyByProduct;

        // Penjualan Mingguan by Produk
        $weeklySales = SalesDetail::with('sales.productIn.product')
            ->selectRaw('YEARWEEK(salesdetails.created_at, 1) as week, products.name as product_name, SUM(salesdetails.qty) as total')
            ->join('sales', 'sales.id', '=', 'salesdetails.sales_id')
            ->join('product_ins', 'product_ins.id', '=', 'sales.product_ins_id')
            ->join('products', 'products.id', '=', 'product_ins.product_id')
            ->where('salesdetails.created_at', '>=', Carbon::now()->subWeeks(4))
            ->groupBy('week', 'products.name')
            ->orderBy('week')
            ->get();

        $groupedWeekly = [];
        foreach ($weeklySales as $sale) {
            $groupedWeekly[$sale->product_name][$sale->week] = $sale->total;
        }
        $allWeeks = $weeklySales->pluck('week')->unique()->sort()->values();
        $weekLabels = $allWeeks->map(fn($w) => 'Minggu ke-' . intval(substr($w, -2)) . ' - ' . Carbon::now()->year);
        $weeklyByProduct = [];
        foreach ($groupedWeekly as $product => $data) {
            $values = [];
            foreach ($allWeeks as $week) {
                $values[] = $data[$week] ?? 0;
            }
            $weeklyByProduct[] = [
                'label' => $product,
                'data' => $values,
                'backgroundColor' => 'rgba(' . rand(50, 255) . ',' . rand(50, 255) . ',' . rand(50, 255) . ',0.6)'
            ];
        }
        $weekValues = $weeklyByProduct;

        // Penjualan Bulanan by Produk
        $monthlySales = SalesDetail::with('sales.productIn.product')
            ->selectRaw('DATE_FORMAT(salesdetails.created_at, "%Y-%m") as month, products.name as product_name, SUM(salesdetails.qty) as total')
            ->join('sales', 'sales.id', '=', 'salesdetails.sales_id')
            ->join('product_ins', 'product_ins.id', '=', 'sales.product_ins_id')
            ->join('products', 'products.id', '=', 'product_ins.product_id')
            ->where('salesdetails.created_at', '>=', Carbon::now()->subMonths(6)->startOfMonth())
            ->groupBy('month', 'products.name')
            ->orderBy('month')
            ->get();

        $groupedMonthly = [];
        foreach ($monthlySales as $sale) {
            $groupedMonthly[$sale->product_name][$sale->month] = $sale->total;
        }
        $allMonths = $monthlySales->pluck('month')->unique()->sort()->values();
        $monthLabels = $allMonths->map(fn($m) => Carbon::parse($m . '-01')->translatedFormat('F Y'));
        $monthlyByProduct = [];
        foreach ($groupedMonthly as $product => $data) {
            $values = [];
            foreach ($allMonths as $month) {
                $values[] = $data[$month] ?? 0;
            }
            $monthlyByProduct[] = [
                'label' => $product,
                'data' => $values,
                'backgroundColor' => 'rgba(' . rand(50, 255) . ',' . rand(50, 255) . ',' . rand(50, 255) . ',0.6)'
            ];
        }
        $monthValues = $monthlyByProduct;

        // Penjualan Tahunan by Produk
        $yearlySales = SalesDetail::with('sales.productIn.product')
            ->selectRaw('YEAR(salesdetails.created_at) as year, products.name as product_name, SUM(salesdetails.qty) as total')
            ->join('sales', 'sales.id', '=', 'salesdetails.sales_id')
            ->join('product_ins', 'product_ins.id', '=', 'sales.product_ins_id')
            ->join('products', 'products.id', '=', 'product_ins.product_id')
            ->groupBy('year', 'products.name')
            ->orderBy('year')
            ->get();

        $groupedYearly = [];
        foreach ($yearlySales as $sale) {
            $groupedYearly[$sale->product_name][$sale->year] = $sale->total;
        }
        $allYears = $yearlySales->pluck('year')->unique()->sort()->values();
        $yearLabels = $allYears;
        $yearlyByProduct = [];
        foreach ($groupedYearly as $product => $data) {
            $values = [];
            foreach ($allYears as $year) {
                $values[] = $data[$year] ?? 0;
            }
            $yearlyByProduct[] = [
                'label' => $product,
                'data' => $values,
                'backgroundColor' => 'rgba(' . rand(50, 255) . ',' . rand(50, 255) . ',' . rand(50, 255) . ',0.6)'
            ];
        }
        $yearValues = $yearlyByProduct;

        $filter = request('filter', 'daily');

        switch ($filter) {
            case 'weekly':
                $labels = $weekLabels;
                $values = $weekValues;
                $title = 'Penjualan per Minggu';
                break;
            case 'monthly':
                $labels = $monthLabels;
                $values = $monthValues;
                $title = 'Penjualan per Bulan';
                break;
            case 'yearly':
                $labels = $yearLabels;
                $values = $yearValues;
                $title = 'Penjualan per Tahun';
                break;
            default:
                $labels = $dailyLabels;
                $values = $dailyValues;
                $title = 'Penjualan per Hari';
                break;
        }


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
            'outQtys',
            'dailyLabels',
            'dailyValues',
            'dailyByProduct',
            'weekLabels',
            'weekValues',
            'weeklyByProduct',
            'monthLabels',
            'monthValues',
            'monthlyByProduct',
            'yearLabels',
            'yearValues',
            'yearlyByProduct',
            'filter',
            'labels',
            'values',
            'title'
        ));
    }
}