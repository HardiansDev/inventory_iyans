@extends('layouts.master')

@section('title')
    <title>Sistem Inventory Iyan | Tambah Produk</title>
@endsection

@section('content')
    <section class="content-header py-4 bg-light rounded">
        <div class="container-fluid">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto">
                    <h1 class="mb-0 text-black">Manajemen Produk</h1>
                </div>
                <div class="col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}" class="text-decoration-none text-secondary">
                                    <i class="fa fa-dashboard"></i> Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah Produk</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h3 class="card-title"> <i class="fas fa-plus-circle"></i> Produk Baru</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <!-- Nama Product -->
                                    <div class="col-md-4 mb-3">
                                        <label for="productName" class="form-label">
                                            Nama Produk
                                            <i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                title="Masukkan nama produk yang akan dijual, maksimal 255 karakter."></i>
                                        </label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            name="name" id="productName" placeholder="Masukkan Nama Produk"
                                            value="{{ old('name') }}">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Kode Product -->
                                    <div class="col-md-4 mb-3">
                                        <label for="productCode" class="form-label">
                                            Kode Produk
                                            <i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                title="Kode produk dibuat secara otomatis dan tidak dapat diubah."></i>
                                        </label>
                                        <input type="text" class="form-control" name="code" id="productCode"
                                            value="{{ 'KD-' . strtoupper(Str::random(6)) . '-' . now()->year }}" readonly>
                                    </div>

                                    <!-- Upload Foto -->
                                    <div class="col-md-4 mb-3">
                                        <label for="productPhoto" class="form-label">
                                            Upload Foto
                                            <i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                title="Unggah foto produk dalam format JPG, PNG, atau JPEG. Ukuran maksimal 2MB."></i>
                                        </label>
                                        <input type="file" class="form-control @error('photo') is-invalid @enderror"
                                            name="photo" id="productPhoto">
                                        @error('photo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Kategori -->
                                    <div class="col-md-4 mb-3">
                                        <label for="categorySelect" class="form-label">
                                            Kategori
                                            <i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                title="Pilih kategori yang sesuai dengan produk Anda."></i>
                                        </label>
                                        <select class="form-select @error('category_id') is-invalid @enderror"
                                            name="category_id" id="categorySelect">
                                            <option value="" disabled selected>Pilih Kategori</option>
                                            @foreach ($datacategory as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Harga Product -->
                                    <div class="col-md-4 mb-3">
                                        <label for="productPrice" class="form-label">
                                            Harga Produk
                                            <i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                title="Masukkan harga produk, otomatis akan diformat dengan pemisah ribuan."></i>
                                        </label>
                                        <input type="text" class="form-control @error('price') is-invalid @enderror"
                                            name="price_display" id="productPrice" placeholder="Masukkan Harga Produk"
                                            value="{{ old('price') }}" oninput="formatPriceDisplay(this)">
                                        <input type="hidden" name="price" id="priceHidden" value="{{ old('price') }}">
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Stok -->
                                    <div class="col-md-4 mb-3">
                                        <label for="productStock" class="form-label">
                                            Stok
                                            <i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                title="Masukkan jumlah stok produk yang tersedia."></i>
                                        </label>
                                        <input type="number" class="form-control @error('stock') is-invalid @enderror"
                                            name="stock" id="productStock" placeholder="Masukkan Stok Product"
                                            value="{{ old('stock') }}">
                                        @error('stock')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Supplier -->
                                    <div class="col-md-4 mb-3">
                                        <label for="supplierSelect" class="form-label">
                                            Supplier
                                            <i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                title="Pilih supplier yang menyediakan produk ini."></i>
                                        </label>
                                        <select class="form-select @error('supplier_id') is-invalid @enderror"
                                            name="supplier_id" id="supplierSelect">
                                            <option value="" disabled selected>Pilih Supplier</option>
                                            @foreach ($datasupplier as $supplier)
                                                <option value="{{ $supplier->id }}"
                                                    {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                                    {{ $supplier->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('supplier_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-2">
                                        <i class="fas fa-save"></i> Tambah Produk
                                    </button>
                                    <a href="{{ route('product.index') }}" class="btn btn-danger">
                                        <i class="fas fa-times"></i> Batal
                                    </a>
                                </div>
                            </form>

                            <script>
                                // Inisialisasi Bootstrap Tooltip
                                document.addEventListener('DOMContentLoaded', function() {
                                    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                                    tooltipTriggerList.map(function(tooltipTriggerEl) {
                                        return new bootstrap.Tooltip(tooltipTriggerEl);
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
