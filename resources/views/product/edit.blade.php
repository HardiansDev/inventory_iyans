@extends('layouts.master')
@section('title')
    <title>Sistem Inventory Iyan | Edit Produk</title>
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
                            <li class="breadcrumb-item active" aria-current="page">Edit Produk</li>
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
                            <h3 class="card-title">Edit Produk</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('product.update', ['product' => $product->id]) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <!-- Nama Product -->
                                    <div class="col-md-4 mb-3">
                                        <label for="productName" class="form-label">
                                            Nama Produk
                                            <i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                title="Masukkan nama produk yang akan diubah. Maksimal 255 karakter."></i>
                                        </label>
                                        <input type="text" class="form-control" name="name" id="productName"
                                            value="{{ $product->name }}" required>
                                    </div>

                                    <!-- Kode Product -->
                                    <div class="col-md-4 mb-3">
                                        <label for="productCode" class="form-label">
                                            Kode Produk
                                            <i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                title="Kode produk ini telah dibuat sebelumnya dan tidak dapat diubah."></i>
                                        </label>
                                        <input type="text" class="form-control" name="code" id="productCode"
                                            value="{{ $product->code }}" readonly>
                                    </div>

                                    <!-- Upload Foto -->
                                    <div class="col-md-4 mb-3">
                                        <label for="productPhoto" class="form-label">
                                            Upload Foto
                                            <i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                title="Unggah foto baru jika diperlukan. Format yang diperbolehkan: JPG, PNG, JPEG. Maksimal 2MB."></i>
                                        </label>
                                        <input type="file" class="form-control" name="photo" id="productPhoto">
                                        @if ($product->photo)
                                            <img src="{{ asset('/storage/fotoproduct/produk/' . $product->photo) }}"
                                                alt="Product Photo" class="img-thumbnail mt-2" style="width: 80px;">
                                        @else
                                            <p class="text-muted">Foto Tidak Ada</p>
                                        @endif
                                    </div>

                                    <!-- Kategori -->
                                    <div class="col-md-4 mb-3">
                                        <label for="categorySelect" class="form-label">
                                            Kategori
                                            <i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Pilih kategori baru jika diperlukan."></i>
                                        </label>
                                        <select class="form-select" name="category_id" id="categorySelect" required>
                                            <option value="">Pilih Kategori</option>
                                            @foreach ($datacategory as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Harga Product -->
                                    <div class="col-md-4 mb-3">
                                        <label for="productPrice" class="form-label">
                                            Harga Produk
                                            <i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                title="Masukkan harga baru jika ingin diubah. Format angka tanpa koma atau titik."></i>
                                        </label>
                                        <input type="number" class="form-control @error('price') is-invalid @enderror"
                                            name="price" id="productPrice" placeholder="Masukkan Harga Produk"
                                            value="{{ $product->price }}">
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
                                        <input type="number" class="form-control" name="stock" id="productStock"
                                            value="{{ $product->stock }}" required>
                                    </div>

                                    <!-- Supplier -->
                                    <div class="col-md-4 mb-3">
                                        <label for="supplierSelect" class="form-label">
                                            Supplier
                                            <i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                title="Pilih supplier baru jika ingin diubah."></i>
                                        </label>
                                        <select class="form-select" name="supplier_id" id="supplierSelect" required>
                                            <option value="">Pilih Supplier</option>
                                            @foreach ($datasupplier as $supplier)
                                                <option value="{{ $supplier->id }}"
                                                    {{ $product->supplier_id == $supplier->id ? 'selected' : '' }}>
                                                    {{ $supplier->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-2"><i class="fas fa-save"></i> Ubah
                                        Produk</button>
                                    <a href="{{ route('product.index') }}" class="btn btn-danger"><i
                                            class="fas fa-times"></i> Batal</a>
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
