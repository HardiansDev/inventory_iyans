@extends('layouts.master')
@section('title')
    <title>Aplikasi Inventory | Product</title>
@endsection

@section('styles')
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
@endsection

@section('content')
    <section class="content-header">
        <h1>
            Page Details Product
            <small>Gudangku </small>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Detail Product {{ $products->name }}</h3>
                    <hr>
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <style>
                                .label {
                                    display: inline-block;
                                    width: 100px;
                                    /* Sesuaikan lebar sesuai kebutuhan */
                                    text-align: left;
                                    margin-right: 20px;
                                    /* Memberi sedikit ruang antara label dan teks */

                                    color: black;
                                    font-size: 13px;
                                }
                            </style>
                            <br>
                            @if ($products)
                                <img src="{{ asset('fotoproduct/' . $products->photo) }}"
                                    alt=""style="width: 500px;">
                                <div class="col-md-6">
                                    <p>
                                        <span class="label">Nama : </span> {{ $products->name }}
                                    </p>
                                    <p>
                                        <span class="label">Code Product : </span> {{ $products->code }}
                                    </p>
                                    <p>
                                        <span class="label">Category : </span> {{ $products->categories->name }}
                                    </p>
                                    <p>
                                        <span class="label">Price : </span> Rp. {{ $products->price }}
                                    </p>
                                    <p>
                                        <span class="label">Qty : </span> {{ $products->qty }}
                                    </p>
                                    <p>
                                        <span class="label">Stock : </span> {{ $products->stock }}
                                    </p>
                                    <p>
                                        <span class="label">Quality : </span> {{ $products->quality }}
                                    </p>
                                    <p>
                                        <span class="label">No.Purchase : </span> {{ $products->purchase }}
                                    </p>
                                    <p>
                                        <span class="label">Bill Number : </span> {{ $products->billnum }}
                                    </p>
                                    <p>
                                        <span class="label">Supplier : </span> {{ $products->suppliers->name }}
                                    </p>
                                    <p>
                                        <span class="label">PIC : </span> {{ $products->pics->name }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <a href="/product" class="btn btn-danger btn-sm">Kembali</a>
                            <a href="#" class="btn btn-warning btn-sm">Print</a>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
