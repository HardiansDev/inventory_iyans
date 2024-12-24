@extends('layouts.master')

@section('title')
    <title>Cetak Struk</title>
@endsection

@section('content')
    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-teal text-white">
                <h2 class="text-center">Struk Pembayaran</h2>
            </div>
            <div class="card-body">
                <h5><strong>Nomor Invoice:</strong> {{ $printData['transaction_number'] }}</h5>
                <h5><strong>Nomor Invoice:</strong> {{ $printData['invoice_number'] }}</h5>
                <h5><strong>Tanggal:</strong> {{ $printData['date_order'] }}</h5>
                <table class="table table-bordered mt-4">
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($printData['sales'] as $product)
                            <tr>
                                <td>{{ $product['name'] }}</td>
                                <td>{{ $product['qty'] }}</td>
                                <td>Rp {{ number_format($product['price'], 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($product['qty'] * $product['price'], 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <h4 class="text-success mt-4"><strong>Subtotal:</strong> Rp
                    {{ number_format($printData['subtotal'], 0, ',', '.') }}</h4>
                <h4 class="text-success"><strong>Dibayar:</strong> Rp {{ number_format($printData['amount'], 0, ',', '.') }}
                </h4>
                <h4 class="text-success"><strong>Kembalian:</strong> Rp
                    {{ number_format($printData['change'], 0, ',', '.') }}</h4>
            </div>
        </div>
    </div>
@endsection
