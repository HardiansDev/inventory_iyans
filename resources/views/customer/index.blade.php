@extends('layouts.master')

@section('title')
    <title>Aplikasi Inventory | Customer</title>
@endsection

@section('content')
    <!-- Content Header -->
    <section class="content-header py-4 bg-light rounded">
        <div class="container-fluid">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto">
                    <h1 class="mb-0 text-black">Management Customer</h1>
                </div>
                <div class="col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}" class="text-decoration-none text-secondary">
                                    <i class="fa fa-dashboard"></i> Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Customer</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

@endsection
