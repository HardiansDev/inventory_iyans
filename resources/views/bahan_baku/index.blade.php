@extends('layouts.master')

@section('title')
    <title>Data Bahan Baku</title>
@endsection

@section('content')
    <section class="mb-6 rounded-lg bg-white p-6 shadow-sm">
        <div class="flex justify-between items-center max-w-7xl mx-auto">
            <h1 class="text-2xl font-bold text-gray-800">Data Bahan Baku</h1>
            <a href="{{ route('bahan_baku.create') }}"
                class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">Tambah Bahan Baku</a>
        </div>
    </section>

    <section class="max-w-7xl mx-auto bg-white rounded shadow p-6">
        <form method="GET" action="{{ route('bahan_baku.index') }}" class="mb-4 flex gap-2">
            <input type="search" name="search" value="{{ $search ?? '' }}" placeholder="Cari bahan baku..."
                class="border rounded px-3 py-2 flex-grow" />
            <button type="submit" class="bg-blue-600 text-white rounded px-4 py-2 hover:bg-blue-700">Cari</button>
            <a href="{{ route('bahan_baku.index') }}"
                class="bg-gray-400 text-white rounded px-4 py-2 hover:bg-gray-500">Reset</a>
        </form>



        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-700">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left">Nama</th>
                        <th class="px-4 py-2 text-left">Supplier</th>
                        <th class="px-4 py-2 text-left">Kategori</th>
                        <th class="px-4 py-2 text-right">Stok</th>
                        <th class="px-4 py-2 text-right">Harga</th>

                        <th class="px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bahanBakus as $bahan)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $bahan->name }}</td>
                            <td class="px-4 py-2">{{ $bahan->supplier?->name ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $bahan->category?->name ?? '-' }}</td>
                            <td class="px-4 py-2 text-right">{{ $bahan->stock }}</td>
                            <td class="px-4 py-2 text-right">Rp {{ number_format($bahan->price, 0, ',', '.') }}</td>

                            <td class="px-4 py-2 text-center space-x-2">
                                <a href="{{ route('bahan_baku.show', $bahan->id) }}"
                                    class="text-blue-600 hover:text-blue-800 font-semibold">Detail</a>
                                <a href="{{ route('bahan_baku.edit', $bahan->id) }}"
                                    class="text-yellow-500 hover:text-yellow-700 font-semibold">Edit</a>
                                <form action="{{ route('bahan_baku.destroy', $bahan->id) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Yakin ingin menghapus bahan baku ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-600 hover:text-red-800 font-semibold">Hapus</button>
                                </form>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center px-4 py-6 text-gray-500">Tidak ada data bahan baku.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $bahanBakus->links('vendor.pagination.tailwind') }}
        </div>
    </section>
@endsection
