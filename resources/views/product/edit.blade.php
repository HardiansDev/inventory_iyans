@extends('layouts.master')

@section('title')
    <title>Sistem Inventory Iyan | Edit Produk</title>
@endsection

@section('content')
    <section class="mb-6 rounded-lg bg-white p-6 shadow-sm">
        <div class="mx-auto flex max-w-7xl flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
            <!-- Title -->
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Edit Produk</h1>
                <p class="mt-1 text-sm text-gray-500">
                    Ubah informasi produk sesuai kebutuhan Anda
                </p>
            </div>


        </div>
    </section>

    <!-- Form -->
    <div class="rounded-xl bg-white p-6 shadow-lg">
        <form action="{{ route('product.update', ['product' => $product->id]) }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                <!-- Nama Produk -->
                <div>
                    <label for="productName" class="mb-1 block text-sm font-semibold text-gray-700">
                        Nama Produk
                    </label>
                    <input type="text" name="name" id="productName"
                        class="w-full rounded-md border border-gray-300 px-4 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                        value="{{ $product->name }}" required />
                </div>

                <!-- Kode Produk -->
                <div>
                    <label for="productCode" class="mb-1 block text-sm font-semibold text-gray-700">
                        Kode Produk
                    </label>
                    <input type="text" name="code" id="productCode"
                        class="w-full cursor-not-allowed rounded-md border border-gray-200 bg-gray-100 px-4 py-2 text-gray-500"
                        value="{{ $product->code }}" readonly />
                </div>

                <!-- Upload Foto -->
                <div>
                    <label for="productPhoto" class="mb-1 block text-sm font-semibold text-gray-700">
                        Upload Foto
                    </label>
                    <input type="file" name="photo" id="productPhoto"
                        class="w-full rounded-lg border-gray-300 text-sm file:border-none file:bg-gray-100 file:px-3 file:py-2 file:text-gray-700" />

                    @if ($product->photo)
                        <img src="{{ asset('/storage/fotoproduct/produk/' . $product->photo) }}" alt="Foto Produk"
                            class="mt-2 h-20 w-20 rounded border border-gray-300 shadow-md" />
                    @else
                        <p class="mt-2 text-sm text-gray-400">Foto tidak tersedia</p>
                    @endif
                </div>

                <!-- Kategori -->
                <div>
                    <label for="categorySelect" class="mb-1 block text-sm font-semibold text-gray-700">
                        Kategori
                    </label>
                    <select name="category_id" id="categorySelect"
                        class="w-full rounded-md border border-gray-300 px-4 py-2 shadow-sm focus:ring-2 focus:ring-blue-400"
                        required>
                        <option value="">Pilih Kategori</option>
                        @foreach ($datacategory as $category)
                            <option value="{{ $category->id }}"
                                {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Harga Produk -->
                <div>
                    <label for="productPrice" class="mb-1 block text-sm font-semibold text-gray-700">
                        Harga Produk
                    </label>
                    <input type="number" name="price" id="productPrice"
                        class="@error('price') border-red-500 @else border-gray-300 @enderror w-full rounded-md border px-4 py-2 shadow-sm focus:ring-2 focus:ring-blue-400"
                        value="{{ $product->price }}" required />
                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Stok -->
                <div>
                    <label for="productStock" class="mb-1 block text-sm font-semibold text-gray-700">
                        Stok
                    </label>
                    <input type="number" name="stock" id="productStock"
                        class="w-full rounded-md border border-gray-300 px-4 py-2 shadow-sm focus:ring-2 focus:ring-blue-400"
                        value="{{ $product->stock }}" required />
                </div>

                <!-- Supplier -->
                <div>
                    <label for="supplierSelect" class="mb-1 block text-sm font-semibold text-gray-700">
                        Supplier
                    </label>
                    <select name="supplier_id" id="supplierSelect"
                        class="w-full rounded-md border border-gray-300 px-4 py-2 shadow-sm focus:ring-2 focus:ring-blue-400"
                        required>
                        <option value="">Pilih Supplier</option>
                        @foreach ($datasupplier as $supplier)
                            <option value="{{ $supplier->id }}"
                                {{ $product->supplier_id == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="mt-8 flex justify-end space-x-3">
                <button type="submit"
                    class="inline-flex items-center rounded-md bg-blue-600 px-5 py-2 text-white shadow hover:bg-blue-700">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Perubahan
                </button>
                <a href="{{ route('product.index') }}"
                    class="inline-flex items-center rounded-md bg-gray-100 px-5 py-2 text-gray-700 shadow hover:bg-gray-200">
                    <i class="fas fa-times mr-2"></i>
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
