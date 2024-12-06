@extends('layouts.master')

@section('title')
    <title>Aplikasi Inventory | PIC</title>
@endsection

@section('content')
    <section class="content-header">
        <h1>
            Management PIC
            <small>Gudangku </small>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Form Edit PIC</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <!-- Form for editing PIC -->
                                    <form action="{{ route('pic.update', $pic->id) }}" method="POST">
                                        @csrf
                                        @method('PUT') <!-- Method spoofing for PUT -->
                                        <div class="input-group">
                                            <input type="text"
                                                class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                                name="name" value="{{ old('name', $pic->name) }}" required>
                                            <span class="input-group-btn">
                                                <button class="btn btn-info btn-flat" type="submit">Simpan</button>
                                                <a href="{{ route('pic.index') }}" class="btn btn-danger btn-flat">Batal</a>
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
