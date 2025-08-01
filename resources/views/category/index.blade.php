@extends('layouts.master')
@section('title')
    <title>Sistem Inventory Iyan | Kategori</title>
@endsection

@section('content')
    <!-- Header -->
    <section class="mb-6 rounded-lg bg-white p-6 shadow-sm">
        <div class="mx-auto flex max-w-7xl flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
            <!-- Title -->
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Manajemen Kategori</h1>
                <p class="mt-1 text-sm text-gray-500">
                    Kelola data kategori dalam sistem inventory Anda
                </p>
            </div>
        </div>
    </section>

    <!-- Konten -->
    <section class="rounded bg-white p-6 shadow-sm">
        <div class="mb-4 grid grid-cols-1 gap-4 md:grid-cols-2">
            <div>
                <button onclick="openCategoryModal()"
                    class="flex w-full items-center gap-2 rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 md:w-auto">
                    <i class="fas fa-plus-circle"></i>
                    <span>Tambah Kategori</span>
                </button>
            </div>

            <!-- Form Pencarian -->
            <div class="mb-4 flex justify-end">
                <form action="{{ route('category.index') }}" method="GET" class="flex items-center gap-2">
                    <input type="search" name="search" value="{{ $search }}" placeholder="Cari..."
                        class="w-60 rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:w-72" />
                    <button type="submit"
                        class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm text-white shadow-sm hover:bg-blue-700">
                        <i class="fas fa-search mr-2"></i>
                        Cari
                    </button>
                    <a href="{{ route('category.index') }}"
                        class="ml-2 inline-flex items-center rounded-md bg-gray-300 px-4 py-2 text-sm text-gray-800 shadow-sm hover:bg-gray-400"">
                        <i class="fas fa-redo-alt mr-2"></i>
                        Reset
                    </a>
                </form>
            </div>
        </div>

        <!-- Tabel Data -->
        <div class="overflow-x-auto rounded-lg border border-gray-200 shadow">
            <table id="example1" class="min-w-full divide-y divide-gray-200 bg-white text-sm text-gray-700">
                <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                    <tr>
                        {{-- <th class="px-4 py-2 border">No</th> --}}
                        <th class="px-4 py-2">Nama Kategori</th>
                        <th class="px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $index => $item)
                        <tr class="hover:bg-gray-50">
                            {{-- <td class="px-4 py-2 border">{{ $index + $categories->firstItem() }}</td> --}}
                            <td class="px-4 py-2">{{ $item->name }}</td>
                            <td class="px-4 py-2 text-center">
                                <div class="flex justify-center gap-2">
                                    <!-- Tombol trigger modal -->
                                    <button type="button"
                                        onclick="openEditModal({{ $item->id }}, '{{ $item->name }}')"
                                        class="rounded bg-yellow-400 px-3 py-1 text-sm text-white hover:bg-yellow-500">
                                        <i class="fas fa-edit"></i>
                                        Edit
                                    </button>

                                    <!-- Trigger button -->
                                    <button type="button"
                                        onclick="openDeleteModal({{ $item->id }}, '{{ $item->name }}')"
                                        class="rounded bg-red-500 px-3 py-1 text-sm text-white hover:bg-red-600">
                                        <i class="fas fa-trash-alt"></i>
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-6 text-center text-gray-500">
                                Kategori tidak ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <!-- Modal Edit Kategori -->
            <div id="editCategoryModal"
                class="fixed inset-0 z-50 flex hidden items-center justify-center bg-black bg-opacity-50">
                <div class="w-full max-w-md rounded-lg bg-white p-6 shadow-lg">
                    <h2 class="mb-4 text-lg font-semibold text-gray-800">Edit Kategori</h2>
                    <form id="editCategoryForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="editCategoryName" class="block text-sm font-medium text-gray-700">
                                Nama Kategori
                            </label>
                            <input type="text" name="name" id="editCategoryName"
                                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-blue-500"
                                required />
                        </div>
                        <div class="flex justify-end gap-2">
                            <button type="button" onclick="closeEditModal()"
                                class="rounded bg-gray-300 px-4 py-2 text-gray-800 hover:bg-gray-400">
                                Batal
                            </button>
                            <button type="submit" class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Tambah Kategori -->
            <div id="categoryModal"
                class="fixed inset-0 z-50 flex hidden items-center justify-center bg-black bg-opacity-50">
                <div class="w-full max-w-md rounded-lg bg-white p-6 shadow-lg">
                    <h2 class="mb-4 text-lg font-semibold text-gray-800">Tambah Kategori</h2>
                    <form action="{{ route('category.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">
                                Nama Kategori
                            </label>
                            <input type="text" name="name" id="name"
                                class="{{ $errors->has('name') ? 'border-red-500' : '' }} mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-blue-500"
                                placeholder="Masukkan kategori..." required />
                        </div>
                        <div class="flex justify-end gap-2">
                            <button type="button" onclick="closeCategoryModal()"
                                class="rounded bg-gray-300 px-4 py-2 text-gray-800 hover:bg-gray-400">
                                Batal
                            </button>
                            <button type="submit" class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
                                Tambah
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Konfirmasi Hapus -->
            <div id="deleteModal" class="fixed inset-0 z-50 flex hidden items-center justify-center bg-black bg-opacity-50">
                <div class="w-full max-w-md rounded-lg bg-white p-6 shadow-lg">
                    <h2 class="mb-4 text-lg font-semibold text-gray-800">Konfirmasi Hapus</h2>
                    <p class="mb-6 text-gray-700">
                        Yakin ingin menghapus kategori
                        <span id="categoryName" class="font-bold"></span>
                        ?
                    </p>

                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="flex justify-end gap-2">
                            <button type="button" onclick="closeDeleteModal()"
                                class="rounded bg-gray-300 px-4 py-2 text-gray-800 hover:bg-gray-400">
                                Batal
                            </button>
                            <button type="submit" class="rounded bg-red-600 px-4 py-2 text-white hover:bg-red-700">
                                Hapus
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-4 flex justify-end">
            {{ $categories->appends(Request::except('page'))->links('vendor.pagination.tailwind') }}
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        function openEditModal(id, name) {
            const modal = document.getElementById('editCategoryModal')
            const form = document.getElementById('editCategoryForm')
            const input = document.getElementById('editCategoryName')

            // Set value
            input.value = name

            // Set action
            form.action = `/category/${id}`

            // Tampilkan modal
            modal.classList.remove('hidden')
        }

        function closeEditModal() {
            const modal = document.getElementById('editCategoryModal')
            modal.classList.add('hidden')
        }

        // Tutup modal jika klik luar konten
        window.addEventListener('click', function(e) {
            const modal = document.getElementById('editCategoryModal')
            if (e.target === modal) {
                closeEditModal()
            }
        })

        function openDeleteModal(id, name) {
            const modal = document.getElementById('deleteModal')
            const form = document.getElementById('deleteForm')
            const nameSpan = document.getElementById('categoryName')

            form.action = `/category/${id}`
            nameSpan.textContent = name

            modal.classList.remove('hidden')
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden')
        }

        // Klik luar modal menutup modal
        window.addEventListener('click', function(e) {
            const modal = document.getElementById('deleteModal')
            if (e.target === modal) {
                closeDeleteModal()
            }
        })

        function openCategoryModal() {
            document.getElementById('categoryModal').classList.remove('hidden')
        }

        function closeCategoryModal() {
            document.getElementById('categoryModal').classList.add('hidden')
        }
    </script>
@endpush
