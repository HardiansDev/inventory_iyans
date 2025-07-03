@extends('layouts.master')

@section('title')
    <title>Sistem Inventory Iyan | Supplier</title>
@endsection

@section('content')
    <section class="content-header py-4 bg-light rounded mb-4">
        <div class="container-fluid">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto">
                    <h1 class="mb-0 text-black">Manajemen Supplier</h1>
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

    <!-- Form Tambah Supplier -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Tambah Supplier</h5>
        </div>
        <form action="{{ route('supplier.store') }}" method="POST">
            @csrf
            <div class="card-body row g-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Nama Supplier</label>
                    <input type="text" class="form-control" name="name" placeholder="Masukkan Nama Supplier" required>
                </div>
                <div class="col-md-6">
                    <label for="address" class="form-label">Alamat Supplier</label>
                    <input type="text" class="form-control" name="address" placeholder="Masukkan Alamat Supplier"
                        required>
                </div>
            </div>
            <div class="card-footer text-end bg-light">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-plus me-1"></i> Tambah Supplier
                </button>
            </div>
        </form>
    </div>

    <!-- List Data Supplier -->
    <div class="card shadow-sm">
        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Supplier</h5>
            <form action="{{ route('supplier.index') }}" method="GET" class="d-flex">
                <input type="text" class="form-control form-control-sm me-2" name="search"
                    placeholder="Cari Supplier..." value="{{ $search }}">
                <button type="submit" class="btn btn-light btn-sm">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 5%">No</th>
                        <th>Nama Supplier</th>
                        <th>Alamat Supplier</th>
                        <th style="width: 20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($suppliers as $index => $item)
                        <tr>
                            <td>{{ $index + $suppliers->firstItem() }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->address }}</td>
                            <td class="text-nowrap">
                                <a href="{{ route('supplier.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('supplier.destroy', $item->id) }}" method="POST"
                                    class="d-inline-block" onsubmit="return confirm('Yakin ingin menghapus supplier ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Data Supplier tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {!! $suppliers->appends(Request::except('page'))->links() !!}
        </div>
    </div>
@endsection
