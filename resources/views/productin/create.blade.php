@extends('layouts.master')

@section('title')
    <title>Sistem Inventory Iyan | Tambah Produk Masuk</title>
@endsection

@section('content')
    <section class="content-header py-4 bg-light rounded">
        <div class="container-fluid">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto">
                    <h1 class="mb-0 text-black">Tambah Data Produk Masuk</h1>
                </div>
                <div class="col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('productin.index') }}" class="text-decoration-none text-secondary">
                                    <i class="fa fa-dashboard"></i> Produk Masuk
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah Produk Masuk</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <div class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Tambah Produk Masuk </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('productin.storeProductIn') }}" method="POST">
                    @csrf

                    <!-- Dynamic Form Container -->
                    <div id="dynamic-form">
                        <div class="row mb-3">
                            <!-- Nama Produk -->
                            <div class="col-md-3">
                                <label for="product_id" class="form-label">Nama Produk</label>
                                <select name="product_id[]" class="form-select" required>
                                    <option value="" disabled selected>Pilih Produk</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">
                                            {{ $product->name }} (Stok: {{ $product->stock }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Supplier ID - Hidden -->
                            <input type="hidden" name="supplier_id[]" class="hidden-supplier">

                            <!-- Category ID - Hidden -->
                            <input type="hidden" name="category_id[]" class="hidden-category">


                            <!-- Tanggal Masuk -->
                            <div class="col-md-2">
                                <label for="date" class="form-label">Tanggal Masuk</label>
                                <input type="date" name="date[]" class="form-control" required>
                            </div>

                            <!-- Jumlah -->
                            <div class="col-md-2">
                                <label for="qty" class="form-label">Jumlah</label>
                                <input type="number" name="qty[]" class="form-control" required>
                            </div>
                            <div class="col-md-2">
                                <label for="recipient" class="form-label">Penerima</label>
                                <input type="text" name="recipient[]" class="form-control" required>
                            </div>

                            <!-- Tombol Hapus -->
                            <div class="col-md-1 d-flex align-items-end">
                                <button type="button" class="btn btn-danger btn-sm remove-row">Hapus</button>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Tambah Form -->
                    <div class="mb-3">
                        <button type="button" id="add-row" class="btn btn-success btn-sm">Tambah Baris</button>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Simpan Semua</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const formContainer = document.getElementById('dynamic-form');
            const addRowButton = document.getElementById('add-row');

            // Menambah baris baru
            addRowButton.addEventListener('click', function() {
                const newRow = `
        <div class="row mb-3">
            <div class="col-md-3">
                <select name="product_id[]" class="form-select" required>
                    <option value="" disabled selected>Pilih Produk</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }} (Stok: {{ $product->stock }})</option>
                    @endforeach
                </select>
            </div>

            <input type="hidden" name="supplier_id[]" class="hidden-supplier">
            <input type="hidden" name="category_id[]" class="hidden-category">

            <div class="col-md-2">
                <input type="date" name="date[]" class="form-control" required>
            </div>
            <div class="col-md-2">
                <input type="number" name="qty[]" class="form-control" required>
            </div>
            <div class="col-md-2">
                <input type="text" name="recipient[]" class="form-control" required>
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-danger btn-sm remove-row">Hapus</button>
            </div>
        </div>`;
                formContainer.insertAdjacentHTML('beforeend', newRow);
            });

            // Mengupdate supplier_id dan category_id ketika produk dipilih
            formContainer.addEventListener('change', function(e) {
                if (e.target.classList.contains('form-select')) {
                    const productId = e.target.value;
                    const row = e.target.closest('.row');
                    if (productId) {
                        fetch(`/get-product-details/${productId}`)
                            .then(response => response.json())
                            .then(data => {
                                // Mengisi nilai ke input hidden
                                row.querySelector('.hidden-supplier').value = data.supplier_id;
                                row.querySelector('.hidden-category').value = data.category_id;
                            })
                            .catch(error => console.error('Error:', error));
                    }
                }
            });

            // Event listener untuk menghapus baris
            formContainer.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-row')) {
                    e.target.closest('.row').remove();
                }
            });
        });
    </script>

    <script>
        // Saat ada perubahan pada dropdown produk
        document.addEventListener('change', function(event) {
            // Pastikan hanya dropdown produk yang memicu perubahan
            if (event.target.matches('select[name="product_id[]"]')) {
                const productId = event.target.value; // Ambil ID produk yang dipilih
                const row = event.target.closest('.row'); // Cari baris tempat dropdown berada

                if (productId) {
                    // Kirimkan permintaan AJAX untuk mendapatkan data produk berdasarkan ID
                    fetch(`/get-product-details/${productId}`)
                        .then(response => response.json())
                        .then(data => {
                            // Update input supplier_id dan category_id di baris yang sama
                            row.querySelector('input[name="supplier_id[]"]').value = data.supplier_id;
                            row.querySelector('input[name="category_id[]"]').value = data.category_id;
                        })
                        .catch(error => console.error('Error:', error));
                }
            }
        });
    </script>
@endsection
