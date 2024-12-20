@extends('layouts.master')

@section('title')
    <title>Sistem Inventory Iyan | Produk</title>
@endsection

@section('content')
    <!-- Content Header -->
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
                    <div class="box-header d-flex justify-content-between align-items-center">
                        <a href="{{ route('product.create') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-plus-circle"></i> Tambah Produk
                        </a>
                        <div class="dropdown d-inline">
                            <button class="btn btn-warning btn-sm ms-2 dropdown-toggle" type="button" id="downloadDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-download"></i> Unduh Data Terlihat
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="downloadDropdown">
                                <li>
                                    <a id="downloadPdfBtn" class="dropdown-item" href="#">
                                        <i class="fa fa-file-pdf-o text-danger"></i> Unduh PDF
                                    </a>
                                </li>
                                <li>
                                    <a id="downloadExcelBtn" class="dropdown-item" href="#">
                                        <i class="fa fa-file-excel-o text-success"></i> Unduh Excel
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <button id="deleteAllBtn" class="btn btn-danger btn-sm ms-auto" disabled>
                            <i class="fas fa-trash-alt"></i> Hapus Terpilih
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
                                <!-- Dropdown Export -->
                                <div class="dropdown">
                                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-download"></i> Unduh Semua Data
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <!-- Tombol Unduh Excel -->
                                        <li>
                                            <form action="{{ route('product.export') }}" method="POST" class="d-inline">
                                                @csrf
                                                <button class="dropdown-item" type="submit" name="export_type"
                                                    value="excel">
                                                    <i class="fas fa-file-excel text-success"></i> Unduh Excel
                                                </button>
                                            </form>
                                        </li>
                                        <!-- Tombol Unduh PDF -->
                                        <li>
                                            <form action="{{ route('product.export') }}" method="POST" class="d-inline">
                                                @csrf
                                                <button class="dropdown-item" type="submit" name="export_type"
                                                    value="pdf">
                                                    <i class="fas fa-file-pdf text-danger"></i> Unduh PDF
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
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
                                        <th>Nama Produk</th>
                                        <th>Kode Produk</th>
                                        <th>Gambar Produk</th>
                                        <th>Kategori Produk</th>
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
                                            <td>
                                                <input type="checkbox" class="select-item" value="{{ $product->id }}"
                                                    data-entry-id="{{ $product->id }}" />
                                            </td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->code }}</td>
                                            <td>
                                                <img src="{{ asset('storage/fotoproduct/' . $product->photo) }}"
                                                    alt="Gambar Produk" style="width: 60px; border-radius: 5px;">
                                            </td>
                                            <td>{{ $product->category->name }}</td>
                                            <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                            <td>{{ $product->stock }} pcs</td>
                                            <td>
                                                @if ($product->status == 'produk diterima')
                                                    <span class="badge bg-success">{{ ucwords($product->status) }}</span>
                                                @elseif ($product->status == 'produk ditolak')
                                                    <span class="badge bg-danger">{{ ucwords($product->status) }}</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ ucwords($product->status) }}</span>
                                                @endif
                                            </td>


                                            <td class="text-nowrap">
                                                <a href="{{ route('product.show', $product->id) }}"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="fas fa-eye"></i> Detail
                                                </a>
                                                <a href="{{ route('product.edit', $product->id) }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form action="{{ route('product.destroy', $product->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm delete-prod"
                                                        data-idprod="{{ $product->id }}"
                                                        data-namaprod="{{ $product->name }}">
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
                            {{-- {{ $products->links() }} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal untuk menambahkan produk masuk -->
    @foreach ($products as $product)
        <div class="modal fade" id="addProductModal{{ $product->id }}" tabindex="-1"
            aria-labelledby="addProductModalLabel{{ $product->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProductModalLabel{{ $product->id }}">Tambah Produk Masuk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="addProductForm{{ $product->id }}" action="{{ route('productin.store') }}"
                        method="POST">
                        @csrf
                        <div class="modal-body">
                            <!-- Nama Produk (Readonly) -->
                            <div class="form-group">
                                <label for="product_name">
                                    Nama Produk
                                    <i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Nama produk ini tidak dapat diubah."></i>
                                </label>
                                <input type="text" class="form-control" name="product_name"
                                    value="{{ $product->name }}" required readonly>
                            </div>

                            <!-- Product ID (Hidden) -->
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <!-- Supplier (Readonly) -->
                            <div class="form-group">
                                <label for="supplier_name">
                                    Supplier
                                    <i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Supplier dari produk ini tidak dapat diubah."></i>
                                </label>
                                <input type="text" class="form-control" value="{{ $product->supplier->name }}"
                                    readonly>
                            </div>

                            <!-- Supplier ID (Hidden) -->
                            <input type="hidden" name="supplier_id" value="{{ $product->supplier->id }}">

                            <!-- Kategori (Readonly) -->
                            <div class="form-group">
                                <label for="category_name">
                                    Kategori
                                    <i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Kategori produk ini tidak dapat diubah."></i>
                                </label>
                                <input type="text" class="form-control" value="{{ $product->category->name }}"
                                    readonly>
                            </div>

                            <!-- Category ID (Hidden) -->
                            <input type="hidden" name="category_id" value="{{ $product->category->id }}">

                            <!-- Input Qty -->
                            <div class="form-group">
                                <label for="qty">
                                    Qty
                                    <i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="Masukkan jumlah barang yang akan ditambahkan list produk masuk. Maksimal sesuai stok yang tersedia."></i>
                                </label>
                                <input type="number" id="qty" class="form-control" name="qty"
                                    placeholder="Masukkan Qty" required min="1" max="{{ $product->stock }}">
                                <small>Stok Tersedia: {{ $product->stock }}</small>
                            </div>

                            <!-- Tanggal Masuk -->
                            <div class="form-group">
                                <label for="tanggal">
                                    Tanggal Masuk
                                    <i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="Pilih tanggal barang masuk ke dalam list produk masuk."></i>
                                </label>
                                <input type="date" id="tanggal" class="form-control" name="date" required>
                            </div>

                            <!-- Recipient -->
                            <div class="form-group">
                                <label for="recipient">
                                    Penerima
                                    <i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Masukkan nama penerima barang."></i>
                                </label>
                                <input type="text" id="recipient" class="form-control" name="recipient"
                                    placeholder="Masukkan Nama Penerima" required>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-success">Simpan</button>
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
    @endforeach
@endsection
