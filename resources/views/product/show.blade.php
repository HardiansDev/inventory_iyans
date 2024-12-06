@extends('layouts.master')
@section('title')
    <title>Aplikasi Inventory | Product</title>
@endsection

@section('styles')
    <style>
        /* Wrapper untuk detail produk */
        .product-details-container {
            display: flex;
            justify-content: space-between;
            gap: 30px;
            margin-bottom: 20px;
            align-items: flex-start;
            flex-wrap: wrap;
        }

        /* Gambar produk (sebelah kanan) */
        .product-image {
            flex: 1;
            max-width: 100%;
            height: auto;
            padding: 10px;
            border-radius: 10px;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        /* Gambar dengan properti responsive */
        .product-image img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        /* Detail produk (sebelah kiri) */
        .product-info {
            flex: 2;
            max-width: 700px;
            padding: 20px;
            background-color: #e9e9e9;
            border-radius: 10px;
            color: rgb(37, 37, 37);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        /* Styling untuk paragraf informasi */
        .product-info p {
            margin-bottom: 15px;
            font-size: 16px;
            line-height: 1.5;
        }

        /* Styling untuk label */
        .label {
            font-weight: bold;
            color: #0e0e0e;
        }

        /* Tombol kembali dan print */
        .btn-container {
            margin-top: 30px;
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        /* Tombol dengan gaya */
        .btn-container .btn {
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        /* Responsif untuk tampilan mobile */
        @media (max-width: 768px) {
            .product-details-container {
                flex-direction: column;
                align-items: center;
                gap: 20px;
            }

            .product-info {
                max-width: 100%;
                padding: 15px;
            }

            .product-image {
                max-width: 90%;
                margin-bottom: 10px;
            }

            .btn-container {
                flex-direction: column;
            }

            .btn-container .btn {
                width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>
@endsection

@section('content')
    <section class="content-header">
        <h1>
            Page Details Product
            <small>Gudangku</small>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Detail Product {{ $product->name }}</h3>
                    <hr>
                </div>

                <div class="box-body">
                    <div class="product-details-container">
                        <!-- Informasi Produk (sebelah kiri) -->
                        <div class="product-info">
                            <p><span class="label">Nama :</span> {{ $product->name }}</p>
                            <p><span class="label">Kode Produk :</span> {{ $product->code }}</p>
                            <p><span class="label">Kategori :</span> {{ $product->category->name }}</p>
                            <p><span class="label">Harga :</span> Rp. {{ number_format($product->price, 0, ',', '.') }}</p>
                            <p><span class="label">Qty :</span> {{ $product->qty }}</p>
                            <p><span class="label">Stock :</span> {{ $product->stock }}</p>
                            <p><span class="label">Quality :</span> {{ $product->quality }}</p>
                            <p><span class="label">No.Purchase :</span> {{ $product->purchase }}</p>
                            <p><span class="label">Bill Number :</span> {{ $product->billnum }}</p>
                            <p><span class="label">Supplier :</span> {{ $product->supplier->name }}</p>
                            <p><span class="label">PIC :</span> {{ $product->pic->name }}</p>
                        </div>

                        <!-- Gambar Produk (sebelah kanan) -->
                        <div class="product-image">
                            <img src="{{ asset('fotoproduct/' . $product->photo) }}" alt="Product Image">
                        </div>
                    </div>

                    <div class="btn-container">
                        <!-- Tombol Kembali dengan Ikon -->
                        <a href="{{ route('product.index') }}" class="btn btn-danger btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>

                        <!-- Tombol Print dengan Ikon -->
                        <a id="print-btn" class="btn btn-warning btn-sm">
                            <i class="fas fa-print"></i> Print
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Script untuk Print PDF -->
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script> --}}
@endsection
