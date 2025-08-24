@extends('layouts.master')

@section('title')
    <title>Detail Bahan Baku</title>
@endsection

@section('content')
    <section class="max-w-3xl mx-auto bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-8">
        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                📦 {{ $bahanBaku->name }}
            </h1>
            <a href="{{ route('bahan_baku.index') }}"
                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg shadow hover:bg-blue-700 transition">
                ⬅ Kembali
            </a>
        </div>

        {{-- Table Detail --}}
        <div class="overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700">
            <table class="w-full text-sm text-gray-700 dark:text-gray-300">
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                        <th class="w-1/3 text-left py-3 px-4 font-semibold">Supplier</th>
                        <td class="py-3 px-4">{{ $bahanBaku->supplier?->name ?? '-' }}</td>
                    </tr>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                        <th class="text-left py-3 px-4 font-semibold">Kategori</th>
                        <td class="py-3 px-4">{{ $bahanBaku->category?->name ?? '-' }}</td>
                    </tr>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                        <th class="text-left py-3 px-4 font-semibold">Stok</th>
                        <td class="py-3 px-4">{{ $bahanBaku->stock }}</td>
                    </tr>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                        <th class="text-left py-3 px-4 font-semibold">Harga</th>
                        <td class="py-3 px-4">Rp {{ number_format($bahanBaku->price, 0, ',', '.') }}</td>
                    </tr>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                        <th class="text-left py-3 px-4 font-semibold">Deskripsi</th>
                        <td class="py-3 px-4 whitespace-pre-line">{{ $bahanBaku->description ?? '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
@endsection
