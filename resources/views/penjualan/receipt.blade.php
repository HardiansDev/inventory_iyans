<!DOCTYPE html>
<html
    lang="id"
    x-data
    x-init="$nextTick(() => window.print())"
>

<head>
    <meta charset="UTF-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    />
    <title>Struk Pembayaran</title>
    <script
        src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"
        defer
    ></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            #backBtn {
                display: none !important;
            }
        }

        @page {
            margin: 0;
        }
    </style>
</head>

<body class="mx-auto max-w-sm bg-white px-4 py-2 font-mono text-sm text-black">
    <div class="text-center">
        <h3 class="text-lg font-bold tracking-wide">KASIRIN.ID</h3>
        <p class="text-xs leading-tight">
            Jl. Jakarta Kota No. 123<br />
            Telp: 0812-3456-7890
        </p>
    </div>

    <div class="my-2 border-t border-dashed border-black"></div>

    <div class="mb-2 space-y-1 text-sm">
        <div class="flex">
            <span class="w-32">No Transaksi</span>
            <span>: <span class="font-semibold">{{ $invoice->transaction_number }}</span></span>
        </div>
        <div class="flex">
            <span class="w-32">No Invoice</span>
            <span>: <span class="font-semibold">{{ $invoice->invoice_number }}</span></span>
        </div>
        <div class="flex">
            <span class="w-32">Nama Kasir</span>
            <span>: <span class="font-semibold">{{ Auth::user()->name }}</span></span>
        </div>
        <div class="flex">
            <span class="w-32">Tanggal</span>
            <span>: {{ \Carbon\Carbon::parse($invoice->date_order)->format('d-m-Y H:i') }}</span>
        </div>
    </div>

    <div class="my-2 border-t border-dashed border-black"></div>

    <table class="mb-2 w-full text-sm">
        <tbody>
            @foreach ($salesDetails as $item)
                <tr>
                    <td
                        colspan="2"
                        class="font-medium text-black"
                    >
                        {{ $item->sales->productIn->product->name ?? 'Produk Tidak Ditemukan' }}
                    </td>
                </tr>
                <tr>
                    <td>{{ $item->qty }} x Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="text-right">
                        Rp {{ number_format($item->qty * $item->price, 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="my-2 border-t border-dashed border-black"></div>

    <table class="w-full text-sm">
        <tr>
            <td>SUBTOTAL</td>
            <td class="text-right">Rp {{ number_format($invoice->subtotal, 0, ',', '.') }}</td>
        </tr>
        @if ($invoice->discount_id)
            <tr>
                <td>DISKON</td>
                <td class="text-right">- Rp {{ number_format($invoice->subtotal - $invoice->total, 0, ',', '.') }}</td>
            </tr>
        @endif
        <tr>
            <td class="font-bold">TOTAL</td>
            <td class="text-right font-bold">Rp {{ number_format($invoice->total, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>KEMBALI</td>
            <td class="text-right">Rp {{ number_format($invoice->change, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="my-2 border-t border-dashed border-black"></div>

    <div class="text-center text-xs leading-tight">
        *** TERIMA KASIH ***
        <br />
        Barang yang sudah dibeli
        <br />
        tidak dapat dikembalikan.
    </div>


</body>

</html>
