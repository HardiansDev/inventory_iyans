@extends('layouts.master')
@section('title')
    <title>Aplikasi Inventory | Supplier</title>
@endsection

@section('content')
    <section class="content-header">
        <h1>
            Management Supplier
            <small>Gudangku </small>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Data Supplier</h3>
                    </div>
                    <div class="form-row">
                        <form role="form" action="{{ route('supplier.simpan') }}" method="POST">
                            @csrf
                            <div class="form-group col-md-3">
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="Nama Supplier" required>
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" name="address" id="address"
                                    placeholder="Alamat Supplier" required>
                            </div>
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-info btn-flat">Tambah Supplier</button>
                            </span>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <form action="{{ route('supplier.index') }}" method="GET">
                                <div class="input-group">
                                    <input type="search" class="form-control" name="search" placeholder="Cari Disini"
                                        id="search" value="{{ $search }}" autofocus>
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-warning btn-flat">Cari</button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Supplier</th>
                                <th>Alamat Supplier</th>
                                <th>Action</th>
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
                                        <a href="{{ route('supplier.edit', ['id' => $item->id]) }}"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <a href="#" class="btn btn-danger btn-sm deletesupp"
                                            data-idsupp="{{ $item->id }}" data-namasupp="{{ $item->name }}">Hapus</a>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Sayang Banget Data nya Gaada</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                    {!! $suppliers->appends(Request::except('page'))->render() !!}
                </div>
            </div>
        </div>
    </section>
@endsection
