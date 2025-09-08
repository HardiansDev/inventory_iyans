<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function penjualan(Request $request)
    {
        $start = $request->query('start');
        $end   = $request->query('end');

        $query = SalesDetail::query();

        if ($start && $end) {
            $query->whereBetween('salesdetails.created_at', [
                $start . ' 00:00:00',
                $end . ' 23:59:59',
            ]);
        }

        // Ambil data detail transaksi
        $penjualans = $query->with('sales.productIn.product')
            ->orderBy('salesdetails.created_at', 'desc')
            ->get();

        // Hitung total sesuai rumus (harga * qty - diskon)
        $total = SalesDetail::join('sales', 'sales.id', '=', 'salesdetails.sales_id')
            ->leftJoin('discounts', 'salesdetails.discount_id', '=', 'discounts.id');

        if ($start && $end) {
            $total->whereBetween('salesdetails.created_at', [
                $start . ' 00:00:00',
                $end . ' 23:59:59',
            ]);
        }

        $total = $total->select(DB::raw('
            SUM((salesdetails.price * salesdetails.qty)
            - ((salesdetails.price * salesdetails.qty) * (COALESCE(discounts.nilai, 0) / 100))) as total
        '))->value('total');

        return view('report.penjualan', compact('penjualans', 'start', 'end', 'total'));
    }

    public function penjualanPdf(Request $request)
    {
        $start = $request->query('start');
        $end   = $request->query('end');

        $query = SalesDetail::query();

        if ($start && $end) {
            $startDate = Carbon::createFromFormat('m/d/Y', $start)->startOfDay()->format('Y-m-d H:i:s');
            $endDate   = Carbon::createFromFormat('m/d/Y', $end)->endOfDay()->format('Y-m-d H:i:s');

            $query->whereBetween('salesdetails.date_order', [$startDate, $endDate]);
        }

        // Ambil data detail transaksi
        $penjualans = $query->with('sales.productIn.product')
            ->orderBy('salesdetails.date_order', 'desc')
            ->get();

        // Hitung total sesuai rumus
        $total = SalesDetail::join('sales', 'sales.id', '=', 'salesdetails.sales_id')
            ->leftJoin('discounts', 'salesdetails.discount_id', '=', 'discounts.id');

        if ($start && $end) {
            $startDate = Carbon::createFromFormat('m/d/Y', $start)->startOfDay()->format('Y-m-d H:i:s');
            $endDate   = Carbon::createFromFormat('m/d/Y', $end)->endOfDay()->format('Y-m-d H:i:s');

            $total->whereBetween('salesdetails.date_order', [$startDate, $endDate]);
        }

        $total = $total->select(DB::raw('
            SUM((salesdetails.price * salesdetails.qty)
            - ((salesdetails.price * salesdetails.qty) * (COALESCE(discounts.nilai, 0) / 100))) as total
        '))->value('total');

        $pdf = Pdf::loadView('report.penjualan_pdf', compact('penjualans', 'start', 'end', 'total'));

        return $pdf->download("laporan_penjualan_{$start}_to_{$end}.pdf");
    }
}
