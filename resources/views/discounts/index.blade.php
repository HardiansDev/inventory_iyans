@extends('layouts.master')

@section('title')
    <title>Sistem Inventory Iyan | Diskon</title>
@endsection

@section('content')
    <!-- Header -->
    <section class="mb-6 rounded-lg bg-white p-6 shadow-sm">
        <div class="mx-auto flex max-w-7xl flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
            <!-- Title -->
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Manajemen Diskon</h1>
                <p class="mt-1 text-sm text-gray-500">Kelola data diskon yang tersedia dalam sistem inventory Anda</p>
            </div>
        </div>
    </section>

    <!-- Konten -->
    <section class="rounded bg-white p-6 shadow-sm" x-data="discountModal()" x-init="init()">
        <div class="mb-4 grid grid-cols-1 gap-4 md:grid-cols-2">
            <!-- Tombol Tambah -->
            <div x-data="{ open: false }">
                <button @click="open = true"
                    class="inline-flex items-center gap-2 rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
                    <i class="fas fa-plus-circle"></i>
                    Tambah Diskon
                </button>

                <!-- Modal Tambah -->
                <div x-show="open" x-cloak x-transition
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                    <div @click.away="open = false" class="w-full max-w-md rounded-lg bg-white shadow-lg">
                        <div class="rounded-t-lg bg-teal-600 px-4 py-3 text-white">
                            <h5 class="text-lg font-semibold">
                                <i class="fas fa-percent mr-2"></i> Tambah Diskon
                            </h5>
                        </div>
                        <div class="p-4">
                            <form action="{{ route('discounts.store') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="name" class="block text-sm font-medium text-gray-700">Nama
                                        Diskon</label>
                                    <input type="text" name="name" id="name"
                                        class="mt-1 w-full rounded-md border p-2 shadow-sm focus:ring-teal-400" required>
                                </div>
                                <div class="mb-4">
                                    <label for="nilai" class="block text-sm font-medium text-gray-700">Nilai (%)</label>
                                    <input type="number" name="nilai" id="nilai" min="0" max="100"
                                        step="0.01"
                                        class="mt-1 w-full rounded-md border p-2 shadow-sm focus:ring-teal-400">
                                </div>
                                <div class="mt-6 flex justify-end gap-2">
                                    <button type="button" @click="open = false"
                                        class="rounded bg-gray-200 px-4 py-2 hover:bg-gray-300">Batal</button>
                                    <button type="submit"
                                        class="rounded bg-green-600 px-4 py-2 text-white hover:bg-green-700">
                                        <i class="fas fa-save mr-1"></i> Simpan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Pencarian -->
            <div class="flex justify-end">
                <form action="{{ route('discounts.index') }}" method="GET" class="flex items-center gap-2">
                    <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari diskon..."
                        class="w-60 rounded-md border px-3 py-2 text-sm shadow-sm focus:ring-blue-500" />
                    <button type="submit" class="rounded bg-blue-600 px-4 py-2 text-sm text-white hover:bg-blue-700">
                        <i class="fas fa-search mr-2"></i>Cari
                    </button>
                    <a href="{{ route('discounts.index') }}"
                        class="rounded bg-gray-300 px-4 py-2 text-sm text-gray-800 hover:bg-gray-400">
                        <i class="fas fa-redo-alt mr-2"></i>Reset
                    </a>
                </form>
            </div>
        </div>

        <!-- Tabel Data -->
        <div class="overflow-x-auto rounded-lg border border-gray-200 shadow">
            <table class="min-w-full divide-y divide-gray-200 bg-white text-sm text-gray-700">
                <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                    <tr>
                        <th class="px-4 py-2">Nama Diskon</th>
                        <th class="px-4 py-2">Nilai (%)</th>
                        <th class="w-40 px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($discounts as $discount)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $discount->name }}</td>
                            <td class="px-4 py-2">{{ $discount->nilai ?? '-' }}</td>
                            <td class="px-4 py-2 text-center">
                                <div class="flex justify-center gap-2">
                                    <button type="button"
                                        @click="openEdit({{ $discount->id }}, '{{ $discount->name }}', {{ $discount->nilai }})"
                                        class="flex items-center gap-1 rounded bg-yellow-400 px-2 py-1 text-sm text-white hover:bg-yellow-500">
                                        <i class="fas fa-edit text-xs"></i> Edit
                                    </button>
                                    <button type="button"
                                        @click="openDelete({{ $discount->id }}, '{{ $discount->name }}')"
                                        class="flex items-center gap-1 rounded bg-red-500 px-2 py-1 text-sm text-white hover:bg-red-600">
                                        <i class="fas fa-trash-alt text-xs"></i> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-6 text-center text-gray-500">Belum ada data diskon.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Modal Edit -->
            <div x-show="showEdit" x-cloak x-transition
                class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
                <div class="w-full max-w-md rounded-lg bg-white p-6 shadow-lg">
                    <h2 class="mb-4 text-lg font-semibold">Edit Diskon</h2>
                    <form :action="editAction" method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                        <div class="mb-3">
                            <label class="mb-1 block font-medium">Nama Diskon</label>
                            <input type="text" name="name" x-model="editData.name"
                                class="w-full rounded border px-3 py-2" required>
                        </div>
                        <div class="mb-3">
                            <label class="mb-1 block font-medium">Nilai (%)</label>
                            <input type="number" name="nilai" x-model="editData.nilai"
                                class="w-full rounded border px-3 py-2" step="0.01" min="0" max="100">
                        </div>
                        <div class="flex justify-end gap-2">
                            <button type="button" @click="showEdit = false"
                                class="rounded bg-gray-300 px-3 py-1">Batal</button>
                            <button type="submit"
                                class="rounded bg-green-600 px-3 py-1 text-white hover:bg-green-700">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Hapus -->
            <div x-show="showDelete" x-cloak x-transition
                class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
                <div class="w-full max-w-md rounded-lg bg-white p-6 text-center shadow-lg">
                    <h2 class="mb-2 text-lg font-semibold">Konfirmasi Hapus</h2>
                    <p>Yakin ingin menghapus diskon <strong x-text="deleteData.name"></strong>?</p>
                    <form :action="deleteAction" method="POST" class="mt-4">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                        <div class="flex justify-center gap-2">
                            <button type="button" @click="showDelete = false"
                                class="rounded bg-gray-300 px-3 py-1">Batal</button>
                            <button type="submit"
                                class="rounded bg-red-600 px-3 py-1 text-white hover:bg-red-700">Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            function discountModal() {
                return {
                    showEdit: false,
                    showDelete: false,
                    editData: {
                        id: null,
                        name: '',
                        nilai: ''
                    },
                    deleteData: {
                        id: null,
                        name: ''
                    },
                    get editAction() {
                        return `/discounts/${this.editData.id}`;
                    },
                    get deleteAction() {
                        return `/discounts/${this.deleteData.id}`;
                    },
                    openEdit(id, name, nilai) {
                        this.editData = {
                            id,
                            name,
                            nilai
                        };
                        this.showEdit = true;
                    },
                    openDelete(id, name) {
                        this.deleteData = {
                            id,
                            name
                        };
                        this.showDelete = true;
                    },
                    init() {
                        this.showEdit = false;
                        this.showDelete = false;
                    }
                };
            }
        </script>
    @endpush
@endsection
