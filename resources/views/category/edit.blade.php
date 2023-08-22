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
                        <h3 class="box-title">Form Edits Category</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <form action="{{ route('category.update', ['id' => $categories->id]) }}" method="POST">
                                        @csrf
                                        {{ method_field('PUT') }}
                                        <div class="input-group">
                                            <input type="text"
                                                class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                                name="name" value="{{ $categories->name }}" required>
                                            <span class="input-group-btn">
                                                <button class="btn btn-info btn-flat" type="submit">Simpan</button>
                                                <a href="/category" class="btn btn-danger btn-flat">Gajadi</a>
                                            </span>
                                        </div>
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
