<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Struk Pembayaran</title>
    <style>
        @page {
            margin: 0;
        }

        body {
            font-family: 'Courier New', monospace;
            font-size: 13px;
            max-width: 300px;
            margin: auto;
            color: #000;
        }

        .center {
            text-align: center;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 8px 0;
        }

        table {
            width: 100%;
        }

        td {
            vertical-align: top;
        }

        .right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }
    </style>
</head>

<body onload="window.print()">

    <div class="center">
        <h3>SISTEM INVENTORY IYAN</h3>
        <p>Jl. Contoh Alamat No. 123<br>Telp: 0812-3456-7890</p>
    </div>

    <div class="line"></div>

    <p>
        No Transaksi : {{ $invoice->transaction_number }}<br>
        No Invoice : {{ $invoice->invoice_number }}<br>
        Tanggal : {{ \Carbon\Carbon::parse($invoice->date_order)->format('d-m-Y H:i') }}
    </p>

    <div class="line"></div>

    <table>
        @foreach ($salesDetails as $item)
            <tr>
                <td colspan="2">{{ $item->sales->productIn->product->name ?? 'Produk Tidak Ditemukan' }}</td>
            </tr>
            <tr>
                <td>{{ $item->qty }} x Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                <td class="right">Rp {{ number_format($item->qty * $item->price, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </table>

    <div class="line"></div>

    <table>
        <tr>
            <td class="bold">TOTAL</td>
            <td class="right bold">Rp {{ number_format($invoice->subtotal, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>BAYAR</td>
            <td class="right">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>KEMBALI</td>
            <td class="right">Rp {{ number_format($invoice->change, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="line"></div>

    <p class="center">*** TERIMA KASIH ***<br>Barang yang sudah dibeli<br>tidak dapat dikembalikan.</p>

</body>

</html>
