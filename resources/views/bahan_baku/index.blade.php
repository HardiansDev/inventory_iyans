@extends('layouts.master')

@section('title')
    <title>KASIRIN.ID - Bahan Baku</title>
@endsection

@section('content')
    <!-- Header -->
    <section class="mb-6 rounded-lg bg-white dark:bg-gray-800 p-6 shadow">
        <div class="mx-auto flex max-w-7xl flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
            <!-- Title -->
            <div>
                <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">Manajemen Bahan Baku</h1>
                <p class="mt-1 text-sm text-gray-500">
                    Kelola data Bahan Baku dalam sistem inventory Anda
                </p>
            </div>
        </div>
    </section>

    <!-- Content -->
    <section class="max-w-7xl mx-auto bg-white dark:bg-gray-800 rounded shadow p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
            <!-- Tombol Tambah -->
            <a href="{{ route('bahan_baku.create') }}"
                class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-white font-medium shadow hover:bg-blue-700 transition">
                <i class="fas fa-plus"></i>
                Tambah Bahan Baku
            </a>

            <!-- Form Pencarian -->
            <form method="GET" action="{{ route('bahan_baku.index') }}" class="flex gap-2 w-full sm:w-auto">
                <input type="search" name="search" value="{{ $search ?? '' }}" placeholder="Cari bahan baku..."
                    class="flex-grow border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" />

                <button type="submit"
                    class="inline-flex items-center gap-1 bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition font-medium">
                    <i class="fas fa-search"></i>
                    Cari
                </button>

                <a href="{{ route('bahan_baku.index') }}"
                    class="inline-flex items-center gap-1 bg-gray-400 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-500 transition font-medium">
                    <i class="fas fa-rotate-left"></i>
                    Reset
                </a>
            </form>
        </div>


        <!-- Table -->
        <div class="overflow-x-auto rounded-lg shadow-md">
            <table
                class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm text-gray-700 dark:text-gray-200">
                <thead class="bg-gray-100 dark:bg-gray-700 uppercase font-medium">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium">Nama</th>
                        <th class="px-4 py-3 text-left font-medium">Supplier</th>
                        <th class="px-4 py-3 text-left font-medium">Kategori</th>
                        <th class="px-4 py-3 text-right font-medium">Stok</th>
                        <th class="px-4 py-3 text-right font-medium">Harga</th>
                        <th class="px-4 py-3 text-center font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($bahanBakus as $bahan)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                            <td class="px-4 py-2">{{ $bahan->name }}</td>
                            <td class="px-4 py-2">{{ $bahan->supplier?->name ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $bahan->category?->name ?? '-' }}</td>
                            <td class="px-4 py-2 text-right">{{ $bahan->stock }} {{ $bahan->satuan?->nama_satuan }}</td>
                            <td class="px-4 py-2 text-right">Rp {{ number_format($bahan->price, 0, ',', '.') }}</td>

                            <td class="px-4 py-2 text-center">
                                <div x-data="{ open: false, confirmDelete: false }" class="relative inline-block text-left">
                                    <!-- Dropdown Trigger -->
                                    <button @click="open = !open"
                                        class="p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition focus:outline-none">
                                        <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M10 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zm0 5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zm0 5a1.5 1.5 0 110 3 1.5 1.5 0 010-3z" />
                                        </svg>
                                    </button>

                                    <!-- Dropdown Menu -->
                                    <div x-show="open" @click.away="open = false" x-transition
                                        class="class"="absolute bottom-full right-0 mb-2 w-52 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                                        <div class="py-1">
                                            <a href="{{ route('bahan_baku.show', $bahan->id) }}"
                                                class="flex items-center px-3 py-2 text-sm text-blue-600 dark:text-blue-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                                <i class="fas fa-eye mr-2"></i> Detail
                                            </a>
                                            <a href="{{ route('bahan_baku.edit', $bahan->id) }}"
                                                class="flex items-center px-3 py-2 text-sm text-yellow-500 dark:text-yellow-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                                <i class="fas fa-pencil-alt mr-2"></i> Edit
                                            </a>
                                            <button @click="confirmDelete = true; open = false"
                                                class="w-full flex items-center px-3 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                                <i class="fas fa-trash mr-2"></i> Hapus
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Modal Delete -->
                                    <div x-show="confirmDelete" x-cloak
                                        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-30">
                                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 max-w-sm w-full">
                                            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-3">
                                                Konfirmasi Hapus</h2>
                                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                                                Apakah kamu yakin ingin menghapus <span
                                                    class="font-bold">{{ $bahan->name }}</span>?
                                            </p>
                                            <div class="flex justify-end space-x-2">
                                                <button @click="confirmDelete = false"
                                                    class="px-4 py-2 bg-gray-300 dark:bg-gray-700 rounded-md hover:bg-gray-400 dark:hover:bg-gray-600 transition">
                                                    Batal
                                                </button>
                                                <form action="{{ route('bahan_baku.destroy', $bahan->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center px-4 py-6 text-gray-500 dark:text-gray-400">
                                Tidak ada data bahan baku.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


        <!-- Pagination -->
        <div class="mt-4">
            {{ $bahanBakus->links('vendor.pagination.tailwind') }}
        </div>
    </section>
@endsection
