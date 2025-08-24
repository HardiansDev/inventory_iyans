@extends('layouts.master')

@section('title')
    <title>Tambah Bahan Baku</title>
@endsection

@section('content')
    <section class="max-w-3xl mx-auto bg-white dark:bg-gray-800 rounded shadow p-6 mt-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">Tambah Bahan Baku</h1>

        <form action="{{ route('bahan_baku.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="name" class="block font-medium text-gray-700 dark:text-gray-200">Nama Bahan Baku</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                    class="mt-1 block w-full rounded border border-gray-300 dark:border-gray-600
                           bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                           px-3 py-2 @error('name') border-red-500 @enderror"
                    required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="supplier_id" class="block font-medium text-gray-700 dark:text-gray-200">Supplier</label>
                <select name="supplier_id" id="supplier_id"
                    class="mt-1 block w-full rounded border border-gray-300 dark:border-gray-600
                           bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                           px-3 py-2 @error('supplier_id') border-red-500 @enderror">
                    <option value="">-- Pilih Supplier --</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" @selected(old('supplier_id'))>{{ $supplier->name }}</option>
                    @endforeach
                </select>
                @error('supplier_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="category_id" class="block font-medium text-gray-700 dark:text-gray-200">Kategori</label>
                <select name="category_id" id="category_id"
                    class="mt-1 block w-full rounded border border-gray-300 dark:border-gray-600
                           bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                           px-3 py-2 @error('category_id') border-red-500 @enderror">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id'))>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="stock" class="block font-medium text-gray-700 dark:text-gray-200">Stok</label>
                <input type="number" name="stock" id="stock" min="0" value="{{ old('stock', 0) }}"
                    class="mt-1 block w-full rounded border border-gray-300 dark:border-gray-600
                           bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                           px-3 py-2 @error('stock') border-red-500 @enderror"
                    required>
                @error('stock')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="price" class="block font-medium text-gray-700 dark:text-gray-200">Harga (Rp)</label>
                <input type="number" name="price" id="price" min="0" step="0.01"
                    value="{{ old('price', 0) }}"
                    class="mt-1 block w-full rounded border border-gray-300 dark:border-gray-600
                           bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                           px-3 py-2 @error('price') border-red-500 @enderror"
                    required>
                @error('price')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="description" class="block font-medium text-gray-700 dark:text-gray-200">Deskripsi</label>
                <textarea name="description" id="description" rows="3"
                    class="mt-1 block w-full rounded border border-gray-300 dark:border-gray-600
                           bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                           px-3 py-2 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-4">
                <a href="{{ route('bahan_baku.index') }}"
                    class="px-4 py-2 rounded bg-gray-300 dark:bg-gray-600
                           hover:bg-gray-400 dark:hover:bg-gray-500
                           text-gray-700 dark:text-gray-100">Batal</a>
                <button type="submit" class="px-4 py-2 rounded bg-blue-600 hover:bg-blue-700 text-white">Simpan</button>
            </div>
        </form>
    </section>
@endsection
