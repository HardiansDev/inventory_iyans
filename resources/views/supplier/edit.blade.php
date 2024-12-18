@extends('layouts.master')

@section('title')
    <title>Sistem Inventory Iyan | Supplier</title>
@endsection

@section('content')
<section class="content-header py-4 bg-light rounded">
    <div class="container-fluid">
        <div class="row align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="mb-0 text-black">Data Supplier</h1>
            </div>
            <div class="col-auto">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}" class="text-decoration-none text-secondary">
                                <i class="fa fa-dashboard"></i> Dashboard
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Supplier</li>
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
                        <h3 class="box-title">Edit Supplier</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="form-row">
                                    <!-- Corrected Form Action and Route Method -->
                                    <form role="form" action="{{ route('supplier.update', $supplier->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT') <!-- Laravel's convention for update method -->

                                        <div class="box-body">
                                            <div class="form-row">
                                                <!-- Nama Supplier -->
                                                <div class="form-group col-md-3">
                                                    <label for="name">Nama Supplier</label>
                                                    <input type="text"
                                                        class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                                        name="name" id="name" placeholder="Nama Supplier"
                                                        value="{{ old('name', $supplier->name) }}" required>
                                                </div>

                                                <!-- Alamat Supplier -->
                                                <div class="form-group col-md-6">
                                                    <label for="address">Alamat Supplier</label>
                                                    <input type="text"
                                                        class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}"
                                                        name="address" id="address" placeholder="Alamat Supplier"
                                                        value="{{ old('address', $supplier->address) }}" required>
                                                </div>
                                            </div>

                                            <!-- Tombol Simpan dan Gajadi -->
                                            <div class="form-row mt-3">
                                                <div class="form-group col-md-6">
                                                    <div class="btn-group" role="group" aria-label="Supplier Actions">
                                                        <!-- Tombol Simpan -->
                                                        <button class="btn btn-info btn-flat" type="submit">
                                                            <i class="fas fa-save"></i> Simpan
                                                        </button>

                                                        <!-- Tombol Gajadi -->
                                                        <a href="{{ route('supplier.index') }}"
                                                            class="btn btn-danger btn-flat">
                                                            <i class="fas fa-times-circle"></i> Gajadi
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
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
