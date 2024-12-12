@extends('layouts.master')

@section('title')
    <title>Aplikasi Inventory | Data Produk Masuk</title>
@endsection

@section('content')
    <!-- Content Header -->
    <section class="content-header py-4 bg-light rounded">
        <div class="container-fluid">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto">
                    <h1 class="mb-0 text-black">Management Produk Masuk</h1>
                </div>
                <div class="col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}" class="text-decoration-none text-secondary">
                                    <i class="fa fa-dashboard"></i> Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Produk Masuk</li>
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
                            <i class="fas fa-plus-circle"></i> Tambah Produk Masuk
                        </a>
                        {{-- <button id="deleteAllBtn" class="btn btn-danger btn-sm mt-2" disabled>
                            <i class="fas fa-trash-alt"></i> Hapus Semua Produk Terpilih
                        </button> --}}
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body">
                        <!-- Filter and Export -->
                        <div class="d-flex justify-content-between flex-wrap mb-3 align-items-center">
                            <!-- Filter Kategori -->
                            <div class="d-flex align-items-center gap-2">
                                <label for="filtername" class="form-label mb-0">
                                    {{-- <i class="fas fa-filter text-muted"></i> --}}
                                </label>
                            </div>

                            <!-- Export -->
                            <div class="d-flex align-items-center gap-2">
                                <form action="#" method="POST" class="d-flex gap-2">
                                    {{-- @csrf --}}
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
                                        <th>No</th>
                                        <th>Nama Produk</th>
                                        <th>Kode Produk</th>
                                        <th>Gambar Produk</th>
                                        <th>Kategori Produk</th>
                                        <th>Harga</th>
                                        <th>Qty</th>
                                        <th>Stock</th>
                                        <th>Status</th>
                                        <th>Aksi</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productIns as $productIn)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $productIn->product->name }}</td>
                                            <td>{{ $productIn->product->code }}</td>
                                            <td>
                                                @if ($productIn->product->photo)
                                                    <img src="{{ asset('fotoproduct/' . $productIn->product->photo) }}"
                                                        alt="Image" width="50">
                                                @else
                                                    <span>No Image</span>
                                                @endif
                                            </td>
                                            <td>{{ $productIn->product->category->name }}</td>
                                            <td>{{ number_format($productIn->product->price, 2) }}</td>
                                            <td>{{ $productIn->qty }}</td>
                                            <td>{{ $productIn->product->stock }}</td>
                                            <td>
                                                @if ($productIn->qty <= $productIn->product->stock)
                                                    <span class="badge bg-success">Tersedia</span>
                                                @else
                                                    <span class="badge bg-danger">Stok Habis</span>
                                                @endif
                                            </td>
                                            <td>
                                                <!-- Dropdown untuk Terima dan Tolak -->
                                                <div class="dropdown">
                                                    <button class="btn btn-primary dropdown-toggle" type="button"
                                                        id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        Pilih Aksi
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <!-- Tombol Terima -->
                                                        <li>
                                                            <form
                                                                action="{{ route('productin.updateStatus', $productIn->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="terima">
                                                                <button type="submit"
                                                                    class="dropdown-item text-success">Terima</button>
                                                            </form>
                                                        </li>
                                                        <!-- Tombol Tolak -->
                                                        <li>
                                                            <form
                                                                action="{{ route('productin.updateStatus', $productIn->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="tolak">
                                                                <button type="submit"
                                                                    class="dropdown-item text-danger">Tolak</button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
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
