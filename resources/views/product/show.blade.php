@extends('layouts.master')

@section('title')
    <title>Detail Produk | Sistem Inventory Iyan</title>
@endsection

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Detail Produk: {{ $product->name }}</h4>
            </div>

            <div class="card-body">
                <div class="row g-4 align-items-start">
                    <!-- Gambar Produk -->
                    <div class="col-md-5 text-center">
                        <img src="{{ asset('/storage/fotoproduct/' . $product->photo) }}" alt="Foto Produk"
                            class="img-fluid rounded shadow-sm" style="max-height: 300px; object-fit: cover;">
                    </div>

                    <!-- Informasi Produk -->
                    <div class="col-md-7">
                        <table class="table table-borderless">
                            <tr>
                                <th style="width: 150px;">Nama</th>
                                <td>: {{ $product->name }}</td>
                            </tr>
                            <tr>
                                <th>Kode Produk</th>
                                <td>: {{ $product->code }}</td>
                            </tr>
                            <tr>
                                <th>Kategori</th>
                                <td>: {{ $product->category->name }}</td>
                            </tr>
                            <tr>
                                <th>Harga</th>
                                <td>: Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Stok</th>
                                <td>: {{ $product->stock }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>: {{ ucfirst($product->status) }}</td>
                            </tr>
                            <tr>
                                <th>Supplier</th>
                                <td>: {{ $product->supplier->name }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="card-footer d-flex justify-content-between align-items-center">
                <a href="{{ route('product.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>

                {{-- <button id="print-btn" class="btn btn-warning">
                    <i class="fas fa-print me-1"></i> Print
                </button> --}}
            </div>
        </div>
    </div>
@endsection
