@extends('layouts.master')

@section('title')
    <title>Aplikasi Inventory | Supplier</title>
@endsection

@section('content')
<section class="content-header py-4 bg-light rounded">
    <div class="container-fluid">
        <div class="row align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="mb-0 text-black">Management Supplier</h1>
            </div>
            <div class="col-auto">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}" class="text-decoration-none text-secondary">
                                <i class="fa fa-dashboard"></i> Dashboard
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Supplier</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Input Supplier</h3>
                    </div>

                    <!-- Form Input Supplier -->
                    <form action="{{ route('supplier.store') }}" method="POST">
                        @csrf
                        <div class="box-body">
                            <div class="form-group col-md-6">
                                <label for="name">Nama Supplier</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="Masukkan Nama Supplier" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="address">Alamat Supplier</label>
                                <input type="text" class="form-control" name="address" id="address"
                                    placeholder="Masukkan Alamat Supplier" required>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary btn-sm">Tambah Supplier</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- List Data Supplier -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Data Supplier</h3>
                        <div class="box-tools pull-right">
                            <form action="{{ route('supplier.index') }}" method="GET" class="form-inline">
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" name="search" placeholder="Cari Supplier"
                                        value="{{ $search }}">
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-warning btn-flat">Cari</button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Supplier</th>
                                    <th>Alamat Supplier</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @forelse ($suppliers as $index => $item)
                                    <tr>
                                        <td>{{ $index + $suppliers->firstItem() }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->address }}</td>
                                        <td>
                                            <!-- Tombol Edit -->
                                            <a href="{{ route('supplier.edit', $item->id) }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>

                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('supplier.destroy', $item->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm delete-supp"
                                                    data-idsupp="{{ $item->id }}" data-namasupp="{{ $item->name }}">
                                                    <i class="fas fa-trash-alt"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Data Supplier Tidak Ada</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="box-footer clearfix">
                        {!! $suppliers->appends(Request::except('page'))->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
