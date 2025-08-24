@extends('layouts.master')

@section('title')
    <title>Sistem Inventory Iyan | Produk</title>
@endsection

@section('content')
    <!-- Header Section -->
    <section class="mb-6 rounded-lg bg-white dark:bg-gray-800 p-6 shadow-sm">
        <div class="mx-auto flex max-w-7xl flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
            <!-- Title -->
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Manajemen Produk</h1>
                <p class="mt-1 text-sm text-gray-500">
                    Kelola data produk dalam sistem inventory Anda
                </p>
            </div>


        </div>
    </section>

    <!-- Main Content -->
    <section class="content bg-white">
        <div class="card shadow-sm bg-white">
            <div class="card-body bg-white dark:bg-gray-800 dark:text-gray-100 p-6">
                <!-- Bagian Tombol Aksi -->
                <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <!-- Kiri: Tombol Aksi -->
                    <div class="flex flex-col gap-2 sm:flex-row">
                        <button type="button" onclick="openModal()"
                            class="inline-flex w-full sm:w-auto items-center gap-2 rounded bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700">
                            <i class="fas fa-plus-circle"></i>
                            Tambah Produk
                        </button>

                        <form id="bulkDeleteForm" method="POST" action="{{ route('product.bulkDelete') }}"
                            class="w-full sm:w-auto">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="ids" id="bulkDeleteIds" />
                            <button id="deleteAllBtn" type="submit"
                                class="inline-flex w-full sm:w-auto hidden items-center gap-2 rounded bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 disabled:opacity-50"
                                disabled>
                                <i class="fas fa-trash-alt"></i>
                                Pilih Menghapus
                            </button>
                        </form>
                    </div>

                    <!-- Kanan: Dropdown Unduh Data -->
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                        <div x-data="{ open: false }" class="relative w-full sm:w-auto">
                            <button @click="open = !open"
                                class="inline-flex w-full sm:w-auto items-center gap-2 rounded bg-teal-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-teal-700">
                                <i class="fas fa-download"></i>
                                Unduh Data
                                <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.25 8.29a.75.75 0 01-.02-1.06z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false"
                                class="absolute z-10 mt-2 w-full sm:w-52 overflow-hidden rounded border border-gray-200 bg-white shadow-lg">
                                <form action="{{ route('product.export') }}" method="POST">
                                    @csrf
                                    <button type="submit" name="export_type" value="excel"
                                        class="w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-file-excel mr-2 text-green-600"></i>
                                        Unduh Excel
                                    </button>
                                </form>
                                <form action="{{ route('product.export') }}" method="POST">
                                    @csrf
                                    <button type="submit" name="export_type" value="pdf"
                                        class="w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-file-pdf mr-2 text-red-500"></i>
                                        Unduh PDF
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bagian Filter & Search -->
                <form action="{{ route('product.index') }}" method="GET"
                    class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:gap-6">
                    <!-- Filter Kategori -->
                    <div class="w-full sm:w-auto">
                        <label for="filtername" class="mb-1 block text-sm font-medium dark:bg-gray-800 dark:text-gray-100">
                            <i class="fas fa-filter mr-1 text-gray-500"></i>
                            Filter Kategori
                        </label>
                        <select name="category" id="filtername"
                            class="w-full sm:w-72 rounded-md border border-gray-300 px-3 py-2 text-sm dark:bg-gray-800 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Pilih Kategori</option>
                            @foreach ($datacategory as $category)
                                <option value="{{ $category->name }}"
                                    {{ request('category') == $category->name ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Search Produk -->
                    <div class="w-full sm:w-auto">
                        <label for="search" class="mb-1 block text-sm font-medium dark:bg-gray-800 dark:text-gray-100">
                            <i class="fas fa-search mr-1 text-gray-500"></i>
                            Cari Produk
                        </label>
                        <input type="text" name="search" id="search" placeholder="Nama produk..."
                            value="{{ request('search') }}"
                            class="w-full sm:w-72 rounded-md border border-gray-300 px-3 py-2 text-sm dark:bg-gray-800 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                    </div>

                    <!-- Tombol Filter & Reset -->
                    <div class="flex w-full sm:w-auto gap-2 sm:mt-0">
                        <button type="submit"
                            class="flex-1 sm:flex-none inline-flex items-center justify-center rounded-md bg-blue-600 px-4 py-2 text-sm text-white shadow-sm hover:bg-blue-700">
                            <i class="fas fa-search mr-2"></i>
                            Filter
                        </button>
                        <a href="{{ route('product.index') }}"
                            class="flex-1 sm:flex-none inline-flex items-center justify-center rounded-md bg-gray-300 px-4 py-2 text-sm text-gray-800 shadow-sm hover:bg-gray-400">
                            <i class="fas fa-redo-alt mr-2"></i>
                            Reset
                        </a>
                    </div>
                </form>


                <!-- Table Produk -->
                <div class="overflow-x-auto rounded-lg border border-gray-200 shadow">
                    <table class="min-w-full divide-y divide-gray-200 bg-white text-sm dark:bg-gray-900 dark:text-gray-100">
                        <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            <tr>
                                <th class="px-4 py-3 text-center">
                                    <input type="checkbox" id="selectAll" class="form-checkbox text-blue-600" />
                                </th>
                                <th class="px-4 py-3">Nama</th>
                                <th class="px-4 py-3">Kode</th>
                                <th class="px-4 py-3">Gambar</th>
                                <th class="px-4 py-3">Kategori</th>
                                <th class="px-4 py-3">Harga</th>
                                <th class="px-4 py-3">Stok</th>

                                <th class="px-4 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y dark:bg-gray-900 dark:text-gray-100">
                            @forelse ($products as $product)
                                <tr class="dark:bg-gray-900 dark:text-gray-100">
                                    <td class="px-4 py-3 text-center">
                                        <input type="checkbox" class="form-checkbox select-item text-blue-600"
                                            value="{{ $product->id }}" name="ids[]" />
                                    </td>

                                    <td class="px-4 py-3">{{ $product->name }}</td>
                                    <td class="px-4 py-3">{{ $product->code }}</td>
                                    <td class="px-4 py-3">
                                        <img src="{{ $product->photo }}" alt="Gambar Produk"
                                            class="h-14 w-14 cursor-pointer rounded-md border object-cover transition-transform duration-200 hover:scale-105"
                                            onclick="zoomImage('{{ $product->photo }}')" />
                                    </td>
                                    <!-- Modal Zoom Gambar -->
                                    <div id="zoomModal"
                                        class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-70 backdrop-blur-sm">
                                        <span class="absolute right-6 top-4 cursor-pointer text-4xl font-bold text-white"
                                            onclick="closeZoomModal()">
                                            &times;
                                        </span>
                                        <img id="zoomedImage" src="" alt="Zoomed"
                                            class="max-h-full max-w-full rounded shadow-lg" />
                                    </div>

                                    <td class="px-4 py-3">{{ $product->category->name }}</td>
                                    <td class="px-4 py-3">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3">{{ $product->stock }} cup</td>
                                    <td class="relative whitespace-nowrap px-4 py-3">
                                        <div x-data="{ open: false }" class="relative inline-block text-left">
                                            <!-- Dropdown Toggle -->
                                            <button @click="open = !open" type="button"
                                                class="inline-flex items-center rounded bg-gray-100 px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1">
                                                <i class="fas fa-cogs mr-1"></i>
                                                Aksi
                                                <svg class="ml-1 h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M5.23 7.21a.75.75 0 011.06.02L10 11.585l3.71-4.355a.75.75 0 111.14.976l-4.25 5a.75.75 0 01-1.14 0l-4.25-5a.75.75 0 01.02-1.06z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>

                                            <!-- Dropdown Menu -->
                                            <div x-show="open" @click.away="open = false" x-transition
                                                class="class"="absolute bottom-full right-0 mb-2 w-52 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                                                <div class="py-1 text-sm text-gray-700">
                                                    <a href="{{ route('product.show', $product->id) }}"
                                                        class="flex items-center px-4 py-2 hover:bg-gray-100">
                                                        <i class="fas fa-eye mr-2 w-4 text-blue-500"></i>
                                                        Detail
                                                    </a>
                                                    <a href="{{ route('product.edit', $product->id) }}"
                                                        class="flex items-center px-4 py-2 hover:bg-gray-100">
                                                        <i class="fas fa-edit mr-2 w-4 text-yellow-500"></i>
                                                        Edit
                                                    </a>
                                                    <!-- Tombol trigger modal -->
                                                    <button type="button"
                                                        onclick="openDeleteModal('{{ route('product.destroy', $product->id) }}', '{{ $product->name }}')"
                                                        class="flex w-full items-center px-4 py-2 text-left text-red-600 hover:bg-gray-100">
                                                        <i class="fas fa-trash-alt mr-2 w-4"></i>
                                                        Hapus
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="py-6 text-center text-gray-500">
                                        Maaf, data tidak ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
                <div class="mt-4">
                    {{ $products->links('pagination::tailwind') }}
                </div>
                <!-- Modal Konfirmasi Hapus -->
                <div id="deleteModal"
                    class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
                    <div class="w-full max-w-md rounded-lg bg-white p-6 shadow-lg">
                        <h2 class="text-lg font-semibold text-gray-800">Konfirmasi Hapus</h2>
                        <p class="mt-2 text-sm text-gray-600">
                            Apakah kamu yakin ingin menghapus
                            <span id="itemName" class="font-semibold text-red-600"></span>
                            ?
                        </p>
                        <form id="deleteForm" method="POST" class="mt-6">
                            @csrf
                            @method('DELETE')
                            <div class="flex justify-end gap-3">
                                <button type="button" onclick="closeDeleteModal()"
                                    class="rounded bg-gray-200 px-4 py-2 text-sm hover:bg-gray-300">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="rounded bg-red-600 px-4 py-2 text-sm text-white hover:bg-red-700">
                                    Hapus
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div x-data="{ modalId: null }" x-init="window.addEventListener('open-modal', (e) => {
                    modalId = e.detail
                })">
                    @foreach ($products as $product)
                        <div x-show="modalId === {{ $product->id }}" x-cloak
                            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
                            <div class="mx-4 w-full max-w-2xl overflow-hidden rounded-xl bg-white shadow-xl"
                                @click.outside="modalId = null" @keydown.escape.window="modalId = null">
                                <!-- Modal Header -->
                                <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
                                    <h2 class="text-xl font-bold text-gray-800">
                                        Masukkin Produk - {{ $product->name }}
                                    </h2>

                                    <button @click="modalId = null"
                                        class="text-gray-500 transition duration-200 hover:text-red-600">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Modal Overlay -->
                <div id="addProductModal"
                    class="fixed inset-0 z-50 flex hidden items-center justify-center bg-black bg-opacity-40 backdrop-blur-sm">
                    <div class="relative max-h-[90vh] w-full max-w-4xl overflow-y-auto rounded-xl bg-white p-6 shadow-lg">
                        <!-- Header -->
                        <div class="mb-4 flex items-center justify-between border-b pb-3">
                            <h2 class="flex items-center gap-2 text-xl font-bold text-gray-800">
                                <i class="fas fa-plus-circle text-green-500"></i>
                                Tambah Produk
                            </h2>
                            <button onclick="closeModal()" class="text-2xl text-gray-500 hover:text-red-600">
                                &times;
                            </button>
                        </div>

                        <!-- Form -->
                        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data"
                            class="space-y-6">
                            @csrf
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                                <!-- Nama Produk -->
                                <div>
                                    <label class="mb-1 block text-sm font-medium text-gray-700">
                                        Nama Produk
                                    </label>
                                    <input type="text" name="name"
                                        class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200"
                                        placeholder="Contoh: Minyak Goreng" value="{{ old('name') }}" />
                                </div>

                                <!-- Kode Produk -->
                                <div>
                                    <label class="mb-1 block text-sm font-medium text-gray-700">
                                        Kode Produk
                                    </label>
                                    <input type="text" name="code" id="productCode"
                                        class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200"
                                        readonly />
                                </div>

                                <!-- Foto Produk -->
                                <div>
                                    <label class="mb-1 block text-sm font-medium text-gray-700">
                                        Foto Produk
                                    </label>
                                    <input type="file" name="photo"
                                        class="w-full rounded-lg border-gray-300 text-sm file:border-none file:bg-gray-100 file:px-3 file:py-2 file:text-gray-700" />
                                </div>

                                <!-- Kategori -->
                                <div>
                                    <label class="mb-1 block text-sm font-medium text-gray-700">
                                        Kategori
                                    </label>
                                    <select name="category_id"
                                        class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200"
                                        required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach ($datacategory as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Harga -->
                                <div>
                                    <label class="mb-1 block text-sm font-medium text-gray-700">
                                        Harga Produk
                                    </label>
                                    <input type="text" name="price_display" id="productPrice"
                                        class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200"
                                        placeholder="Contoh: 100.000" value="{{ old('price') }}"
                                        oninput="formatPriceDisplay(this)" required />
                                    <input type="hidden" name="price" id="priceHidden"
                                        value="{{ old('price') }}" />
                                </div>

                                <!-- Stok -->
                                <div>
                                    <label class="mb-1 block text-sm font-medium text-gray-700">
                                        Stok
                                    </label>
                                    <input type="number" name="stock"
                                        class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200"
                                        placeholder="Contoh: 100" value="{{ old('stock') }}" required />
                                </div>
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="flex justify-end gap-2 border-t pt-4">
                                <button type="submit"
                                    class="inline-flex items-center rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-green-700">
                                    <i class="fas fa-save mr-2"></i>
                                    Simpan
                                </button>
                                <button type="button" onclick="closeModal()"
                                    class="inline-flex items-center rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-800 shadow hover:bg-gray-300">
                                    <i class="fas fa-times mr-2"></i>
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        // =========================
        // Generate Kode Produk
        // =========================
        function generateKodeProduk() {
            const randomStr = Array(6)
                .fill(0)
                .map(() => {
                    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'
                    return chars.charAt(Math.floor(Math.random() * chars.length))
                })
                .join('')
            const year = new Date().getFullYear()
            return `KD-${randomStr}-${year}`
        }

        // =========================
        // Modal: Open & Close
        // =========================
        function openModal() {
            const modal = document.getElementById('addProductModal')
            modal.classList.remove('hidden')

            // Auto-generate kode produk baru setiap kali buka modal
            const kodeProdukInput = document.getElementById('productCode')
            if (kodeProdukInput) {
                kodeProdukInput.value = generateKodeProduk()
            }
        }

        function closeModal() {
            document.getElementById('addProductModal').classList.add('hidden')
        }

        // =========================
        // Format Harga Input
        // =========================
        function formatPriceDisplay(input) {
            let value = input.value.replace(/\D/g, '')
            input.value = new Intl.NumberFormat('id-ID').format(value)
            document.getElementById('priceHidden').value = value
        }

        // =========================
        // Bulk Delete Checkbox Logic
        // =========================
        document.addEventListener('DOMContentLoaded', function() {
            const selectAll = document.getElementById('selectAll')
            const checkboxes = document.querySelectorAll('.select-item')
            const deleteBtn = document.getElementById('deleteAllBtn')
            const deleteIdsInput = document.getElementById('bulkDeleteIds')

            if (selectAll && checkboxes.length > 0) {
                selectAll.addEventListener('change', function() {
                    checkboxes.forEach(cb => cb.checked = this.checked)
                    toggleDeleteButton()
                })

                checkboxes.forEach(cb => {
                    cb.addEventListener('change', () => {
                        selectAll.checked = [...checkboxes].every(cb => cb.checked)
                        toggleDeleteButton()
                    })
                })

                function toggleDeleteButton() {
                    const selectedIds = [...checkboxes]
                        .filter(cb => cb.checked)
                        .map(cb => cb.value)

                    deleteIdsInput.value = selectedIds.join(',')

                    if (selectedIds.length > 0) {
                        deleteBtn.classList.remove('hidden')
                        deleteBtn.disabled = false
                    } else {
                        deleteBtn.classList.add('hidden')
                        deleteBtn.disabled = true
                    }
                }
            }
        })


        // =========================
        // Optional: Modal via Event
        // =========================
        function openProductModal(id) {
            window.dispatchEvent(
                new CustomEvent('open-modal', {
                    detail: id,
                }),
            )
        }

        // ==== Gambar Zoom Modal ====
        function zoomImage(src) {
            const modal = document.getElementById('zoomModal')
            const zoomedImg = document.getElementById('zoomedImage')
            zoomedImg.src = src
            modal.classList.remove('hidden')
            modal.classList.add('flex')
        }

        function closeZoomModal() {
            const modal = document.getElementById('zoomModal')
            modal.classList.remove('flex')
            modal.classList.add('hidden')
        }

        window.addEventListener('click', function(e) {
            const modal = document.getElementById('zoomModal')
            const image = document.getElementById('zoomedImage')
            if (e.target === modal) {
                closeZoomModal()
            }
        })

        // =========================
        // Modal Konfirmasi Hapus
        // =========================
        function openDeleteModal(actionUrl, itemName) {
            const modal = document.getElementById('deleteModal')
            const form = document.getElementById('deleteForm')
            const name = document.getElementById('itemName')

            form.action = actionUrl
            name.textContent = itemName
            modal.classList.remove('hidden')
            modal.classList.add('flex')
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal')
            modal.classList.remove('flex')
            modal.classList.add('hidden')
        }
    </script>
@endpush
