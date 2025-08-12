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
            margin: 0;
            padding: 0;
        }

        h1,
        h2 {
            text-align: center;
            margin-bottom: 0;
        }

        h2 {
            margin-top: 5px;
            font-weight: normal;
            color: #555;
        }

        .period {
            text-align: center;
            margin: 10px 0 20px;
            font-size: 14px;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 6px 8px;
            text-align: left;
        }

        th {
            background-color: #f7f7f7;
            font-weight: 600;
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

        footer {
            position: fixed;
            bottom: 10px;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #aaa;
        }
    </style>
</head>

<body>
    <h1>Laporan Penjualan</h1>
    <h2>Periode {{ \Carbon\Carbon::parse($start)->format('d M Y') }} -
        {{ \Carbon\Carbon::parse($end)->format('d M Y') }}</h2>

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
                    <td>{{ \Carbon\Carbon::parse($penjualan->date_order)->format('d-m-Y') }}</td>

                    <td>{{ $penjualan->transaction_number ?? '-' }}</td>
                    <td>{{ $penjualan->sales->productIn->product->name ?? '-' }}</td>

                    <td class="text-right">{{ $penjualan->qty }}</td>
                    <td class="text-right">Rp {{ number_format($penjualan->subtotal, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="no-data">Tidak ada data penjualan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <footer>
        &copy; {{ date('Y') }} Your Company Name - Generated on {{ \Carbon\Carbon::now()->format('d M Y H:i') }}
    </footer>
</body>

</html>
