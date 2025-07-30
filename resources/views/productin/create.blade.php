@extends('layouts.master')

@section('title')
    <title>Sistem Inventory Iyan | Input Produk Masuk</title>
@endsection

@section('content')
    <section class="mb-6 rounded-lg bg-white p-6 shadow-sm">
        <div class="mx-auto flex max-w-7xl flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Tambah Produk Masuk</h1>
                <p class="mt-1 text-sm text-gray-500">
                    kelola data produk yang masuk ke dalam penjualan
                </p>
            </div>

            <!-- Breadcrumb -->
            <nav
                class="text-sm text-gray-600"
                aria-label="Breadcrumb"
            >
                <ol class="flex items-center space-x-2">
                    <li>
                        <a
                            href="{{ route('productin.index') }}"
                            class="flex items-center text-gray-500 hover:text-blue-600"
                        >
                            <i class="fa fa-box mr-1"></i>
                            <span>Produk Masuk</span>
                        </a>
                    </li>
                    <li>
                        <svg
                            class="mx-1 h-4 w-4 text-gray-400"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path d="M6 9a1 1 0 000 2h8a1 1 0 000-2H6z" />
                        </svg>
                    </li>
                    <li class="text-gray-400">Tambah Produk Masuk</li>
                </ol>
            </nav>
        </div>
    </section>


    <div class="container mx-auto mt-6 px-4">
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-lg">
            <h2 class="mb-6 text-xl font-semibold text-gray-800">Form Tambah Produk Masuk</h2>

            <form
                action="{{ route('productin.storeProductIn') }}"
                method="POST"
                enctype="multipart/form-data"
                class="space-y-4"
            >
                @csrf

                <div
                    id="dynamic-form"
                    class="space-y-4"
                >
                    <div class="grid grid-cols-12 items-end gap-4 border-b border-gray-200 pb-4">
                        <div class="col-span-3">
                            <label class="mb-1 block text-sm font-medium text-gray-700">Nama Produk</label>
                            <select
                                name="product_id[]"
                                class="product-select w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                                required
                            >
                                <option
                                    value=""
                                    disabled
                                    selected
                                >Pilih Produk</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }} (Stok: {{ $product->stock }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <input
                            type="hidden"
                            name="supplier_id[]"
                            class="hidden-supplier"
                        />
                        <input
                            type="hidden"
                            name="category_id[]"
                            class="hidden-category"
                        />

                        <div class="col-span-2">
                            <label class="mb-1 block text-sm font-medium text-gray-700">Tanggal</label>
                            <input
                                type="date"
                                name="date[]"
                                class="w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                                required
                            >
                        </div>

                        <div class="col-span-2">
                            <label class="mb-1 block text-sm font-medium text-gray-700">Jumlah</label>
                            <input
                                type="number"
                                name="qty[]"
                                class="w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                                required
                            >
                        </div>



                        <div class="col-span-2 flex justify-end">
                            <button
                                type="button"
                                class="remove-row rounded-lg bg-red-500 px-4 py-2 text-sm text-white shadow hover:bg-red-600"
                            >Hapus</button>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <button
                        type="button"
                        id="add-row"
                        class="rounded-lg bg-green-600 px-5 py-2 text-sm font-medium text-white shadow hover:bg-green-700"
                    >
                        + Tambah Baris
                    </button>
                </div>

                <div class="mt-6 flex justify-between">
                    <a
                        href="{{ route('productin.index') }}"
                        class="inline-flex items-center rounded-lg bg-gray-200 px-5 py-2 text-sm font-medium text-gray-700 shadow hover:bg-gray-300"
                    >
                        <
                            Kembali
                            </a
                        >
                            <button
                                type="submit"
                                class="rounded-lg bg-blue-600 px-6 py-2 text-sm font-medium text-white shadow hover:bg-blue-700"
                            >
                                Ajukan
                            </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const formContainer = document.getElementById('dynamic-form');
            const addRowButton = document.getElementById('add-row');

            const generateRow = () => {
                return `
                <div class="grid grid-cols-12 gap-4 items-end border-b border-gray-200 pb-4">
                    <div class="col-span-3">
                        <select name="product_id[]" class="product-select w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500" required>
                            <option value="" disabled selected>Pilih Produk</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }} (Stok: {{ $product->stock }})</option>
                            @endforeach
                        </select>
                    </div>

                    <input type="hidden" name="supplier_id[]" class="hidden-supplier" />
                    <input type="hidden" name="category_id[]" class="hidden-category" />

                    <div class="col-span-2">
                        <input type="date" name="date[]" class="w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500" required>
                    </div>

                    <div class="col-span-2">
                        <input type="number" name="qty[]" class="w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500" required>
                    </div>

                    <div class="col-span-2 text-right">
                        <button type="button" class="remove-row rounded-lg bg-red-500 px-4 py-2 text-sm text-white shadow hover:bg-red-600">Hapus</button>
                    </div>
                </div>
            `;
            };

            addRowButton.addEventListener('click', function() {
                formContainer.insertAdjacentHTML('beforeend', generateRow());
            });

            formContainer.addEventListener('change', function(event) {
                if (event.target.matches('select[name="product_id[]"]')) {
                    const productId = event.target.value;
                    const row = event.target.closest('.grid');

                    if (productId) {
                        fetch(`/get-product-details/${productId}`)
                            .then(response => response.json())
                            .then(data => {
                                row.querySelector('.hidden-supplier').value = data.supplier_id;
                                row.querySelector('.hidden-category').value = data.category_id;
                            })
                            .catch(error => console.error('Fetch error:', error));
                    }
                }
            });

            formContainer.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-row')) {
                    const row = e.target.closest('.grid');
                    if (formContainer.querySelectorAll('.grid').length > 1) {
                        row.remove();
                    } else {
                        alert('Minimal 1 baris harus ada.');
                    }
                }
            });
        });
    </script>
@endsection
