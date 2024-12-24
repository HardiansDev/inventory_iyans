<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran</title>
</head>

<body>
    <h1>Struk Pembayaran</h1>
    <p>Transaction Number: {{ $salesDetail->first()->transaction_number }}</p>
    <p>Invoice Number: {{ $salesDetail->first()->invoice_number }}</p>
    <p>Date: {{ $salesDetail->first()->date_order }}</p>

    <table border="1">
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Kuantitas</th>
                <th>Harga</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($salesDetail as $detail)
                <tr>
                    <td>{{ $detail->sales->sales_id }}</td>
                    <td>{{ $detail->sales->qty }}</td>
                    <td>{{ number_format($detail->price, 0, ',', '.') }}</td>
                    <td>{{ number_format($detail->price * $detail->sales->qty, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Total: Rp {{ number_format($salesDetail->sum('price') * $salesDetail->sum('quantity'), 0, ',', '.') }}</h3>
    <button onclick="window.print()">Cetak</button>
</body>

</html>
