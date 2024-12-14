@extends('layouts.master')

@section('title')
    <title>Sistem Inventory Iyan | Pengguna</title>
@endsection

@section('content')
    <section class="content-header py-4 bg-light rounded">
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

    <section class="content">
        <div class="row">
            <!-- Form Input User -->
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tambah Pengguna</h3>
                    </div>

                    <form action="{{ route('user.store') }}" method="POST" id="userForm">
                        @csrf
                        <div class="box-body">
                            <div class="form-group col-md-4">
                                <label for="name">Nama Lengkap</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="Masukkan Nama Lengkap" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email"
                                    placeholder="Masukkan Email" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="password">Kata sandi</label>
                                <input type="password" class="form-control" name="password" id="password"
                                    placeholder="Masukkan Password" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="role">Peran</label>
                                <select class="form-control" name="role" id="role" required>
                                    <option value="" selected disabled>Pilih Peran</option>
                                    <option value="superadmin">Super Admin</option>
                                    <option value="admin_gudang">Admin Gudang</option>
                                    <option value="kasir">Kasir</option>
                                    <option value="manager">Manager</option>
                                </select>
                            </div>
                        </div>
                        <div class="box-footer">
                            <div class="btn-group" role="group" aria-label="User Actions">
                                <!-- Tombol Tambah User -->
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fa fa-plus me-1"></i>Tambah Pengguna
                                </button>
                                <!-- Tombol Reset -->
                                <button type="button" class="btn btn-danger btn-sm" id="resetButton">
                                    <i class="fa fa-times me-1"></i>Reset
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- JavaScript untuk tombol reset -->
                    <script>
                        document.getElementById('resetButton').addEventListener('click', function() {
                            // Reset semua input dalam form
                            document.getElementById('userForm').reset();
                        });
                    </script>
                </div>
            </div>
        </div>

        <!-- List Data User -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Data Pengguna</h3>
                        <div class="box-tools pull-right">
                            <form action="{{ route('user.index') }}" method="GET" class="form-inline">
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" name="search" placeholder="Cari User"
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
                                    <th>Email</th>
                                    <th>Username</th>
                                    <th>Peran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @forelse ($users as $index => $user)
                                    <tr>
                                        <td>{{ $index + $users->firstItem() }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->role }}</td>
                                        <td>
                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                                    <i class="fas fa-trash-alt"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">User Tidak Ada</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="box-footer clearfix">
                        {!! $users->appends(Request::except('page'))->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
