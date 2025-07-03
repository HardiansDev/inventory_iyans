@extends('layouts.master')

@section('title')
    <title>Sistem Inventory Iyan | Pengguna</title>
@endsection

@section('content')
    <section class="content-header py-4 bg-light rounded mb-4">
        <div class="container-fluid">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto">
                    <h1 class="mb-0 text-black">Manajemen Pengguna</h1>
                </div>
                <div class="col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}" class="text-decoration-none text-secondary">
                                    <i class="fa fa-dashboard"></i> Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Pengguna</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <div class="row">
        <!-- Form Tambah User (Kiri) -->
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Tambah Pengguna</h5>
                </div>
                <form action="{{ route('user.store') }}" method="POST" id="userForm">
                    @csrf
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="name" placeholder="Masukkan Nama Lengkap"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Masukkan Email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Kata Sandi</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="password" id="passwordInput"
                                    placeholder="Masukkan Password" required>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="fa fa-eye-slash"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Peran</label>
                            <select class="form-select" name="role" required>
                                <option value="" disabled selected>Pilih Peran</option>
                                <option value="superadmin">Super Admin</option>
                                <option value="admin_gudang">Admin Gudang</option>
                                <option value="kasir">Kasir</option>
                                <option value="manager">Manager</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer text-end bg-light">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-plus me-1"></i> Tambah
                        </button>
                        <button type="button" class="btn btn-secondary" id="resetButton">
                            <i class="fa fa-undo me-1"></i> Reset
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- List Data User (Kanan) -->
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Data Pengguna</h5>
                    <div class="position-relative d-flex align-items-center">
                        <button class="btn btn-light btn-sm" id="toggleSearch">
                            Cari Data
                        </button>

                        <form action="{{ route('user.index') }}" method="GET"
                            class="position-absolute top-50 end-100 translate-middle-y d-none me-2" id="searchForm"
                            style="z-index: 1050; min-width: 250px;">
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" name="search" placeholder="Cari user..."
                                    value="{{ $search }}">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>


                </div>

                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 5%">No</th>
                                <th>Email</th>
                                <th>Nama Lengkap</th>
                                <th>Peran</th>
                                <th style="width: 15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $index => $user)
                                <tr>
                                    <td>{{ $index + $users->firstItem() }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>
                                        <span class="badge bg-secondary text-capitalize">
                                            {{ str_replace('_', ' ', $user->role) }}
                                        </span>
                                    </td>
                                    <td>
                                        <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm w-100">
                                                <i class="fas fa-trash-alt"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Tidak ada data pengguna.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="card-footer">
                    {!! $users->appends(Request::except('page'))->links() !!}
                </div>
            </div>
        </div>
    </div>

    <!-- JS Interaksi -->
    <script>
        // Reset form
        document.getElementById('resetButton').addEventListener('click', function() {
            document.getElementById('userForm').reset();
        });

        // Toggle visibility password
        document.getElementById('togglePassword').addEventListener('click', function() {
            const input = document.getElementById('passwordInput');
            const icon = this.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        });

        // Toggle search form
        document.getElementById('toggleSearch').addEventListener('click', function() {
            document.getElementById('searchForm').classList.toggle('d-none');
        });
    </script>
@endsection
