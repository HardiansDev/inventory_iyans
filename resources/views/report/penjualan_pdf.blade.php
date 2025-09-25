<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 30px;
            background: #fff;
        }

        /* Kop Surat */
        .kop {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
            margin-bottom: 20px;
        }

        .kop h1 {
            font-size: 16px;
            margin: 0;
            font-weight: bold;
        }

        .kop p {
            margin: 2px 0;
            font-size: 11px;
            color: #555;
        }

        /* Judul Laporan dalam box */
        .report-header {
            text-align: center;
            margin: 20px auto 30px auto;
            padding: 15px 20px;
        }

        .report-header h2 {
            font-size: 18px;
            margin: 0;
            font-weight: bold;
            color: #222;
        }

        .report-header h3 {
            font-size: 13px;
            margin-top: 5px;
            color: #555;
            font-weight: normal;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 6px 10px;
            font-size: 12px;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }

        td {
            vertical-align: top;
        }

        tr:nth-child(even) td {
            background-color: #fafafa;
        }

        td.text-right {
            text-align: right;
        }

        .no-data {
            text-align: center;
            color: #999;
            font-style: italic;
            padding: 20px 0;
        }

        .total-row td {
            font-weight: bold;
            background-color: #f9f9f9;
        }

        /* Tanda tangan */
        .signature {
            margin-top: 50px;
            width: 100%;
        }

        .signature .left,
        .signature .right {
            width: 45%;
            text-align: center;
            display: inline-block;
            vertical-align: top;
        }

        .signature .right {
            float: right;
        }

        .signature p {
            margin: 60px 0 0 0;
            font-size: 12px;
        }
    </style>
</head>

<body>

    <!-- Judul Laporan -->
    <div class="report-header">
        <h2>Laporan Penjualan</h2>
        <h3>
            Periode {{ \Carbon\Carbon::parse($start)->format('d M Y') }} -
            {{ \Carbon\Carbon::parse($end)->format('d M Y') }}
        </h3>
    </div>

    <!-- Tabel -->
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Nomor Transaksi</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @forelse($penjualans as $penjualan)
                <tr>
                    <td style="text-align:center;">
                        {{ \Carbon\Carbon::parse($penjualan->date_order)->format('d-m-Y') }}
                    </td>
                    <td>{{ $penjualan->transaction_number ?? '-' }}</td>
                    <td>{{ $penjualan->sales->productIn->product->name ?? '-' }}</td>
                    <td class="text-right">{{ $penjualan->qty }}</td>
                    <td class="text-right">
                        @if ($penjualan->discount && $penjualan->discount->nilai > 0)
                            {{-- Harga sebelum diskon dicoret --}}
                            <span style="text-decoration: line-through; color: red;">
                                Rp {{ number_format($penjualan->subtotal, 0, ',', '.') }}
                            </span><br>
                            {{-- Harga setelah diskon --}}
                            @php
                                $afterDiscount =
                                    $penjualan->subtotal - $penjualan->subtotal * ($penjualan->discount->nilai / 100);
                            @endphp

                            Rp {{ number_format($afterDiscount, 0, ',', '.') }}

                            <small>({{ $penjualan->discount->nilai }}%)</small>
                        @else
                            Rp {{ number_format($penjualan->subtotal, 0, ',', '.') }}
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="no-data">Tidak ada data penjualan.</td>
                </tr>
            @endforelse

            {{-- Tambah total jika ada data --}}
            @if ($penjualans->count() > 0)
                <tr class="total-row">
                    <td colspan="4" class="text-right">Total Penjualan</td>
                    <td class="text-right">
                        Rp {{ number_format($total, 0, ',', '.') }}
                    </td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- Tanda Tangan -->
    <div class="signature">
        <div class="left">
            <p>Mengetahui,<br><br><br><br>__________________________<br>Manager</p>
        </div>
        <div class="right">
            <p>Jakarta, {{ \Carbon\Carbon::now()->format('d M Y') }}<br><br><br><br>
                __________________________<br>Kasir
            </p>
        </div>
    </div>
</body>


</html>
