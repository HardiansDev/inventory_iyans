@extends('layouts.master')

@section('title')
    <title>KASIRIN.ID - Tambah Bahan Baku</title>
@endsection

@section('content')
    <section class="max-w-3xl mx-auto mt-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8">
        <h1 class="text-3xl font-bold mb-8 text-gray-800 dark:text-gray-100">Bahan Baku</h1>

        <form action="{{ route('bahan_baku.store') }}" method="POST">
            @csrf

            <div class="space-y-4">
                <!-- Nama -->
                <div>
                    <label for="name" class="block font-medium text-gray-700 dark:text-gray-200 mb-1">Nama Bahan
                        Baku</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-600
                              bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                              px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none
                              transition @error('name') border-red-500 @enderror"
                        required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Supplier -->
                <div>
                    <label for="supplier_id"
                        class="block font-medium text-gray-700 dark:text-gray-200 mb-1">Supplier</label>
                    <select name="supplier_id" id="supplier_id"
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-600
                               bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                               px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none
                               transition @error('supplier_id') border-red-500 @enderror">
                        <option value="">-- Pilih Supplier --</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" @selected(old('supplier_id'))>{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                    @error('supplier_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kategori -->
                <div>
                    <label for="category_id"
                        class="block font-medium text-gray-700 dark:text-gray-200 mb-1">Kategori</label>
                    <select name="category_id" id="category_id"
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-600
                               bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                               px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none
                               transition @error('category_id') border-red-500 @enderror">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id'))>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Satuan -->
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Satuan
                    </label>
                    <select name="satuan_id"
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-gray-800
               focus:border-blue-500 focus:ring focus:ring-blue-200
               dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                        required>
                        <option value="">Pilih Satuan</option>
                        @foreach ($satuans as $satuan)
                            <option value="{{ $satuan->id }}" {{ old('satuan_id') == $satuan->id ? 'selected' : '' }}>
                                {{ $satuan->nama_satuan }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <!-- Stok & Harga -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="stock" class="block font-medium text-gray-700 dark:text-gray-200 mb-1">Stok</label>
                        <input type="number" name="stock" id="stock" min="0" value="{{ old('stock', 0) }}"
                            class="w-full rounded-lg border border-gray-300 dark:border-gray-600
                                  bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                                  px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none
                                  transition @error('stock') border-red-500 @enderror"
                            required>
                        @error('stock')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="price" class="block font-medium text-gray-700 dark:text-gray-200 mb-1">Harga
                            (Rp)</label>
                        <input type="number" name="price" id="price" min="0" step="0.01"
                            value="{{ old('price', 0) }}"
                            class="w-full rounded-lg border border-gray-300 dark:border-gray-600
                                  bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                                  px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none
                                  transition @error('price') border-red-500 @enderror"
                            required>
                        @error('price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="description"
                        class="block font-medium text-gray-700 dark:text-gray-200 mb-1">Deskripsi</label>
                    <textarea name="description" id="description" rows="3"
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-600
                                 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                                 px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none
                                 transition @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-4 mt-6">
                <a href="{{ route('bahan_baku.index') }}"
                    class="px-6 py-2 rounded-lg bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-100
                      hover:bg-gray-400 dark:hover:bg-gray-500 transition">Batal</a>
                <button type="submit"
                    class="px-6 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">Simpan</button>
            </div>
        </form>
    </section>
@endsection
