<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;



class ReportController extends Controller
{
    public function penjualan(Request $request)
    {
        $start = $request->query('start');
        $end = $request->query('end');

        $query = SalesDetail::query();

        if ($start && $end) {
            $query->whereBetween('created_at', [
                $start . ' 00:00:00',
                $end . ' 23:59:59',
            ]);
        }

        // Misal kamu punya relasi product di SalesDetail, eager load biar efisien
        $penjualans = $query->with('product')->orderBy('created_at', 'desc')->get();

        return view('report.penjualan', compact('penjualans', 'start', 'end'));
    }

    public function penjualanPdf(Request $request)
    {
        $start = $request->query('start');
        $end = $request->query('end');

        $query = SalesDetail::query();

        if ($start && $end) {
            $startDate = Carbon::createFromFormat('m/d/Y', $start)->startOfDay()->format('Y-m-d H:i:s');
            $endDate = Carbon::createFromFormat('m/d/Y', $end)->endOfDay()->format('Y-m-d H:i:s');

            $query->whereBetween('date_order', [$startDate, $endDate]);
        }

        // Eager load relasi nested sesuai rule kamu
        $penjualans = $query->with('sales.productIn.product')->orderBy('date_order', 'desc')->get();

        $pdf = Pdf::loadView('report.penjualan_pdf', compact('penjualans', 'start', 'end'));

        return $pdf->download("laporan_penjualan_{$start}_to_{$end}.pdf");
    }
}
