@extends('layouts.master')

@section('title')
    <title>Detail Bahan Baku</title>
@endsection

@section('content')
    <section class="max-w-4xl mx-auto bg-white rounded shadow p-6">
        <h1 class="text-2xl font-bold mb-4">{{ $bahanBaku->name }}</h1>

        <table class="w-full text-gray-700">
            <tr>
                <th class="text-left py-2">Supplier</th>
                <td class="py-2">{{ $bahanBaku->supplier?->name ?? '-' }}</td>
            </tr>
            <tr>
                <th class="text-left py-2">Kategori</th>
                <td class="py-2">{{ $bahanBaku->category?->name ?? '-' }}</td>
            </tr>
            <tr>
                <th class="text-left py-2">Stok</th>
                <td class="py-2">{{ $bahanBaku->stock }}</td>
            </tr>
            <tr>
                <th class="text-left py-2">Harga</th>
                <td class="py-2">Rp {{ number_format($bahanBaku->price, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th class="text-left py-2">Deskripsi</th>
                <td class="py-2 whitespace-pre-line">{{ $bahanBaku->description ?? '-' }}</td>
            </tr>
        </table>

        <div class="mt-6">
            <a href="{{ route('bahan_baku.index') }}" class="text-blue-600 hover:underline">Kembali ke daftar bahan baku</a>
        </div>
    </section>
@endsection
