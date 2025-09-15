@extends('layouts.master')

@section('title')
    <title>KASIRIN.ID - Bahan Baku</title>
@endsection

@section('content')
    <!-- Header -->
    <section class="mb-6 rounded-lg bg-white dark:bg-gray-800 p-6 shadow">
        <div class="flex justify-between items-center max-w-7xl mx-auto">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Data Bahan Baku</h1>
            <a href="{{ route('bahan_baku.create') }}" class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
                Tambah Bahan Baku
            </a>
        </div>
    </section>

    <!-- Content -->
    <section class="max-w-7xl mx-auto bg-white dark:bg-gray-800 rounded shadow p-6">
        <!-- Search Form -->
        <form method="GET" action="{{ route('bahan_baku.index') }}" class="mb-4 flex gap-2">
            <input type="search" name="search" value="{{ $search ?? '' }}" placeholder="Cari bahan baku..."
                class="border rounded px-3 py-2 flex-grow bg-white dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" />
            <button type="submit" class="bg-blue-600 text-white rounded px-4 py-2 hover:bg-blue-700">
                Cari
            </button>
            <a href="{{ route('bahan_baku.index') }}" class="bg-gray-400 text-white rounded px-4 py-2 hover:bg-gray-500">
                Reset
            </a>
        </form>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table
                class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm text-gray-700 dark:text-gray-200">
                <thead class="bg-gray-50 dark:bg-gray-700">
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
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-4 py-2">{{ $bahan->name }}</td>
                            <td class="px-4 py-2">{{ $bahan->supplier?->name ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $bahan->category?->name ?? '-' }}</td>
                            <td class="px-4 py-2 text-right">{{ $bahan->stock }}</td>
                            <td class="px-4 py-2 text-right">Rp {{ number_format($bahan->price, 0, ',', '.') }}</td>

                            <td class="px-4 py-2 text-center">
                                <div x-data="{ open: false, confirmDelete: false }" class="relative inline-block text-left">
                                    <!-- Dropdown Trigger -->
                                    <button @click="open = !open"
                                        class="p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none">
                                        <!-- Icon 3 dots -->
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
                                                class="flex items-center px-3 py-2 text-sm text-blue-600 dark:text-blue-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                <!-- Eye Icon -->
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                    stroke-width="2" viewBox="0 0 24 24">
                                                    <path
                                                        d="M1.5 12s4.5-7.5 10.5-7.5S22.5 12 22.5 12s-4.5 7.5-10.5 7.5S1.5 12 1.5 12z" />
                                                    <circle cx="12" cy="12" r="3" />
                                                </svg>
                                                Detail
                                            </a>
                                            <a href="{{ route('bahan_baku.edit', $bahan->id) }}"
                                                class="flex items-center px-3 py-2 text-sm text-yellow-500 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-yellow-400">
                                                <!-- Pencil Icon -->
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                    stroke-width="2" viewBox="0 0 24 24">
                                                    <path d="M15.232 5.232l3.536 3.536M9 11l6-6 3 3-6 6H9v-3z" />
                                                </svg>
                                                Edit
                                            </a>
                                            <button @click="confirmDelete = true; open = false"
                                                class="w-full flex items-center px-3 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-red-400">
                                                <!-- Trash Icon -->
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                    stroke-width="2" viewBox="0 0 24 24">
                                                    <path
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4" />
                                                </svg>
                                                Hapus
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Modal Delete -->
                                    <div x-show="confirmDelete"
                                        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-30"
                                        x-cloak>
                                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 max-w-sm w-full">
                                            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-3">
                                                Konfirmasi Hapus</h2>
                                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                                                Apakah kamu yakin ingin menghapus <span
                                                    class="font-bold">{{ $bahan->nama }}</span>?
                                            </p>
                                            <div class="flex justify-end space-x-2">
                                                <button @click="confirmDelete = false"
                                                    class="px-4 py-2 bg-gray-300 dark:bg-gray-700 rounded-md hover:bg-gray-400 dark:hover:bg-gray-600">
                                                    Batal
                                                </button>
                                                <form action="{{ route('bahan_baku.destroy', $bahan->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
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
                            <td colspan="7" class="text-center px-4 py-6 text-gray-500 dark:text-gray-400">
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
