<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Bahan Baku</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
            font-size: 20px;
            text-transform: uppercase;
        }

        .header p {
            margin: 2px 0;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table th,
        table td {
            border: 1px solid #444;
            padding: 6px 8px;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Laporan Bahan Baku</h2>
        <p>Kasirin POS System</p>
        <p>{{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Bahan</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Harga</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalModal = 0;
            @endphp
            @forelse ($bahanBaku as $index => $item)
                @php
                    $subtotal = $item->price * $item->stock;
                    $totalModal += $subtotal;
                @endphp
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->category?->name ?? '-' }}</td>
                    <td style="text-align: center;">{{ $item->stock }} {{ $item->satuan->nama_satuan ?? '-' }}</td>
                    <td style="text-align: center;">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data bahan baku</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" style="text-align: right; font-weight: bold;">Total Modal</td>
                <td colspan="2" style="font-weight: bold; text-align: right;">
                    Rp {{ number_format($totalModal, 0, ',', '.') }}
                </td>
            </tr>
        </tfoot>

    </table>

    <div class="footer">
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}</p>
    </div>
</body>

</html>
