@extends('layouts.master')
@section('title')
    <title>Aplikasi Inventory | Supplier </title>
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
                        <h3 class="box-title">Form Edits Supplier</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="form-row">
                                    <form role="form" action="/supplier/update/{{ $suppliers->id }}" method="POST">
                                        @csrf
                                        {{ method_field('PUT') }}
                                        <div class="form-group col-md-3">
                                            <input type="text"
                                                class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                                name="name" id="name" placeholder="Nama Supplier"
                                                value="{{ $suppliers->name }}" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <input type="text"
                                                class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}"
                                                name="address" id="address" placeholder="Alamat Supplier"
                                                value="{{ $suppliers->address }}" required>
                                        </div>
                                        <span class="input-group-btn">
                                            <button class="btn btn-info btn-flat" type="submit">Simpan</button>
                                            <a href="/supplier" class="btn btn-danger btn-flat">Gajadi</a>
                                        </span>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
