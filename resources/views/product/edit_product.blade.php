@extends('layouts.master')
@section('title')
    <title>Aplikasi Inventory | Edit Product</title>
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
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Edit Product</h3>
                    </div>
                    <!-- form start -->
                    <form role="form" action="{{ route('product.update', ['id' => $products->id]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        {{ method_field('PUT') }}
                        <div class="box-body">
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1">Nama Product</label>
                                <input type="text" class="form-control" name="name" id="exampleInputEmail1"
                                    value="{{ $products->name }}" placeholder="Masukkan Nama Product" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputPassword1">Kode Product</label>
                                <input type="text" class="form-control" name="code" id="exampleInputPassword1"
                                    value="{{ $products->code }}" placeholder="Masukkan Kode Product" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputFile">Upload Foto</label>
                                <input type="file" id="exampleInputFile" class="form-control" name="photo">
                                <img src="{{ asset('fotoproduct/' . $products->photo) }}"
                                    alt=""style="width: 60px;">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Kategori </label>
                                <select class="form-control" name="category_id" required>
                                    @foreach ($datacategory as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $products->category_id == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputPassword1">Harga Product</label>
                                <input type="number" class="form-control" id="exampleInputPassword1"
                                    placeholder="Masukkan Harga Product" name="price" value="{{ $products->price }}"
                                    required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputPassword1">Qty Product</label>
                                <input type="text" class="form-control" id="exampleInputPassword1"
                                    placeholder="Masukkan Qty Product" name="qty" value="{{ $products->qty }}" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputPassword1">Stok</label>
                                <input type="text" class="form-control" id="exampleInputPassword1"
                                    placeholder="Masukkan Stock Product" name="stock" value="{{ $products->stock }}"
                                    required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputPassword1">Quality</label>
                                <input type="text" class="form-control" id="exampleInputPassword1"
                                    placeholder="Masukkan Quality Product" name="quality" value="{{ $products->quality }}"
                                    required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputPassword1">No Purchase</label>
                                <input type="text" class="form-control" id="exampleInputPassword1"
                                    placeholder="Masukkan No Purchase" name="purchase" value="{{ $products->purchase }}"
                                    required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputPassword1">Billing Number</label>
                                <input type="text" class="form-control" id="exampleInputPassword1"
                                    placeholder="Masukkan Billing Number Product" name="billnum"
                                    value="{{ $products->billnum }}" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Supplier </label>
                                <select class="form-control" name="supplier_id" required>

                                    @foreach ($datasupplier as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $products->supplier_id == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>PIC </label>
                                <select class="form-control" name="pic_id" required>
                                    {{-- <option selected>{{ $products->pics->name }}</option> --}}
                                    @foreach ($datapic as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $products->pic_id == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary btn-sm">Ubah Product</button>
                            <a href="{{ route('product.index') }}" class="btn btn-danger btn-sm">Ga Jadi</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
