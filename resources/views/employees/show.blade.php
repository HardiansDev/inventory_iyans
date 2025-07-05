@extends('layouts.master')

@section('title')
    <title>Detail Pegawai | Sistem Inventory Iyan</title>
@endsection

@section('content')
    <!-- Header Section -->
    <section class="content-header py-4 bg-light rounded mb-4">
        <div class="container-fluid">
            <div class="row justify-content-between align-items-center">
                <div class="col-auto">
                    <h1 class="text-dark mb-0">Detail Pegawai</h1>
                </div>
                <div class="col-auto">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}" class="text-muted text-decoration-none">
                                <i class="fa fa-dashboard"></i> Dashboard
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('employees.index') }}" class="text-muted text-decoration-none">
                                Pegawai
                            </a>
                        </li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Detail Content -->
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 200px;">NIP</th>
                        <td>{{ $employee->employee_number ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>{{ $employee->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $employee->email ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>No. HP</th>
                        <td>{{ $employee->phone ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Kelamin</th>
                        <td>{{ $employee->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Lahir</th>
                        <td>{{ $employee->birth_date ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>{{ $employee->address ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Foto</th>
                        <td>
                            @if ($employee->photo)
                                <img src="{{ asset('storage/fotoproduct/pegawai/' . $employee->photo) }}" alt="Foto Pegawai"
                                    class="img-thumbnail" style="max-height: 150px;">
                            @else
                                <span class="text-muted">Tidak ada foto</span>
                            @endif

                        </td>
                    </tr>
                    <tr>
                        <th>Departemen</th>
                        <td>{{ $employee->department->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Posisi</th>
                        <td>{{ $employee->position->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{{ $employee->status->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Masuk</th>
                        <td>{{ $employee->date_joined ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Status Aktif</th>
                        <td>
                            @if ($employee->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-danger">Nonaktif</span>
                            @endif
                        </td>
                    </tr>
                </table>

                <a href="{{ route('employees.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
@endsection
