<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\Employee;
use App\Models\Product;
use App\Models\ProductIn;
use App\Models\SalesDetail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Title;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik dashboard
        $totalProduk = Product::count();
        $totalBahanBaku = BahanBaku::count();
        // Sum harga bahan baku (misal harga * stok)
        $totalModal = BahanBaku::sum(DB::raw('price * stock'));
        $produkMasuk = ProductIn::sum('qty');
        $produkKeluar = SalesDetail::sum('qty');
        $totalUser = User::count();
        // Hitung pendapatan hari ini (termasuk diskon kalau ada)
        $penjualanHariIni = SalesDetail::join('sales', 'sales.id', '=', 'salesdetails.sales_id')
            ->leftJoin('discounts', 'salesdetails.discount_id', '=', 'discounts.id')
            ->whereDate('salesdetails.created_at', Carbon::today())
            ->select(DB::raw('SUM((salesdetails.price * salesdetails.qty) - ((salesdetails.price * salesdetails.qty) * (COALESCE(discounts.nilai, 0) / 100))) as total'))
            ->value('total');

        $penjualanHariIni = $penjualanHariIni ?? 0; // fallback biar gak null
        $totalModal = $totalModal ?? 0;

        // Hitung keuntungan hari ini
        $keuntunganHariIni = $penjualanHariIni > $totalModal
            ? $penjualanHariIni - $totalModal
            : 0;
        $transaksiHariIni = SalesDetail::whereDate('created_at', today())->count();
        $pegawaiAktif = Employee::where('is_active', 1)->count();
        $pegawaiTidakAktif = Employee::where('is_active', 0)->count();

        // Data Produk (stok per produk)
        $products = Product::select('name', 'stock')->get();
        $productNames = $products->pluck('name');
        $productStocks = $products->pluck('stock');

        // Produk Masuk (group by product name)
        $inData = ProductIn::with('product')
            ->selectRaw('product_id, SUM(qty) as total_qty')
            ->groupBy('product_id')
            ->get();

        $inLabels = $inData->map(fn ($item) => $item->product->name ?? 'Produk Tidak Ditemukan');
        $inQtys = $inData->pluck('total_qty');

        // Produk Keluar (group by sales -> productIn -> product)
        $outData = SalesDetail::with('sales.productIn.product')
            ->selectRaw('sales_id, SUM(qty) as total_qty')
            ->groupBy('sales_id')
            ->get();

        $outLabels = $outData->map(
            fn ($item) => $item->sales->productIn->product->name ?? 'Produk Tidak Ditemukan'
        );
        $outQtys = $outData->pluck('total_qty');

        $startOfDay = Carbon::now()->startOfDay();
        $endOfDay = Carbon::now()->endOfDay();

        $performaKasirHariIni = SalesDetail::join('sales', 'sales.id', '=', 'salesdetails.sales_id')
            ->leftJoin('discounts', 'salesdetails.discount_id', '=', 'discounts.id')
            ->join('users', 'users.id', '=', 'salesdetails.created_by')
            ->whereDate('salesdetails.created_at', Carbon::today())
            ->groupBy('users.name')
            ->select(
                'users.name as kasir',
                DB::raw('COUNT(DISTINCT salesdetails.transaction_number) as transaksi'),
                DB::raw('SUM((salesdetails.price * salesdetails.qty) - ((salesdetails.price * salesdetails.qty) * (COALESCE(discounts.nilai, 0) / 100))) as total_penjualan')
            )
            ->get();

        $aktivitasHariIni = SalesDetail::with(['sales.productIn.product', 'sales.user'])
            ->whereDate('salesdetails.created_at', Carbon::today())
            ->join('sales', 'sales.id', '=', 'salesdetails.sales_id')
            ->leftJoin('discounts', 'salesdetails.discount_id', '=', 'discounts.id') // JOIN ke diskon
            ->join('product_ins', 'product_ins.id', '=', 'sales.product_ins_id')
            ->join('products', 'products.id', '=', 'product_ins.product_id')
            ->select(
                'salesdetails.created_at',
                'products.name as product_name',
                'salesdetails.qty',
                'salesdetails.metode_pembayaran',
                DB::raw('salesdetails.price * salesdetails.qty as subtotal'),
                DB::raw('COALESCE(discounts.nilai, 0) as discount'),
                DB::raw('(salesdetails.price * salesdetails.qty) - ((salesdetails.price * salesdetails.qty) * (COALESCE(discounts.nilai, 0) / 100)) as total')
            )
            ->orderBy('salesdetails.created_at', 'desc')
            ->paginate(10);

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
        Carbon::setLocale('id');
        $allDates = $dailySales->pluck('date')->unique()->sort()->values();
        $dailyLabels = $allDates->map(fn ($d) => Carbon::parse($d)->format('d/m/Y'));
        $dailyByProduct = [];
        foreach ($groupedDaily as $product => $data) {
            $values = [];
            foreach ($allDates as $date) {
                $values[] = $data[$date] ?? 0;
            }
            $dailyByProduct[] = [
                'label' => $product,
                'data' => $values,
                'borderColor' => 'rgba('.rand(50, 255).','.rand(50, 255).','.rand(50, 255).',1)',
                'backgroundColor' => 'rgba('.rand(50, 255).','.rand(50, 255).','.rand(50, 255).',0.4)',
                'fill' => false,
                'tension' => 0.4,
                'pointRadius' => 4,
                'pointHoverRadius' => 6,
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
        $weekLabels = $allWeeks->map(fn ($w) => 'Minggu ke-'.intval(substr($w, -2)).' - '.Carbon::now()->year);
        $weeklyByProduct = [];
        foreach ($groupedWeekly as $product => $data) {
            $values = [];
            foreach ($allWeeks as $week) {
                $values[] = $data[$week] ?? 0;
            }
            $weeklyByProduct[] = [
                'label' => $product,
                'data' => $values,
                'backgroundColor' => 'rgba('.rand(50, 255).','.rand(50, 255).','.rand(50, 255).',0.6)',
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
        $monthLabels = $allMonths->map(fn ($m) => Carbon::parse($m.'-01')->translatedFormat('F Y'));
        $monthlyByProduct = [];
        foreach ($groupedMonthly as $product => $data) {
            $values = [];
            foreach ($allMonths as $month) {
                $values[] = $data[$month] ?? 0;
            }
            $monthlyByProduct[] = [
                'label' => $product,
                'data' => $values,
                'backgroundColor' => 'rgba('.rand(50, 255).','.rand(50, 255).','.rand(50, 255).',0.6)',
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
        $allYears = collect([2024])->merge(
            $yearlySales->pluck('year')->unique()->sort()->values()
        )->unique()->sort()->values();

        $yearLabels = $allYears;
        $yearlyByProduct = [];
        foreach ($groupedYearly as $product => $data) {
            $values = [];
            foreach ($allYears as $year) {
                $values[] = $data[$year] ?? 0;
            }
            $colorR = rand(50, 255);
            $colorG = rand(50, 255);
            $colorB = rand(50, 255);

            $yearlyByProduct[] = [
                'label' => $product,
                'data' => $values,
                'borderColor' => "rgba($colorR, $colorG, $colorB, 1)", // Garisnya
                'backgroundColor' => "rgba($colorR, $colorG, $colorB, 0.3)", // Area fill (optional)
                'fill' => false,
                'tension' => 0.4,
                'pointRadius' => 4,
                'pointHoverRadius' => 6,
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

        $dailyTotals = collect($dailyByProduct)->flatMap(function ($dataset) use ($dailyLabels) {
            return collect($dataset['data'])->map(function ($val, $index) use ($dataset, $dailyLabels) {
                return [
                    'tanggal' => $dailyLabels[$index],
                    'product' => $dataset['label'],
                    'total' => $val,
                ];
            });
        });

        // Mingguan per produk
        $weeklyTotals = collect($weeklyByProduct)->flatMap(function ($dataset) use ($weekLabels) {
            return collect($dataset['data'])->map(function ($val, $index) use ($dataset, $weekLabels) {
                return [
                    'week' => $weekLabels[$index],
                    'product' => $dataset['label'],
                    'total' => $val,
                ];
            });
        });

        // Bulanan per produk
        $monthlyTotals = collect($monthlyByProduct)->flatMap(function ($dataset) use ($monthLabels) {
            return collect($dataset['data'])->map(function ($val, $index) use ($dataset, $monthLabels) {
                return [
                    'month' => $monthLabels[$index],
                    'product' => $dataset['label'],
                    'total' => $val,
                ];
            });
        });

        // Tahunan per produk
        $yearlyTotals = collect($yearlyByProduct)->flatMap(function ($dataset) use ($yearLabels) {
            return collect($dataset['data'])->map(function ($val, $index) use ($dataset, $yearLabels) {
                return [
                    'year' => $yearLabels[$index],
                    'product' => $dataset['label'],
                    'total' => $val,
                ];
            });
        });

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
            'title',
            'penjualanHariIni',
            'transaksiHariIni',
            'pegawaiAktif',
            'pegawaiTidakAktif',
            'aktivitasHariIni',
            'performaKasirHariIni',
            'totalBahanBaku',
            'totalModal',
            'keuntunganHariIni',
            'dailyTotals',
            'weeklyTotals',
            'monthlyTotals',
            'yearlyTotals',
        ));
    }

    public function exportExcel(Request $request)
    {
        $filter = $request->query('type', 'daily'); // daily|weekly|monthly|yearly

        // Ambil data dari session / service / method index
        // Bisa dioptimalkan dengan memanggil method yang sama atau service class
        $dashboardData = app()->call('App\Http\Controllers\DashboardController@index');

        switch ($filter) {
            case 'weekly':
                $labels = $dashboardData['weekLabels'];
                $datasets = $dashboardData['weeklyByProduct'];
                $title = 'Penjualan per Minggu';
                break;
            case 'monthly':
                $labels = $dashboardData['monthLabels'];
                $datasets = $dashboardData['monthlyByProduct'];
                $title = 'Penjualan per Bulan';
                break;
            case 'yearly':
                $labels = $dashboardData['yearLabels'];
                $datasets = $dashboardData['yearlyByProduct'];
                $title = 'Penjualan per Tahun';
                break;
            default:
                $labels = $dashboardData['dailyLabels'];
                $datasets = $dashboardData['dailyByProduct'];
                $title = 'Penjualan per Hari';
                break;
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheetTitle = $sheet->getTitle();

        // === Header ===
        $sheet->setCellValue('A1', ucfirst($filter === 'daily' ? 'Tanggal' : ($filter === 'weekly' ? 'Minggu' : ($filter === 'monthly' ? 'Bulan' : 'Tahun'))));

        $colIndex = 2;
        $productColumns = [];
        foreach ($datasets as $ds) {
            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
            $sheet->setCellValue($colLetter.'1', $ds['label']);
            $productColumns[] = $colLetter;
            ++$colIndex;
        }

        // === Isi data ===
        $row = 2;
        foreach ($labels as $i => $label) {
            $sheet->setCellValue('A'.$row, $label);
            foreach ($datasets as $pIndex => $ds) {
                $col = $productColumns[$pIndex];
                $sheet->setCellValue($col.$row, $ds['data'][$i] ?? 0);
            }
            ++$row;
        }
        $lastRow = $row - 1;

        // === Styling header ===
        $headerRange = 'A1:'.end($productColumns).'1';
        $sheet->getStyle($headerRange)->getFont()->setBold(true);
        $sheet->getStyle($headerRange)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('F3F4F6');
        $sheet->getStyle($headerRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        foreach (range('A', end($productColumns)) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // === Chart ===
        $dataSeriesLabels = [];
        foreach ($productColumns as $col) {
            $dataSeriesLabels[] = new DataSeriesValues('String', $sheetTitle.'!$'.$col.'$1', null, 1);
        }

        $xAxisTickValues = [new DataSeriesValues('String', $sheetTitle.'!$A$2:$A$'.$lastRow, null, (int) ($lastRow - 1))];

        $dataSeriesValues = [];
        foreach ($productColumns as $col) {
            $dataSeriesValues[] = new DataSeriesValues('Number', $sheetTitle.'!$'.$col.'$2:$'.$col.'$'.$lastRow, null, (int) ($lastRow - 1));
        }

        $series = new DataSeries(
            DataSeries::TYPE_BARCHART,
            DataSeries::GROUPING_CLUSTERED,
            range(0, count($dataSeriesValues) - 1),
            $dataSeriesLabels,
            $xAxisTickValues,
            $dataSeriesValues
        );
        $series->setPlotDirection(DataSeries::DIRECTION_COL);

        $plotArea = new PlotArea(null, [$series]);
        $legend = new Legend(Legend::POSITION_RIGHT, null, false);
        $chartTitle = new Title($title);

        $chart = new Chart('chart1', $chartTitle, $legend, $plotArea);
        $chart->setTopLeftPosition('A'.($lastRow + 2));
        $chart->setBottomRightPosition('M'.($lastRow + 20));
        $sheet->addChart($chart);

        // === Save file ===
        $fileName = "laporan-{$filter}-".now()->format('Ymd_His').'.xlsx';
        $filePath = storage_path('app/public/exports/'.$fileName);

        if (!file_exists(dirname($filePath))) {
            mkdir(dirname($filePath), 0755, true);
        }

        $writer = new Xlsx($spreadsheet);
        $writer->setIncludeCharts(true);
        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend(true);
    }
}
