@extends('layouts.master')
@section('title')
    <title>KASIRIN.ID - Kategori</title>
@endsection

@section('content')
    <!-- Header -->
    <section class="mb-6 rounded-lg bg-white dark:bg-gray-800 p-6 shadow-sm">
        <div class="mx-auto flex max-w-7xl flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
            <!-- Title -->
            <div>
                <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">Manajemen Kategori</h1>
                <p class="mt-1 text-sm text-gray-500">
                    Kelola data kategori dalam sistem inventory Anda
                </p>
            </div>
        </div>
    </section>

    <!-- Konten -->
    <section class="rounded dark:bg-gray-800 dark:text-gray-100 p-6 shadow-sm">
        <div class="mb-4 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <!-- Tombol Tambah Kategori -->
            <div class="w-full md:w-auto">
                <button onclick="openCategoryModal()"
                    class="flex w-full items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 md:w-auto">
                    <i class="fas fa-plus-circle"></i>
                    <span>Tambah Kategori</span>
                </button>
            </div>

            <!-- Form Pencarian -->
            <div class="w-full md:w-auto">
                <form action="{{ route('category.index') }}" method="GET"
                    class="flex flex-col gap-3 sm:flex-row sm:items-center">

                    <!-- Input Search -->
                    <input type="search" name="search" value="{{ $search }}" placeholder="Cari..."
                        class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 shadow-sm
                   focus:border-blue-500 focus:ring-1 focus:ring-blue-500
                   dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600 dark:placeholder-gray-400
                   sm:w-72 transition-colors duration-200" />

                    <!-- Buttons -->
                    <div class="flex gap-2 sm:flex-none">
                        <button type="submit"
                            class="flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm
                       hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1
                       dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-400 transition-colors duration-200">
                            <i class="fas fa-search mr-2"></i>
                            Cari
                        </button>

                        <a href="{{ route('category.index') }}"
                            class="flex items-center justify-center rounded-lg bg-gray-300 px-4 py-2 text-sm font-medium text-gray-800 shadow-sm
                       hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-1
                       dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 dark:focus:ring-gray-500 transition-colors duration-200">
                            <i class="fas fa-redo-alt mr-2"></i>
                            Reset
                        </a>
                    </div>
                </form>
            </div>

        </div>


        <!-- Tabel Data Kategori -->
        <div class="overflow-x-auto rounded-lg shadow-md">
            <table
                class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm text-gray-700 dark:text-gray-200">
                <thead class="bg-gray-100 dark:bg-gray-700 uppercase font-medium">
                    <tr>
                        <th
                            class="px-4 py-3 text-left text-gray-700 dark:text-gray-200 font-medium uppercase tracking-wider">
                            Nama Kategori
                        </th>
                        <th
                            class="px-4 py-3 text-center text-gray-700 dark:text-gray-200 font-medium uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($categories as $item)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                            <td class="px-4 py-2">{{ $item->name }}</td>
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
                                            <!-- Edit -->
                                            <button type="button"
                                                onclick="openEditModal({{ $item->id }}, '{{ $item->name }}')"
                                                class="flex w-full items-center px-3 py-2 text-sm text-yellow-500 dark:text-yellow-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                                <i class="fas fa-edit mr-2"></i> Edit
                                            </button>

                                            <!-- Hapus -->
                                            <button type="button"
                                                onclick="openDeleteModal({{ $item->id }}, '{{ $item->name }}')"
                                                class="flex w-full items-center px-3 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                                <i class="fas fa-trash-alt mr-2"></i> Hapus
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                                Kategori tidak ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Modal Tambah Kategori -->
            <div id="categoryModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
                <div
                    class="w-full max-w-md rounded-xl bg-white dark:bg-gray-800 p-6 shadow-lg transform transition-all duration-300">
                    <h2 class="mb-4 text-lg font-semibold text-gray-900 dark:text-gray-100">Tambah Kategori</h2>
                    <form action="{{ route('category.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama
                                Kategori</label>
                            <input type="text" name="name" id="name" placeholder="Masukkan kategori..."
                                class="mt-1 block w-full rounded border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200
                        {{ $errors->has('name') ? 'border-red-500 dark:border-red-400' : '' }}"
                                required />
                        </div>
                        <div class="flex justify-end gap-2">
                            <button type="button" onclick="closeCategoryModal()"
                                class="px-4 py-2 rounded-lg bg-gray-300 text-gray-800 hover:bg-gray-400 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500">
                                Batal
                            </button>
                            <button type="submit"
                                class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">
                                Tambah
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Edit Kategori -->
            <div id="editCategoryModal"
                class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
                <div
                    class="w-full max-w-md rounded-xl bg-white dark:bg-gray-800 p-6 shadow-lg transform transition-all duration-300">
                    <h2 class="mb-4 text-lg font-semibold text-gray-900 dark:text-gray-100">Edit Kategori</h2>
                    <form id="editCategoryForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="editCategoryName"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Kategori</label>
                            <input type="text" name="name" id="editCategoryName"
                                class="mt-1 block w-full rounded border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                required />
                        </div>
                        <div class="flex justify-end gap-2">
                            <button type="button" onclick="closeEditModal()"
                                class="px-4 py-2 rounded-lg bg-gray-300 text-gray-800 hover:bg-gray-400 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500">
                                Batal
                            </button>
                            <button type="submit"
                                class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Konfirmasi Hapus -->
            <div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
                <div
                    class="w-full max-w-md rounded-xl bg-white dark:bg-gray-800 p-6 shadow-lg transform transition-all duration-300">
                    <h2 class="mb-4 text-lg font-semibold text-gray-900 dark:text-gray-100">Konfirmasi Hapus</h2>
                    <p class="mb-6 text-gray-700 dark:text-gray-300">
                        Yakin ingin menghapus kategori <span id="categoryName"
                            class="font-bold text-red-600 dark:text-red-400"></span>?
                    </p>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="flex justify-end gap-2">
                            <button type="button" onclick="closeDeleteModal()"
                                class="px-4 py-2 rounded-lg bg-gray-300 text-gray-800 hover:bg-gray-400 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500">
                                Batal
                            </button>
                            <button type="submit"
                                class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600">
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
        // Buka modal edit
        function openEditModal(id, name) {
            const modal = document.getElementById('editCategoryModal');
            const form = document.getElementById('editCategoryForm');
            const input = document.getElementById('editCategoryName');

            input.value = name;
            form.action = `/category/${id}`;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        // Tutup modal edit
        function closeEditModal() {
            const modal = document.getElementById('editCategoryModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        // Buka modal delete
        function openDeleteModal(id, name) {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteForm');
            const nameSpan = document.getElementById('categoryName');

            form.action = `/category/${id}`;
            nameSpan.textContent = name;

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        // Tutup modal delete
        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        // Buka modal tambah kategori
        function openCategoryModal() {
            const modal = document.getElementById('categoryModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        // Tutup modal tambah kategori
        function closeCategoryModal() {
            const modal = document.getElementById('categoryModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        // Global click event untuk close modal saat klik di luar kontennya
        window.addEventListener('click', function(e) {
            const modals = ['editCategoryModal', 'deleteModal', 'categoryModal'];

            modals.forEach(function(id) {
                const modal = document.getElementById(id);
                if (e.target === modal) {
                    modal.classList.remove('flex');
                    modal.classList.add('hidden');
                }
            });
        });
    </script>
@endpush
