<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Laporan Data Produk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header .logo {
            width: 100px;
        }

        .header .company-info {
            text-align: left;
        }

        .header .date {
            text-align: right;
        }

        .title {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <div class="company-info">
            <p style="font-size: 24px; font-weight: bold; color: rgb(24, 24, 163); margin: 0">
                KASIRIN.ID
            </p>
            <p style="font-size: 11px; margin-top: 5px">Bekasi, Jawa Barat</p>
        </div>
        <div class="date">
            <p>
                <strong>Tanggal:</strong>
                {{ date('d M Y') }}
            </p>
        </div>
    </div>

    <!-- Title -->
    <div class="title">
        <p><strong>Laporan Data Produk</strong></p>
    </div>

    <!-- Table -->
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Kode Produk</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($products as $index => $product)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->code }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>Rp. {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td>{{ $product->stock . ' ' . ($product->satuan?->nama_satuan ?? '') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
