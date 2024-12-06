@extends('layouts.master')

@section('title')
    <title>Aplikasi Inventory | Product</title>
@endsection

@section('content')
    <!-- Content Header -->
    <section class="content-header py-3 bg-light rounded">
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
                            <li class="breadcrumb-item active" aria-current="page">Produk</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <!-- Header -->
                    <div class="box-header d-flex flex-column align-items-start mb-3">
                        <a href="{{ route('product.create') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-plus-circle"></i> Tambah Produk
                        </a>
                        <button id="deleteAllBtn" class="btn btn-danger btn-sm mt-2" disabled>
                            <i class="fas fa-trash-alt"></i> Hapus Semua Produk Terpilih
                        </button>
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body">
                        <!-- Filter and Export -->
                        <div class="d-flex justify-content-between flex-wrap mb-3 align-items-center">
                            <!-- Filter Kategori -->
                            <div class="d-flex align-items-center gap-2">
                                <label for="filtername" class="form-label mb-0">
                                    <i class="fas fa-filter text-muted"></i>
                                </label>
                                <select id="filtername" class="form-control form-control-sm" style="width: 200px;">
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($datacategory as $category)
                                        <option value="{{ $category->name }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Export -->
                            <div class="d-flex align-items-center gap-2">
                                <form action="{{ route('product.export') }}" method="POST" class="d-flex gap-2">
                                    @csrf
                                    <button class="btn btn-success btn-sm" type="submit" name="export_type" value="excel">
                                        <i class="fas fa-file-excel"></i> Export Excel
                                    </button>
                                    <button class="btn btn-danger btn-sm" type="submit" name="export_type" value="pdf">
                                        <i class="fas fa-file-pdf"></i> Export PDF
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table id="example1" class="table table-hover table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>
                                            <input type="checkbox" id="selectAll" />
                                        </th>
                                        <th>No</th>
                                        <th>Nama Produk</th>
                                        <th>Kode Produk</th>
                                        <th>Gambar Produk</th>
                                        <th>Kategori Produk</th>
                                        <th>Harga</th>
                                        <th>Qty</th>
                                        <th>Stock</th>
                                        <th>Quality</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="select-item" value="{{ $product->id }}" />
                                            </td>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->code }}</td>
                                            <td>
                                                <img src="{{ asset('fotoproduct/' . $product->photo) }}" alt="Gambar Produk"
                                                    style="width: 60px; border-radius: 5px;">
                                            </td>
                                            <td>{{ $product->category->name }}</td>
                                            <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                            <td>{{ $product->qty }} pcs</td>
                                            <td>{{ $product->stock }} <label for="">tersedia</label></td>
                                            <td>{{ $product->quality }}</td>
                                            <td class="text-nowrap">
                                                <a href="{{ route('product.show', $product->id) }}"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="fas fa-eye"></i> Detail
                                                </a>
                                                <a href="{{ route('product.edit', $product->id) }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form action="{{ route('product.destroy', $product->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm delete-prod"
                                                        data-idprod="{{ $product->id }}"
                                                        data-namaprod="{{ $product->name }}">
                                                        <i class="fas fa-trash-alt"></i> Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
