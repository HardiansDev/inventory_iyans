@extends('layouts.master')
@section('title')
    <title>Aplikasi Inventory | Category</title>
@endsection

@section('content')
    <section class="content-header">
        <h1>
            Management Category
            <small>Gudangku </small>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Data Category</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <form role="form" action="{{ route('category.simpan') }}" method="POST">
                                        @csrf
                                        <div class="input-group">
                                            <input type="text"
                                                class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                                name="name" placeholder="Input Category Disini.." id="name"
                                                required>
                                            <span class="input-group-btn">
                                                <button class="btn btn-info btn-flat">Tambah Category</button>
                                            </span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <form action="/category" method="GET">
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
                                    <th>Nama Category</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @forelse ($categories as $index => $item)
                                    <tr>
                                        <td> {{ $index + $categories->firstItem() }} </td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            <a href="/category/edit/{{ $item->id }}"
                                                class="btn btn-warning btn-sm">Edit</a>
                                            <a href="#" class="btn btn-danger btn-sm delete-cate"
                                                data-idcate="{{ $item->id }}"
                                                data-namacate="{{ $item->name }}">Hapus</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Sayang Banget Data nya Gaada</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{-- {{ $categories->links() }} --}}
                        {!! $categories->appends(Request::except('page'))->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
