@extends('layouts.master')

@section('title')
    <title>Aplikasi Inventory | Tambah Product</title>
@endsection

@section('content')
    <section class="content-header py-4 bg-light rounded">
        <div class="container-fluid">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto">
                    <h1 class="mb-0 text-black">Management Produk</h1>
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
                            {{-- @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif --}}

                            <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <!-- Nama Product -->
                                    <div class="col-md-4 mb-3">
                                        <label for="productName" class="form-label">Nama Product</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            name="name" id="productName" placeholder="Masukkan Nama Product"
                                            value="{{ old('name') }}">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Kode Product -->
                                    <div class="col-md-4 mb-3">
                                        <label for="productCode" class="form-label">Kode Product</label>
                                        <input type="text" class="form-control" name="code" id="productCode"
                                            value="{{ 'KD-' . strtoupper(Str::random(6)) . '-' . now()->year }}" readonly>
                                    </div>

                                    <!-- Upload Foto -->
                                    <div class="col-md-4 mb-3">
                                        <label for="productPhoto" class="form-label">Upload Foto</label>
                                        <input type="file" class="form-control @error('photo') is-invalid @enderror"
                                            name="photo" id="productPhoto">
                                        @error('photo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Kategori -->
                                    <div class="col-md-4 mb-3">
                                        <label for="categorySelect" class="form-label">Kategori</label>
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
                                        <label for="productPrice" class="form-label">Harga Product</label>
                                        <input type="text" class="form-control @error('price') is-invalid @enderror"
                                            name="price" id="productPrice" placeholder="Masukkan Harga Product"
                                            value="{{ old('price') }}">
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Qty Product -->
                                    <div class="col-md-4 mb-3">
                                        <label for="productQty" class="form-label">Qty Product</label>
                                        <input type="text" class="form-control @error('qty') is-invalid @enderror"
                                            name="qty" id="productQty" placeholder="Masukkan Qty Product"
                                            value="{{ old('qty') }}">
                                        @error('qty')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Stok -->
                                    <div class="col-md-4 mb-3">
                                        <label for="productStock" class="form-label">Stok</label>
                                        <input type="text" class="form-control @error('stock') is-invalid @enderror"
                                            name="stock" id="productStock" placeholder="Masukkan Stok Product"
                                            value="{{ old('stock') }}">
                                        @error('stock')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Quality -->
                                    <div class="col-md-4 mb-3">
                                        <label for="productQuality" class="form-label">Quality</label>
                                        <select class="form-select @error('quality') is-invalid @enderror" name="quality"
                                            id="productQuality" required>
                                            <option value="" disabled selected>Pilih Quality</option>
                                            <option value="Bagus" {{ old('quality') == 'Bagus' ? 'selected' : '' }}>Bagus
                                            </option>
                                            <option value="Lumayan" {{ old('quality') == 'Lumayan' ? 'selected' : '' }}>
                                                Lumayan</option>
                                            <option value="Kurang" {{ old('quality') == 'Kurang' ? 'selected' : '' }}>
                                                Kurang
                                            </option>
                                        </select>
                                        @error('quality')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- No Purchase -->
                                    <div class="col-md-4 mb-3">
                                        <label for="productPurchase" class="form-label">No Purchase</label>
                                        <input type="text" class="form-control @error('purchase') is-invalid @enderror"
                                            name="purchase" id="productPurchase" value="{{ $noPurchase }}" readonly>
                                        @error('purchase')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Billing Number -->
                                    <div class="col-md-4 mb-3">
                                        <label for="productBillNum" class="form-label">Billing Number</label>
                                        <input type="text" class="form-control @error('billnum') is-invalid @enderror"
                                            name="billnum" id="productBillNum" value="{{ $billingNumber }}" readonly>
                                        @error('billnum')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Supplier -->
                                    <div class="col-md-4 mb-3">
                                        <label for="supplierSelect" class="form-label">Supplier</label>
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

                                    <!-- PIC -->
                                    <div class="col-md-4 mb-3">
                                        <label for="picSelect" class="form-label">PIC</label>
                                        <select class="form-select @error('pic_id') is-invalid @enderror" name="pic_id"
                                            id="picSelect">
                                            <option value="" disabled selected>Pilih PIC</option>
                                            @foreach ($datapic as $pic)
                                                <option value="{{ $pic->id }}"
                                                    {{ old('pic_id') == $pic->id ? 'selected' : '' }}>
                                                    {{ $pic->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('pic_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-2">
                                        <i class="fas fa-save"></i> Simpan Product
                                    </button>
                                    <a href="{{ route('product.index') }}" class="btn btn-danger">
                                        <i class="fas fa-times"></i> Batal
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
