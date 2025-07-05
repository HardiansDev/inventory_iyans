@extends('layouts.master')

@section('title')
    <title>Sistem Inventory Iyan | Pegawai</title>
@endsection

@section('content')
    <!-- Header Section -->
    <section class="content-header py-4 bg-light rounded mb-4">
        <div class="container-fluid">
            <div class="row justify-content-between align-items-center">
                <div class="col-auto">
                    <h1 class="text-dark mb-0">Manajemen Pegawai</h1>
                </div>
                <div class="col-auto">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}" class="text-muted text-decoration-none">
                                <i class="fa fa-dashboard"></i> Dashboard
                            </a>
                        </li>
                        <li class="breadcrumb-item active">Pegawai</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-body">
                <a href="{{ route('employees.create') }}" class="btn btn-warning btn-sm mb-3">+ Tambah Pegawai</a>

                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Departemen</th>
                                <th>Posisi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $e)
                                <tr>
                                    <td>{{ $e->employee_number }}</td>
                                    <td>{{ $e->name }}</td>
                                    <td>{{ $e->department->name }}</td>
                                    <td>{{ $e->position->name }}</td>
                                    <td>{{ $e->status->name }}</td>
                                    <td>
                                        <a href="{{ route('employees.show', $e->id) }}"
                                            class="btn btn-sm btn-info">Lihat</a>
                                        <a href="{{ route('employees.edit', $e->id) }}"
                                            class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('employees.destroy', $e->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button onclick="return confirm('Hapus pegawai ini?')"
                                                class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination jika tidak pakai DataTables --}}
                {{-- {{ $employees->links() }} --}}
            </div>
        </div>
    </div>
@endsection
