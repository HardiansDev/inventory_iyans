@extends('layouts.master')

@section('title')
    <title>Aplikasi Inventory | PIC</title>
@endsection

@section('content')
    <section class="content-header py-4 bg-light rounded">
        <div class="container-fluid">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto">
                    <h1 class="mb-0 text-black">Management PIC</h1>
                </div>
                <div class="col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}" class="text-decoration-none text-secondary">
                                    <i class="fa fa-dashboard"></i> Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">PIC</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Data PIC</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <form role="form" action="{{ route('pic.store') }}" method="POST">
                                        @csrf
                                        <div class="input-group">
                                            <input type="text"
                                                class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                                name="name" placeholder="Input PIC Disini.." id="name" required>
                                            <span class="input-group-btn">
                                                <button class="btn btn-info btn-flat">Tambah PIC</button>
                                            </span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <form action="{{ route('pic.index') }}" method="GET">
                                        <div class="input-group">
                                            <input type="search" class="form-control" name="search"
                                                placeholder="Cari Disini" id="search" value="{{ $search }}"
                                                autofocus>
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn btn-warning btn-flat">Cari</button>
                                            </span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <p></p>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama PIC</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @forelse ($pics as $index => $item)
                                    <tr>
                                        <td> {{ $index + $pics->firstItem() }} </td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                        <td>
                                            <!-- Tombol Edit -->
                                            <a href="{{ route('pic.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>

                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('pic.destroy', ['pic' => $item->id]) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm deletepic"
                                                    data-idpic="{{ $item->id }}" data-namapic="{{ $item->name }}">
                                                    <i class="fas fa-trash-alt"></i> Hapus
                                                </button>
                                            </form>
                                        </td>


                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Sayang Banget Data nya Gaada</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $pics->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
