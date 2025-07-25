@extends('layouts.master')

@section('title')
    <title>Tambah Pegawai | Sistem Inventory Iyan</title>
@endsection

@section('content')
    <!-- Header Section -->
    <section class="content-header py-4 bg-light rounded mb-4">
        <div class="container-fluid">
            <div class="row justify-content-between align-items-center">
                <div class="col-auto">
                    <h1 class="text-dark mb-0">Tambah Pegawai</h1>
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
                        <li class="breadcrumb-item active">Tambah Pegawai</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Form Tambah Pegawai -->
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    @include('employees._form') {{-- Inputan hanya field NIP, Nama, dsb --}}

                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="{{ route('employees.index') }}" class="btn btn-secondary">Kembali</a>
                </form>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.forEach(function(tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endpush
