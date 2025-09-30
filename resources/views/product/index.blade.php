@extends('layouts.master')

@section('title')
    <title>KASIRIN.ID - Produk</title>
@endsection

@section('content')
    <!-- Header Section -->
    <section class="mb-6 rounded-lg bg-white p-6 shadow-sm dark:bg-gray-800">
        <div
            class="mx-auto flex max-w-7xl flex-col items-start justify-between gap-4 sm:flex-row sm:items-center"
        >
            <!-- Title -->
            <div>
                <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">
                    Manajemen Produk
                </h1>
                <p class="mt-1 text-sm text-gray-500">
                    Kelola data produk dalam sistem inventory Anda
                </p>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="content bg-white">
        <div class="card bg-white shadow-sm">
            <div class="card-body bg-white p-6 dark:bg-gray-800 dark:text-gray-100">
                <!-- Bagian Tombol Aksi -->
                <div
                    class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between"
                >
                    <!-- Kiri: Tombol Aksi -->
                    <div class="flex flex-col gap-2 sm:flex-row">
                        <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                            <!-- Tombol Tambah Produk -->
                            <button
                                type="button"
                                onclick="openModal()"
                                class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700"
                            >
                                <i class="fas fa-plus-circle"></i>
                                Tambah Produk
                            </button>

                            <!-- Dropdown Show Per Page -->
                            @php
                                $perPage = request()->query('perPage', 5); // default 5
                            @endphp

                            <div class="flex items-center gap-2">
                                <select
                                    id="showPerPage"
                                    name="showPerPage"
                                    class="w-auto rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm transition-all duration-200 hover:border-gray-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:hover:border-gray-500 dark:focus:border-blue-400 dark:focus:ring-blue-400"
                                >
                                    <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>
                                        5
                                    </option>
                                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>
                                        10
                                    </option>
                                    <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>
                                        50
                                    </option>
                                    <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>
                                        100
                                    </option>
                                </select>
                            </div>
                        </div>

                        <form
                            id="bulkDeleteForm"
                            method="POST"
                            action="{{ route('product.bulkDelete') }}"
                            class="w-full sm:w-auto"
                        >
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="ids" id="bulkDeleteIds" />
                            <button
                                id="deleteAllBtn"
                                type="submit"
                                class="hidden inline-flex w-full items-center gap-2 rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 disabled:opacity-50 sm:w-auto"
                                disabled
                            >
                                <i class="fas fa-trash-alt"></i>
                                Hapus
                            </button>
                        </form>
                    </div>

                    <!-- Kanan: Dropdown Unduh Data -->
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                        <div x-data="{ open: false }" class="relative w-full sm:w-auto">
                            <!-- Trigger Button -->
                            <button
                                @click="open = !open"
                                class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-teal-600 px-4 py-2 text-sm font-semibold text-white shadow-md transition hover:bg-teal-700 focus:ring-2 focus:ring-teal-400 focus:outline-none sm:w-auto dark:bg-teal-500 dark:hover:bg-teal-600 dark:focus:ring-teal-300"
                            >
                                <i class="fas fa-download"></i>
                                Unduh Data
                                <svg
                                    class="ml-1 h-4 w-4 transition-transform duration-200"
                                    :class="{ 'rotate-180': open }"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.25 8.29a.75.75 0 01-.02-1.06z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </button>

                            <!-- Dropdown -->
                            <div
                                x-show="open"
                                @click.away="open = false"
                                x-transition
                                class="absolute right-0 mt-2 w-full overflow-hidden rounded-xl border border-gray-200 bg-white shadow-lg sm:w-52 dark:border-gray-700 dark:bg-gray-800"
                            >
                                <!-- Excel -->
                                <form action="{{ route('product.export') }}" method="POST">
                                    @csrf
                                    <button
                                        type="submit"
                                        name="export_type"
                                        value="excel"
                                        class="flex w-full items-center gap-2 px-4 py-2 text-sm text-gray-700 transition hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700"
                                    >
                                        <i class="fas fa-file-excel text-green-600"></i>
                                        <span>Export Excel</span>
                                    </button>
                                </form>

                                <!-- PDF -->
                                <form action="{{ route('product.export') }}" method="POST">
                                    @csrf
                                    <button
                                        type="submit"
                                        name="export_type"
                                        value="pdf"
                                        class="flex w-full items-center gap-2 px-4 py-2 text-sm text-gray-700 transition hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700"
                                    >
                                        <i class="fas fa-file-pdf text-red-500"></i>
                                        <span>Export PDF</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bagian Filter & Search -->
                <form
                    action="{{ route('product.index') }}"
                    method="GET"
                    class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:gap-6"
                >
                    <!-- Filter Kategori -->
                    <div class="w-full sm:w-auto">
                        <select
                            name="category"
                            id="filtername"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:w-72 dark:bg-gray-800 dark:text-gray-100"
                        >
                            <option value="">Pilih Kategori</option>
                            @forelse ($datacategory as $category)
                                <option
                                    value="{{ $category->name }}"
                                    {{ request('category') == $category->name ? 'selected' : '' }}
                                >
                                    {{ $category->name }}
                                </option>
                            @empty
                                <option value="" disabled>Tidak ada kategori tersedia</option>
                            @endforelse
                        </select>
                    </div>

                    <!-- Search Produk -->
                    <div class="w-full sm:w-auto">
                        <input
                            type="text"
                            name="search"
                            id="search"
                            placeholder="Nama produk..."
                            value="{{ request('search') }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:w-72 dark:bg-gray-800 dark:text-gray-100"
                        />
                    </div>

                    <!-- Tombol Filter & Reset -->
                    <div class="flex w-full gap-2 sm:mt-0 sm:w-auto">
                        <button
                            type="submit"
                            class="inline-flex flex-1 items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm text-white shadow-sm hover:bg-blue-700 sm:flex-none"
                        >
                            <i class="fas fa-search mr-2"></i>
                            Filter
                        </button>
                        <a
                            href="{{ route('product.index') }}"
                            class="inline-flex flex-1 items-center justify-center rounded-lg bg-gray-300 px-4 py-2 text-sm text-gray-800 shadow-sm hover:bg-gray-400 sm:flex-none"
                        >
                            <i class="fas fa-redo-alt mr-2"></i>
                            Reset
                        </a>
                    </div>
                </form>

                <!-- Table Produk -->
                <div class="overflow-x-auto rounded-lg shadow-md">
                    <table
                        class="min-w-full divide-y divide-gray-200 text-sm text-gray-700 dark:divide-gray-700 dark:text-gray-200"
                    >
                        <thead class="bg-gray-100 font-medium uppercase dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-center">
                                    <input
                                        type="checkbox"
                                        id="selectAll"
                                        class="form-checkbox rounded-lg text-blue-600"
                                    />
                                </th>
                                <th class="px-4 py-3 font-medium">Nama</th>
                                <th class="px-4 py-3 font-medium">Kode</th>
                                <th class="px-4 py-3 font-medium">Gambar</th>
                                <th class="px-4 py-3 font-medium">Kategori</th>
                                <th class="px-4 py-3 font-medium">Harga</th>
                                <th class="px-4 py-3 font-medium">Stok</th>
                                <th class="px-4 py-3 font-medium">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse ($products as $product)
                                <tr class="transition hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-4 py-3 text-center">
                                        <input
                                            type="checkbox"
                                            class="form-checkbox select-item rounded-lg text-blue-600"
                                            value="{{ $product->id }}"
                                            name="ids[]"
                                        />
                                    </td>

                                    <td class="px-4 py-3 text-center">{{ $product->name }}</td>
                                    <td class="px-4 py-3 text-center">{{ $product->code }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <img
                                            src="{{ $product->photo }}"
                                            alt="Gambar Produk"
                                            class="h-14 w-14 cursor-pointer rounded-md border object-cover transition-transform duration-200 hover:scale-105"
                                            onclick="zoomImage('{{ $product->photo }}')"
                                        />
                                    </td>
                                    <!-- Modal Zoom Gambar -->
                                    <div
                                        id="zoomModal"
                                        class="bg-opacity-70 fixed inset-0 z-50 hidden items-center justify-center bg-black backdrop-blur-sm"
                                    >
                                        <span
                                            class="absolute top-4 right-6 cursor-pointer text-4xl font-bold text-white"
                                            onclick="closeZoomModal()"
                                        >
                                            &times;
                                        </span>
                                        <img
                                            id="zoomedImage"
                                            src=""
                                            alt="Zoomed"
                                            class="max-h-full max-w-full rounded shadow-lg"
                                        />
                                    </div>

                                    <td class="px-4 py-3 text-center">
                                        {{ $product->category->name }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        {{ $product->stock . ' ' . ($product->satuan?->nama_satuan ?? '') }}
                                    </td>

                                    <td class="relative px-4 py-3 text-center whitespace-nowrap">
                                        <div
                                            x-data="{ open: false }"
                                            class="relative inline-block text-left"
                                        >
                                            <!-- Dropdown Toggle -->
                                            <button
                                                @click="open = !open"
                                                type="button"
                                                class="rounded-md p-2 transition hover:bg-gray-100 focus:outline-none dark:hover:bg-gray-700"
                                            >
                                                <svg
                                                    class="h-5 w-5 text-gray-600 dark:text-gray-300"
                                                    fill="currentColor"
                                                    viewBox="0 0 20 20"
                                                >
                                                    <path
                                                        d="M10 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zm0 5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zm0 5a1.5 1.5 0 110 3 1.5 1.5 0 010-3z"
                                                    />
                                                </svg>
                                            </button>

                                            <!-- Dropdown Menu -->
                                            <div
                                                x-show="open"
                                                @click.away="open = false"
                                                x-transition
                                                class="class"
                                                ="absolute bottom-full right-0 mb-2 w-52 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
                                            >
                                                <div
                                                    class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                                >
                                                    <a
                                                        href="{{ route('product.show', $product->id) }}"
                                                        class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700"
                                                    >
                                                        <i
                                                            class="fas fa-eye mr-2 w-4 text-blue-500"
                                                        ></i>
                                                        Detail
                                                    </a>
                                                    <a
                                                        href="{{ route('product.edit', $product->id) }}"
                                                        class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700"
                                                    >
                                                        <i
                                                            class="fas fa-edit mr-2 w-4 text-yellow-500"
                                                        ></i>
                                                        Edit
                                                    </a>

                                                    <!-- Tombol trigger modal -->
                                                    <button
                                                        type="button"
                                                        onclick="openDeleteModal('{{ route('product.destroy', $product->id) }}', '{{ $product->name }}')"
                                                        class="flex w-full items-center px-4 py-2 text-left text-red-600 hover:bg-gray-100 dark:text-red-400 dark:hover:bg-gray-700"
                                                    >
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
                    <div class="pagination-wrapper">
                        {{ $products->appends(request()->query())->links('pagination::tailwind') }}
                    </div>
                </div>

                <!-- Modal Konfirmasi Hapus -->
                <div
                    id="deleteModal"
                    class="bg-opacity-50 fixed inset-0 z-50 hidden items-center justify-center bg-black"
                >
                    <div
                        class="w-full max-w-md transform rounded-xl bg-white p-6 shadow-lg transition-all duration-300 dark:bg-gray-800"
                    >
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            Konfirmasi Hapus
                        </h2>
                        <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">
                            Apakah kamu yakin ingin menghapus
                            <span
                                id="itemName"
                                class="font-semibold text-red-600 dark:text-red-400"
                            ></span>
                            ?
                        </p>

                        <form id="deleteForm" method="POST" class="mt-6">
                            @csrf
                            @method('DELETE')
                            <div class="flex justify-end gap-3">
                                <button
                                    type="button"
                                    onclick="closeDeleteModal()"
                                    class="rounded-lg bg-gray-200 px-4 py-2 text-gray-800 transition hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600"
                                >
                                    Batal
                                </button>
                                <button
                                    type="submit"
                                    class="rounded-lg bg-red-600 px-4 py-2 text-white transition hover:bg-red-700"
                                >
                                    Hapus
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modal Overlay -->
                <div
                    id="addProductModal"
                    class="fixed inset-0 z-50 flex hidden items-center justify-center bg-black/40 backdrop-blur-sm"
                >
                    <div
                        class="relative max-h-[90vh] w-full max-w-4xl overflow-y-auto rounded-xl bg-white p-6 shadow-lg dark:bg-gray-900"
                    >
                        <!-- Header -->
                        <div
                            class="mb-4 flex items-center justify-between border-b border-gray-200 pb-3 dark:border-gray-700"
                        >
                            <h2
                                class="flex items-center gap-2 text-xl font-bold text-gray-800 dark:text-gray-100"
                            >
                                <i class="fas fa-plus-circle text-green-500"></i>
                                Tambah Produk
                            </h2>
                            <button
                                onclick="closeModal()"
                                class="text-2xl text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-500"
                            >
                                &times;
                            </button>
                        </div>

                        <!-- Form -->
                        <form
                            action="{{ route('product.store') }}"
                            method="POST"
                            enctype="multipart/form-data"
                            class="space-y-6"
                        >
                            @csrf
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                                <!-- Nama Produk -->
                                <div>
                                    <label
                                        class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300"
                                    >
                                        Nama Produk
                                    </label>
                                    <input
                                        type="text"
                                        name="name"
                                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-gray-800 placeholder-gray-400 focus:border-blue-500 focus:ring focus:ring-blue-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:placeholder-gray-500"
                                        placeholder="Contoh: Minyak Goreng"
                                        value="{{ old('name') }}"
                                    />
                                </div>

                                <!-- Kode Produk -->
                                <div>
                                    <label
                                        class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300"
                                    >
                                        Kode Produk
                                    </label>
                                    <input
                                        type="text"
                                        name="code"
                                        id="productCode"
                                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-gray-800 focus:border-blue-500 focus:ring focus:ring-blue-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                                        readonly
                                    />
                                </div>

                                <!-- Foto Produk -->
                                <div>
                                    <label
                                        class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300"
                                    >
                                        Foto Produk
                                    </label>
                                    <input
                                        type="file"
                                        name="photo"
                                        class="w-full rounded-lg border-gray-300 text-sm text-gray-700 file:border-none file:bg-gray-100 file:px-3 file:py-2 file:text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 file:dark:bg-gray-700 file:dark:text-gray-200"
                                    />
                                </div>

                                <!-- Kategori -->
                                <div>
                                    <label
                                        class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300"
                                    >
                                        Kategori
                                    </label>
                                    <select
                                        name="category_id"
                                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-gray-800 focus:border-blue-500 focus:ring focus:ring-blue-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                                        required
                                    >
                                        <option value="">Pilih Kategori</option>
                                        @foreach ($datacategory as $category)
                                            <option
                                                value="{{ $category->id }}"
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}
                                            >
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Harga -->
                                <div>
                                    <label
                                        class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300"
                                    >
                                        Harga Produk
                                    </label>
                                    <input
                                        type="text"
                                        name="price_display"
                                        id="productPrice"
                                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-gray-800 placeholder-gray-400 focus:border-blue-500 focus:ring focus:ring-blue-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:placeholder-gray-500"
                                        placeholder="Contoh: 100.000"
                                        value="{{ old('price') }}"
                                        oninput="formatPriceDisplay(this)"
                                        required
                                    />
                                    <input
                                        type="hidden"
                                        name="price"
                                        id="priceHidden"
                                        value="{{ old('price') }}"
                                    />
                                </div>

                                <!-- Stok -->
                                <div>
                                    <label
                                        class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300"
                                    >
                                        Stok
                                    </label>
                                    <input
                                        type="number"
                                        name="stock"
                                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-gray-800 placeholder-gray-400 focus:border-blue-500 focus:ring focus:ring-blue-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:placeholder-gray-500"
                                        placeholder="Contoh: 100"
                                        value="{{ old('stock') }}"
                                        required
                                    />
                                </div>

                                <!-- Satuan -->
                                <div>
                                    <label
                                        class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300"
                                    >
                                        Satuan
                                    </label>
                                    <select
                                        name="satuan_id"
                                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-gray-800 focus:border-blue-500 focus:ring focus:ring-blue-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                                        required
                                    >
                                        <option value="">Pilih Satuan</option>
                                        @foreach ($satuans as $satuan)
                                            <option
                                                value="{{ $satuan->id }}"
                                                {{ old('satuan_id') == $satuan->id ? 'selected' : '' }}
                                            >
                                                {{ $satuan->nama_satuan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Tombol Aksi -->
                            <div
                                class="flex justify-end gap-2 border-t border-gray-200 pt-4 dark:border-gray-700"
                            >
                                <button
                                    type="submit"
                                    class="inline-flex items-center rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-green-700"
                                >
                                    <i class="fas fa-save mr-2"></i>
                                    Simpan
                                </button>
                                <button
                                    type="button"
                                    onclick="closeModal()"
                                    class="inline-flex items-center rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-800 shadow hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600"
                                >
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
        document.addEventListener('DOMContentLoaded', function () {
            const selectAll = document.getElementById('selectAll')
            const checkboxes = document.querySelectorAll('.select-item')
            const deleteBtn = document.getElementById('deleteAllBtn')
            const deleteIdsInput = document.getElementById('bulkDeleteIds')

            if (selectAll && checkboxes.length > 0) {
                selectAll.addEventListener('change', function () {
                    checkboxes.forEach((cb) => (cb.checked = this.checked))
                    toggleDeleteButton()
                })

                checkboxes.forEach((cb) => {
                    cb.addEventListener('change', () => {
                        selectAll.checked = [...checkboxes].every((cb) => cb.checked)
                        toggleDeleteButton()
                    })
                })

                function toggleDeleteButton() {
                    const selectedIds = [...checkboxes]
                        .filter((cb) => cb.checked)
                        .map((cb) => cb.value)

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

        window.addEventListener('click', function (e) {
            const modal = document.getElementById('zoomModal')
            const image = document.getElementById('zoomedImage')
            if (e.target === modal) {
                closeZoomModal()
            }
        })

        function openDeleteModal(actionUrl, itemName) {
            const modal = document.getElementById('deleteModal')
            const form = document.getElementById('deleteForm')
            const name = document.getElementById('itemName')

            // Cek kalau form ini bukan form delete foto
            if (!form.classList.contains('delete-photo-form')) {
                form.action = actionUrl
                name.textContent = itemName
                modal.classList.remove('hidden')
                modal.classList.add('flex')
            }
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal')
            modal.classList.remove('flex')
            modal.classList.add('hidden')
        }

        document.getElementById('showPerPage').addEventListener('change', function () {
            const perPage = this.value
            const url = new URL(window.location.href)
            url.searchParams.set('perPage', perPage)
            window.location.href = url.toString()
        })
    </script>
@endpush
