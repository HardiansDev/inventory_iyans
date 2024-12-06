@extends('layouts.master')
@section('title')
    <title>Aplikasi Inventory | Edit Product</title>
@endsection

@section('content')
    <section class="content-header">
        <h1>
            Data Product
            <small>Gudangku</small>
        </h1>
    </section>

    <section class="content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h3 class="card-title">Form Edit Product</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('product.update', ['product' => $product->id]) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <!-- Nama Product -->
                                    <div class="col-md-4 mb-3">
                                        <label for="productName" class="form-label">Nama Product</label>
                                        <input type="text" class="form-control" name="name" id="productName"
                                            value="{{ $product->name }}" required>
                                    </div>

                                    <!-- Kode Product -->
                                    <div class="col-md-4 mb-3">
                                        <label for="productCode" class="form-label">Kode Product</label>
                                        <input type="text" class="form-control" name="code" id="productCode"
                                            value="{{ $product->code }}" readonly>
                                    </div>

                                    <!-- Upload Foto -->
                                    <div class="col-md-4 mb-3">
                                        <label for="productPhoto" class="form-label">Upload Foto</label>
                                        <input type="file" class="form-control" name="photo" id="productPhoto">
                                        @if ($product->photo)
                                            <img src="{{ asset('fotoproduct/' . $product->photo) }}" alt="Product Photo"
                                                class="img-thumbnail mt-2" style="width: 80px;">
                                        @else
                                            <p class="text-muted">No photo uploaded</p>
                                        @endif
                                    </div>

                                    <!-- Kategori -->
                                    <div class="col-md-4 mb-3">
                                        <label for="categorySelect" class="form-label">Kategori</label>
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
                                        <label for="productPrice" class="form-label">Harga Product</label>
                                        <input type="text" class="form-control @error('price') is-invalid @enderror"
                                            name="price" id="productPrice" placeholder="Masukkan Harga Product"
                                            value="{{ $product->price }}">
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Qty Product -->
                                    <div class="col-md-4 mb-3">
                                        <label for="productQty" class="form-label">Qty Product</label>
                                        <input type="text" class="form-control @error('qty') is-invalid @enderror"
                                            name="qty" id="productQty" placeholder="Masukkan Qty Product"
                                            value="{{ $product->qty }}">
                                        @error('qty')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Stok -->
                                    <div class="col-md-4 mb-3">
                                        <label for="productStock" class="form-label">Stok</label>
                                        <input type="text" class="form-control" name="stock" id="productStock"
                                            value="{{ $product->stock }}" required>
                                    </div>

                                    <!-- Quality -->
                                    <div class="col-md-4 mb-3">
                                        <label for="productQuality" class="form-label">Quality</label>
                                        <input type="text" class="form-control" name="quality" id="productQuality"
                                            value="{{ $product->quality }}" required>
                                    </div>

                                    <!-- No Purchase -->
                                    <div class="col-md-4 mb-3">
                                        <label for="productPurchase" class="form-label">No Purchase</label>
                                        <input type="text" class="form-control" name="purchase" id="productPurchase"
                                            value="{{ $product->purchase }}" required>
                                    </div>

                                    <!-- Billing Number -->
                                    <div class="col-md-4 mb-3">
                                        <label for="productBillNum" class="form-label">Billing Number</label>
                                        <input type="text" class="form-control" name="billnum" id="productBillNum"
                                            value="{{ $product->billnum }}" required>
                                    </div>

                                    <!-- Supplier -->
                                    <div class="col-md-4 mb-3">
                                        <label for="supplierSelect" class="form-label">Supplier</label>
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

                                    <!-- PIC -->
                                    <div class="col-md-4 mb-3">
                                        <label for="picSelect" class="form-label">PIC</label>
                                        <select class="form-select" name="pic_id" id="picSelect" required>
                                            <option value="">Pilih PIC</option>
                                            @foreach ($datapic as $pic)
                                                <option value="{{ $pic->id }}"
                                                    {{ $product->pic_id == $pic->id ? 'selected' : '' }}>
                                                    {{ $pic->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-2">Ubah Product</button>
                                    <a href="{{ route('product.index') }}" class="btn btn-danger">Batal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
