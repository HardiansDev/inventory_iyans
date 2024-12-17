@extends('layouts.master')

@section('title')
    <title>Sistem Inventory Iyan | Manajemen Produk Masuk</title>
@endsection

@section('content')
    <!-- Content Header -->
    <section class="content-header py-4 bg-light rounded">
        <div class="container-fluid">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto">
                    <h1 class="mb-0 text-black">Data Produk Masuk</h1>
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
                        <a href="{{ route('productin.create') }}" class="btn btn-warning btn-sm">Tambah Produk</a>
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body">
                        <!-- Table -->
                        <div class="table-responsive">
                            <table id="example1" class="table table-hover table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Produk</th>
                                        <th>Kode Produk</th>
                                        <th>Tanggal Masuk</th>
                                        <th>Gambar Produk</th>
                                        <th>Kategori Produk</th>
                                        <th>Harga</th>
                                        <th>Qty</th>
                                        <th>Penerima</th>
                                        <th>Status</th>
                                        <th>Terima / Tolak</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productIns as $productIn)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $productIn->product->name }}</td>
                                            <td>{{ $productIn->product->code }}</td>
                                            <td>{{ $productIn->date }}</td>
                                            <td>
                                                @if ($productIn->product->photo)
                                                    <img src="{{ asset('fotoproduct/' . $productIn->product->photo) }}"
                                                        alt="Image" width="50">
                                                @else
                                                    <span>No Image</span>
                                                @endif
                                            </td>
                                            <td>{{ $productIn->product->category->name }}</td>
                                            <td>Rp {{ number_format($productIn->product->price, 0, ',', '.') }}</td>
                                            <td>{{ $productIn->qty }}</td>
                                            <td>{{ $productIn->recipient }}</td>
                                            <td>
                                                @if ($productIn->status === 'menunggu')
                                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                                @elseif ($productIn->status === 'diterima')
                                                    <span class="badge bg-success">Diterima</span>
                                                @elseif ($productIn->status === 'ditolak')
                                                    <span class="badge bg-danger">Ditolak</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button"
                                                        id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                        aria-expanded="false"
                                                        {{ $productIn->status !== 'menunggu' ? 'disabled' : '' }}>
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
                                                                <input type="hidden" name="status" value="diterima">
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
                                                                <input type="hidden" name="status" value="ditolak">
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
