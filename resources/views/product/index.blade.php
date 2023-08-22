@extends('layouts.master')
@section('title')
    <title>Aplikasi Inventory | Product</title>
@endsection

@section('content')
    <section class="content-header">
        <h1>
            Data Product
            <small>Gudangku </small>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">List Data Product</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-8">
                                <a href="{{ route('product.tambah') }}" class="btn btn-success btn-sm">Tambah Product</a>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <form action="{{ route('product.export') }}" method="POST">
                                        @csrf
                                        <div class="input-group">
                                            <select class="form-control" id="filtername" name="category" required>
                                                <option value="" selected>Fiter Category</option>
                                                @foreach ($datacategory as $item)
                                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="input-group-btn">
                                                <button class="btn btn-info btn-flat">Export Excel</button>
                                            </span>
                                        </div>

                                        {{-- <div class="col-md-4">
                                            <button class="btn btn-warning btn-sm">export excel</button>
                                        </div> --}}
                                    </form>
                                </div>
                            </div>
                            <br><br>
                        </div>

                        <table id="example1" class="table table-bordered table-striped mt-10">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Product</th>
                                    <th>Kode Product</th>
                                    <th>Gambar Product</th>
                                    <th>Kategori Product</th>
                                    <th>Harga</th>
                                    <th>Qty</th>
                                    <th>Stock</th>
                                    <th>Quality</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($products as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td> {{ $item->name }} </td>
                                        <td> {{ $item->code }} </td>
                                        <td>
                                            <img src="{{ asset('fotoproduct/' . $item->photo) }}"
                                                alt=""style="width: 60px;">
                                        </td>
                                        <td> {{ $item->categories->name ?? 'Tidak Ada kategory' }} </td>
                                        <td> {{ $item->price }} </td>
                                        <td> {{ $item->qty }} </td>
                                        <td> {{ $item->stock }} </td>
                                        <td> {{ $item->quality }} </td>
                                        <td>
                                            <a href="{{ route('product.detail', ['id' => $item->id]) }}"
                                                class="btn btn-primary btn-sm">Detail Product</a>
                                            <a href="{{ route('product.edit', ['id' => $item->id]) }}"
                                                class="btn btn-warning btn-sm">Edit</a>
                                            <a href="#" class="btn btn-danger btn-sm delete-prod"
                                                data-idprod="{{ $item->id }}"
                                                data-namaprod="{{ $item->name }}">Hapus</a>
                                            <a href="#" class="btn btn-info btn-sm">Masukkan Barang</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- {!! $products->appends(Request::except('page'))->render() !!} --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
