@extends('layouts.master') {{-- Pastikan ini sesuai dengan layout utama Anda --}}

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h4>Tambah Produk Masuk</h4>
                </div>
                <div class="card-body">
                    {{-- Form Produk Masuk --}}
                    <form action="{{ route('productin.store') }}" method="POST">
                        @csrf

                        {{-- Dropdown Produk --}}
                        <div class="form-group">
                            <label for="product_id">Pilih Produk</label>
                            <select class="form-control" id="product_id" name="product_id[]" multiple>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }} (Stok: {{ $product->stock }})</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Gunakan CTRL/Command untuk memilih lebih dari satu produk.</small>
                        </div>

                        {{-- Input Jumlah --}}
                        <div class="form-group">
                            <label for="qty">Jumlah Produk (Per Produk)</label>
                            <input type="number" name="qty[]" class="form-control" placeholder="Masukkan jumlah produk" required>
                        </div>

                        {{-- Dropdown Supplier --}}
                        <div class="form-group">
                            <label for="supplier_id">Pilih Supplier</label>
                            <select class="form-control" id="supplier_id" name="supplier_id">
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Tanggal Masuk --}}
                        <div class="form-group">
                            <label for="date">Tanggal Masuk</label>
                            <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>

                        {{-- Penerima --}}
                        <div class="form-group">
                            <label for="recipient">Nama Penerima</label>
                            <input type="text" name="recipient" class="form-control" placeholder="Masukkan nama penerima" required>
                        </div>

                        {{-- Tombol Submit --}}
                        <button type="submit" class="btn btn-primary">Tambah Produk Masuk</button>
                        <a href="{{ route('productin.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
