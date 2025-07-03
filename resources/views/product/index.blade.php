@extends('layouts.master')

@section('title')
    <title>Sistem Inventory Iyan | Produk</title>
@endsection

@section('content')
    <!-- Header Section -->
    <section class="content-header py-4 bg-light rounded mb-4">
        <div class="container-fluid">
            <div class="row justify-content-between align-items-center">
                <div class="col-auto">
                    <h1 class="text-dark mb-0">Manajemen Produk</h1>
                </div>
                <div class="col-auto">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}" class="text-muted text-decoration-none">
                                <i class="fa fa-dashboard"></i> Dashboard
                            </a>
                        </li>
                        <li class="breadcrumb-item active">Produk</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3 flex-wrap gap-2">
                    <div class="d-flex gap-2">
                        <a href="{{ route('product.create') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-plus-circle"></i> Tambah Produk
                        </a>
                        <button id="deleteAllBtn" class="btn btn-danger btn-sm" disabled>
                            <i class="fas fa-trash-alt"></i> Hapus Terpilih
                        </button>
                    </div>

                    <div class="d-flex gap-2">
                        <div class="dropdown">
                            <button class="btn btn-warning btn-sm dropdown-toggle" type="button" id="downloadDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-download"></i> Unduh Data Terpilih
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="downloadDropdown">
                                <li><a id="downloadPdfBtn" class="dropdown-item" href="#"><i
                                            class="fa fa-file-pdf-o text-danger"></i> Unduh PDF</a></li>
                                <li><a id="downloadExcelBtn" class="dropdown-item" href="#"><i
                                            class="fa fa-file-excel-o text-success"></i> Unduh Excel</a></li>
                            </ul>
                        </div>

                        <div class="dropdown">
                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-download"></i> Unduh Semua Data
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li>
                                    <form action="{{ route('product.export') }}" method="POST">
                                        @csrf
                                        <button class="dropdown-item" type="submit" name="export_type" value="excel">
                                            <i class="fas fa-file-excel text-success"></i> Unduh Excel
                                        </button>
                                    </form>
                                </li>
                                <li>
                                    <form action="{{ route('product.export') }}" method="POST">
                                        @csrf
                                        <button class="dropdown-item" type="submit" name="export_type" value="pdf">
                                            <i class="fas fa-file-pdf text-danger"></i> Unduh PDF
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Filter Kategori -->
                <div class="mb-3">
                    <label for="filtername" class="form-label"><i class="fas fa-filter"></i> </label>
                    <select id="filtername" class="form-select form-select-sm w-auto d-inline-block">
                        <option value="">Pilih Kategori</option>
                        @foreach ($datacategory as $category)
                            <option value="{{ $category->name }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Table Produk -->
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th><input type="checkbox" id="selectAll" /></th>
                                <th>Nama</th>
                                <th>Kode</th>
                                <th>Gambar</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Status</th>
                                <th>Aksi</th>
                                <th>Masukkin</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td><input type="checkbox" class="select-item" value="{{ $product->id }}"
                                            data-entry-id="{{ $product->id }}" /></td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->code }}</td>
                                    <td><img src="{{ asset('storage/fotoproduct/' . $product->photo) }}"
                                            alt="Gambar Produk" class="img-thumbnail" style="width: 60px;"></td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                    <td>{{ $product->stock }} pcs</td>
                                    <td>
                                        <span
                                            class="badge {{ $product->status == 'produk diterima'
                                                ? 'bg-success'
                                                : ($product->status == 'produk ditolak'
                                                    ? 'bg-danger'
                                                    : 'bg-secondary') }}">
                                            {{ ucwords($product->status) }}
                                        </span>
                                    </td>
                                    <td class="text-nowrap">
                                        <a href="{{ route('product.show', $product->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                        <a href="{{ route('product.edit', $product->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('product.destroy', $product->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm delete-prod"
                                                data-idprod="{{ $product->id }}" data-namaprod="{{ $product->name }}">
                                                <i class="fas fa-trash-alt"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#addProductModal{{ $product->id }}">
                                            <i class="fas fa-box-open"></i> Masukkan Produk
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Include Modals -->
                <!-- Modal Tambah Produk Masuk -->
                @foreach ($products as $product)
                    <div class="modal fade" id="addProductModal{{ $product->id }}" tabindex="-1"
                        aria-labelledby="addProductModalLabel{{ $product->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content border-0 shadow">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title" id="addProductModalLabel{{ $product->id }}">
                                        Tambah Produk Masuk - {{ $product->name }}
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <form action="{{ route('productin.store') }}" method="POST">
                                    @csrf
                                    <div class="modal-body row g-3">
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="supplier_id" value="{{ $product->supplier->id }}">
                                        <input type="hidden" name="category_id" value="{{ $product->category->id }}">

                                        <div class="col-md-6">
                                            <label class="form-label">Nama Produk</label>
                                            <input type="text" class="form-control" value="{{ $product->name }}"
                                                readonly>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Supplier</label>
                                            <input type="text" class="form-control"
                                                value="{{ $product->supplier->name }}" readonly>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Kategori</label>
                                            <input type="text" class="form-control"
                                                value="{{ $product->category->name }}" readonly>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">
                                                Qty <small class="text-muted">(maks: {{ $product->stock }})</small>
                                            </label>
                                            <input type="number" name="qty" class="form-control" required
                                                min="1" max="{{ $product->stock }}"
                                                placeholder="Masukkan jumlah">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Tanggal Masuk</label>
                                            <input type="date" name="date" class="form-control" required>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Penerima</label>
                                            <input type="text" name="recipient" class="form-control"
                                                placeholder="Nama penerima barang" required>
                                        </div>
                                    </div>

                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            <i class="fas fa-times-circle"></i> Tutup
                                        </button>
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-check-circle"></i> Simpan Produk Masuk
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach


            </div>
        </div>
    </section>
@endsection
