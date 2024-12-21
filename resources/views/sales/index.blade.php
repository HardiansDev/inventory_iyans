@extends('layouts.master')

@section('title')
    <title>Sistem Inventory Iyan | Penjualan</title>
@endsection

@section('content')
    <section class="content-header py-4 bg-light rounded">
        <div class="container-fluid">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto">
                    <h1 class="mb-0 text-black">Menu Jualan</h1>
                </div>
                <div class="col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}" class="text-decoration-none text-secondary">
                                    <i class="fa fa-dashboard"></i> Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Penjualan</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container mt-4" style="max-width: 1200px;">
            <div class="row">
                @foreach ($sales as $sale)
                    @php
                        $productIn = $sale->productIn; // Mengambil data produk melalui relasi productIn
                        $product = $productIn->product; // Ambil produk terkait
                    @endphp
                    <div class="col-md-3 mb-4">
                        <div class="card h-100 shadow-sm"
                            style="border-radius: 10px; overflow: hidden; transition: transform 0.3s, box-shadow 0.3s; background: #fdfdfd;">
                            <div class="position-relative">
                                {{-- <span class="badge bg-danger position-absolute top-0 end-0 m-2"
                                    style="font-size: 12px; padding: 5px 10px; border-radius: 5px;">Diskon</span> --}}
                                <img src="{{ asset('storage/fotoproduct/' . $productIn->product->photo) }}"
                                    class="card-img-top" alt="Product Image" style="height: 150px; object-fit: cover;">
                            </div>
                            <div class="card-body" style="padding: 15px;">
                                <h5 class="card-title" style="font-size: 18px; font-weight: bold; color: #333;">
                                    {{ $product->name }}</h5>

                                <!-- Menampilkan kategori produk -->
                                @if ($product->category)
                                    <p class="text-muted small mb-1" style="font-size: 14px; color: #777;">
                                        {{ $product->category->name }}</p>
                                @else
                                    <p class="text-muted small mb-1" style="font-size: 14px; color: #777;">Kategori tidak
                                        tersedia</p>
                                @endif
                                <p class="text-muted small mb-1" style="font-size: 14px; color: #777;">{{ $sale->qty }}
                                    StokTersedia</p>
                                <!-- Menampilkan harga produk -->
                                <p class="card-text text-success fw-bold" style="font-size: 20px; margin-bottom: 10px;">Rp
                                    {{ number_format($product->price, 0, ',', '.') }}</p>

                                <!-- Quantity Control -->
                                <div class="d-flex align-items-center mb-3">
                                    <button class="btn btn-secondary adjust-qty" data-adjust="-1"
                                        style="background-color: #ff6f61; color: white; border-radius: 50%; width: 35px; height: 35px; display: flex; justify-content: center; align-items: center; font-size: 18px; padding: 0; border: none; cursor: pointer; transition: background-color 0.3s;">
                                        -
                                    </button>

                                    <input type="number" class="form-control mx-2 qty-input" value="1" min="1"
                                        style="width: 60px; text-align: center; font-size: 18px; border: 2px solid #ccc; border-radius: 8px; padding: 5px;">

                                    <button class="btn btn-secondary adjust-qty" data-adjust="1"
                                        style="background-color: #28a745; color: white; border-radius: 50%; width: 35px; height: 35px; display: flex; justify-content: center; align-items: center; font-size: 18px; padding: 0; border: none; cursor: pointer; transition: background-color 0.3s;">
                                        +
                                    </button>
                                </div>

                                <!-- Pesan Button -->
                                <button class="btn btn-primary add-to-wishlist" data-product-id="{{ $product->id }}"
                                    data-product-name="{{ $product->name }}" data-price="{{ $product->price }}"
                                    data-qty="1"
                                    style="background-color: #007bff; color: white; font-size: 16px; border-radius: 5px; padding: 10px 20px; cursor: pointer; transition: background-color 0.3s;">
                                    Pesan
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

            <!-- Wishlist Table -->
            <!-- Icon Cart -->
            <div style="position: fixed; top: 20px; right: 20px; z-index: 1100;">
                <button id="cart-icon" class="btn btn-transparent position-relative" style="color: white;">
                    <i class="fas fa-shopping-cart"></i>
                    <span id="cart-badge"
                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                        style="display: none;">
                        0
                    </span>
                </button>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="wishlistModal" tabindex="-1" aria-labelledby="wishlistModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="wishlistModalLabel">Wishlist Anda</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-sm">
                                <thead>
                                    <tr style="background-color: #f8f9fa;">
                                        <th>Nama Produk</th>
                                        <th>Qty</th>
                                        <th>Harga</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="wishlist-table-body">
                                    <!-- Wishlist items will be added here dynamically -->
                                </tbody>
                            </table>
                            <h5 style="margin-top: 15px; font-size: 16px; font-weight: bold; color: #555;">
                                Total Harga: <span id="total-price">Rp 0</span>
                            </h5>
                        </div>
                        <div class="modal-footer">
                            <button id="checkout-button" class="btn btn-success w-100"
                                style="display: none;">Checkout</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
