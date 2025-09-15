@extends('layouts.master')

@section('title')
    <title>KASIRIN.ID - Produk Masuk</title>
@endsection

@section('content')
    <!-- Header -->
    <section class="mb-6 rounded-lg bg-white p-6 shadow-sm dark:bg-gray-900 dark:shadow-md">
        <div class="mx-auto flex max-w-7xl flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Data Produk Masuk</h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Lihat dan kelola data produk yang masuk ke dalam inventori
                </p>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <!-- Header Action -->
                    <div class="mb-6 grid grid-cols-1 gap-3 sm:grid-cols-2 sm:items-center">
                        <!-- KIRI: Tombol Aksi dan Filter -->
                        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:gap-3">
                            <!-- Tombol Minta Produk -->
                            <a href="{{ route('productin.create') }}"
                                class="inline-flex items-center justify-center rounded bg-green-600 px-4 py-2 text-sm text-white shadow-sm hover:bg-green-700 whitespace-nowrap">
                                <i class="fas fa-plus-circle mr-2"></i>
                                Minta Produk
                            </a>

                            <!-- Tombol Bulk Delete -->
                            <form method="POST" action="{{ route('productin.bulkDelete') }}"
                                onsubmit="return confirm('Yakin ingin menghapus produk terpilih?')" class="inline-flex">
                                @csrf
                                <input type="hidden" name="ids" id="bulkDeleteIds" />
                                <button id="deleteAllBtn" type="submit"
                                    class="inline-flex hidden items-center gap-2 rounded bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 disabled:opacity-50 whitespace-nowrap"
                                    disabled>
                                    <i class="fas fa-trash-alt"></i>
                                    Pilih Menghapus
                                </button>
                            </form>

                            <!-- Filter Data -->
                            <div class="relative">
                                <button onclick="toggleFilterDropdown()" type="button"
                                    class="inline-flex items-center rounded border border-blue-600 px-4 py-2 text-sm text-blue-600 shadow-sm hover:bg-blue-50 dark:border-blue-400 dark:text-blue-400 dark:hover:bg-gray-800 whitespace-nowrap">
                                    <i class="fas fa-filter mr-2"></i>
                                    Filter Data
                                </button>

                                <!-- Dropdown Box Filter -->
                                <div id="filterDropdown"
                                    class="absolute right-0 z-50 mt-2 hidden w-full max-w-xs rounded-lg border border-gray-200 bg-white p-4 shadow-lg dark:border-gray-700 dark:bg-gray-800 sm:w-80">
                                    <!-- Form Filter -->
                                    <form action="{{ route('productin.index') }}" method="GET" class="space-y-4">
                                        <!-- Kategori -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                Kategori
                                            </label>
                                            <select name="category"
                                                class="w-full rounded border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-blue-400 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-200">
                                                <option value="">-- Semua Kategori --</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ request('category') == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Status Produk -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                Status Produk
                                            </label>
                                            <select name="status_produk"
                                                class="w-full rounded border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-blue-400 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-200">
                                                <option value="">-- Semua --</option>
                                                <option value="menunggu"
                                                    {{ request('status_produk') == 'menunggu' ? 'selected' : '' }}>Menunggu
                                                </option>
                                                <option value="disetujui"
                                                    {{ request('status_produk') == 'disetujui' ? 'selected' : '' }}>
                                                    Disetujui</option>
                                                <option value="ditolak"
                                                    {{ request('status_produk') == 'ditolak' ? 'selected' : '' }}>Ditolak
                                                </option>
                                            </select>
                                        </div>

                                        <!-- Status Penjualan -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                Status Penjualan
                                            </label>
                                            <select name="status_penjualan"
                                                class="w-full rounded border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-blue-400 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-200">
                                                <option value="">-- Semua --</option>
                                                <option value="belum dijual"
                                                    {{ request('status_penjualan') == 'belum dijual' ? 'selected' : '' }}>
                                                    Belum Dijual</option>
                                                <option value="sedang dijual"
                                                    {{ request('status_penjualan') == 'sedang dijual' ? 'selected' : '' }}>
                                                    Sedang Dijual</option>
                                                <option value="stok tinggal dikit"
                                                    {{ request('status_penjualan') == 'stok tinggal dikit' ? 'selected' : '' }}>
                                                    Stok Tinggal Dikit</option>
                                                <option value="stok habis terjual"
                                                    {{ request('status_penjualan') == 'stok habis terjual' ? 'selected' : '' }}>
                                                    Stok Habis Terjual</option>
                                            </select>
                                        </div>

                                        <!-- Filter Harga -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                Harga (Min - Max)
                                            </label>
                                            <div class="flex gap-2">
                                                <input type="number" name="min_price" value="{{ request('min_price') }}"
                                                    placeholder="Min"
                                                    class="w-1/2 rounded border px-3 py-2 text-sm focus:outline-none focus:ring-blue-400 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-200" />
                                                <input type="number" name="max_price" value="{{ request('max_price') }}"
                                                    placeholder="Max"
                                                    class="w-1/2 rounded border px-3 py-2 text-sm focus:outline-none focus:ring-blue-400 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-200" />
                                            </div>
                                        </div>

                                        <!-- Filter Qty -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                Qty (Min - Max)
                                            </label>
                                            <div class="flex gap-2">
                                                <input type="number" name="min_qty" value="{{ request('min_qty') }}"
                                                    placeholder="Min"
                                                    class="w-1/2 rounded border px-3 py-2 text-sm focus:outline-none focus:ring-blue-400 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-200" />
                                                <input type="number" name="max_qty" value="{{ request('max_qty') }}"
                                                    placeholder="Max"
                                                    class="w-1/2 rounded border px-3 py-2 text-sm focus:outline-none focus:ring-blue-400 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-200" />
                                            </div>
                                        </div>

                                        <!-- Tombol Aksi Filter -->
                                        <div class="flex justify-between pt-2">
                                            <a href="{{ route('productin.index') }}"
                                                class="inline-flex items-center rounded-md bg-gray-300 px-4 py-2 text-sm text-gray-800 shadow-sm hover:bg-gray-400 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                                                <i class="fas fa-undo mr-1"></i>
                                                Reset Filter
                                            </a>
                                            <button type="submit"
                                                class="rounded bg-blue-600 px-4 py-2 text-sm text-white hover:bg-blue-700">
                                                <i class="fas fa-search mr-1"></i>
                                                Terapkan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- KANAN: Form Pencarian -->
                        <div class="flex justify-end">
                            <form method="GET" action="{{ route('productin.index') }}"
                                class="flex w-full flex-col items-end gap-2 sm:w-auto sm:flex-row sm:items-center">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Cari nama produk..."
                                    class="w-full rounded border px-3 py-2 text-sm shadow focus:border-blue-300 focus:outline-none focus:ring dark:border-gray-600 dark:bg-gray-900 dark:text-gray-200 sm:w-56" />
                                <div class="flex w-full gap-2 sm:w-auto">
                                    <button type="submit"
                                        class="flex w-full items-center justify-center gap-1 rounded bg-blue-600 px-3 py-2 text-sm text-white hover:bg-blue-700 sm:w-auto">
                                        <i class="fas fa-search"></i>
                                        Cari
                                    </button>
                                    <a href="{{ route('productin.index') }}"
                                        class="inline-flex w-full items-center justify-center rounded-md bg-gray-300 px-4 py-2 text-sm text-gray-800 shadow-sm hover:bg-gray-400 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 sm:w-auto">
                                        <i class="fas fa-redo-alt mr-2"></i>
                                        Reset
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto rounded-lg border border-gray-200 shadow dark:border-gray-700">
                        <table
                            class="min-w-full divide-y divide-gray-200 bg-white text-sm text-gray-700 dark:divide-gray-700 dark:bg-gray-900 dark:text-gray-300">
                            <thead
                                class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:bg-gray-800 dark:text-gray-400">
                                <tr>
                                    <th class="px-4 py-3 text-center">
                                        <input type="checkbox" id="selectAll"
                                            class="form-checkbox text-blue-600 dark:text-blue-400" />
                                    </th>
                                    <th class="px-4 py-3">Nama Produk</th>
                                    <th class="px-4 py-3">Kode Produk</th>
                                    <th class="px-4 py-3">Tanggal Masuk</th>
                                    <th class="px-4 py-3">Gambar Produk</th>
                                    <th class="px-4 py-3">Kategori Produk</th>
                                    <th class="px-4 py-3">Harga</th>
                                    <th class="px-4 py-3">Qty</th>
                                    <th class="px-4 py-3">PPIC</th>
                                    <th class="px-4 py-3">Status</th>
                                    <th class="px-4 py-3">Status Penjualan</th>
                                    <th class="px-4 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                @forelse ($productIns as $productIn)
                                    <tr x-data="{ visible: true }" x-show="visible" id="productin-{{ $productIn->id }}">
                                        <td class="px-4 py-3 text-center">
                                            <input type="checkbox" class="form-checkbox select-item text-blue-600"
                                                value="{{ $productIn->id }}" name="ids[]" />
                                        </td>
                                        <td class="px-4 py-2">
                                            {{ optional($productIn->product)->name ?? 'Produk Dihapus' }}
                                        </td>
                                        <td class="px-4 py-2">
                                            {{ optional($productIn->product)->code ?? '-' }}
                                        </td>
                                        <td class="px-4 py-2">{{ $productIn->date }}</td>
                                        <td class="px-4 py-2">
                                            @if (optional($productIn->product)->photo)
                                                <img src="{{ $productIn->product->photo }}" alt="Image"
                                                    class="h-12 w-12 rounded object-cover" />
                                            @else
                                                <span class="italic text-gray-400">No Image</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-2">
                                            {{ optional(optional($productIn->product)->category)->name ?? '-' }}
                                        </td>
                                        <td class="px-4 py-2">
                                            Rp
                                            {{ number_format(optional($productIn->product)->price ?? 0, 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-2">{{ $productIn->qty }}</td>
                                        <td class="px-4 py-2">
                                            {{ $productIn->status === 'ditolak' ? 'Sistem' : $productIn->recipient }}
                                        </td>

                                        <td class="whitespace-nowrap px-4 py-2">
                                            @php
                                                $status = $productIn->status ?? 'menunggu';
                                                $statusClass =
                                                    [
                                                        'menunggu' => 'bg-yellow-100 text-yellow-800',
                                                        'disetujui' => 'bg-green-100 text-green-800',
                                                        'ditolak' => 'bg-red-100 text-red-800',
                                                    ][$status] ?? 'bg-gray-100 text-gray-800';
                                            @endphp

                                            <span
                                                class="{{ $statusClass }} inline-flex rounded-full px-3 py-1 text-xs font-medium">
                                                {{ ucfirst($status) }}
                                            </span>
                                        </td>


                                        <td class="whitespace-nowrap px-4 py-2">
                                            @php
                                                $statusPenjualan = $productIn->status_penjualan;
                                                $stokToko = $productIn->sales->sum('qty');
                                            @endphp

                                            <div>
                                                @if ($statusPenjualan === 'sedang dijual')
                                                    <span
                                                        class="inline-flex rounded-full bg-blue-100 px-2 py-1 text-xs text-blue-700">
                                                        Sedang Dijual
                                                    </span>
                                                @elseif ($statusPenjualan === 'stok habis terjual')
                                                    <span
                                                        class="inline-flex rounded-full bg-red-100 px-2 py-1 text-xs text-red-700">
                                                        Stok Habis
                                                    </span>
                                                @elseif ($statusPenjualan === 'stok tinggal dikit')
                                                    <span
                                                        class="inline-flex rounded-full bg-yellow-100 px-2 py-1 text-xs text-yellow-700">
                                                        Stok Tinggal Dikit
                                                    </span>
                                                @elseif ($statusPenjualan === 'belum dijual')
                                                    <span
                                                        class="inline-flex rounded-full bg-gray-100 px-2 py-1 text-xs text-gray-700">
                                                        Belum Dijual
                                                    </span>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif

                                                @if ($statusPenjualan !== 'belum dijual')
                                                    <div class="mt-1 text-xs text-gray-500">
                                                        <i class="fas fa-box me-1"></i>
                                                        Sisa Stok: <span>
                                                            {{ $stokToko }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
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
                                                    <div class="py-1 text-sm text-gray-700 dark:text-gray-200">
                                                        @if ($productIn->status === 'disetujui' || session('status') === 'produk disetujui')
                                                            @if ($productIn->sales->isEmpty())
                                                                <button type="button"
                                                                    class="flex w-full items-center px-4 py-2 text-blue-600 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                                                                    @click="$dispatch('open-sale-modal', { productId: {{ $productIn->id }}, productName: '{{ optional($productIn->product)->name ?? 'Produk Dihapus' }}' })">
                                                                    🏪
                                                                    <span class="ml-2">Jual di Toko</span>
                                                                </button>
                                                            @else
                                                                <button type="button"
                                                                    class="btn-add-stock flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                                                                    @click="$dispatch('open-add-stock-modal', { id: {{ $productIn->id }}, name: '{{ optional($productIn->product)->name ?? 'Produk Dihapus' }}' })">
                                                                    <span class="ml-2">+ Stok ke Gudang</span>
                                                                </button>

                                                                @php
                                                                    $totalQtySales = $productIn->sales->sum('qty');
                                                                @endphp

                                                                <button type="button"
                                                                    class="btn-add-stock flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                                                                    @click="$dispatch('open-stock-toko-modal', {
                    id: {{ $productIn->id }},
                    name: '{{ optional($productIn->product)->name ?? 'Produk Dihapus' }}',
                    max: {{ $productIn->qty }},
                    stokToko: {{ $totalQtySales }}
                })">
                                                                    <span class="ml-2">+ Stok ke Toko</span>
                                                                </button>
                                                            @endif
                                                        @endif
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
                </div>
            </div>
        </div>

        {{-- === SALE MODAL === --}}
        <div x-data="saleModal()" x-init="init()" x-show="open" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-70">
            <div class="bg-gray-800 text-gray-200 rounded-2xl shadow-xl w-full max-w-md p-6">
                <!-- Header -->
                <div class="flex justify-between items-center border-b border-gray-700 pb-3 mb-4">
                    <h2 class="text-lg font-semibold">🏪 Jual di Toko</h2>
                    <button @click="closeModal()" class="text-gray-400 hover:text-white text-xl">&times;</button>
                </div>
                <!-- Body -->
                <form @submit.prevent="submitForm" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium">Produk</label>
                        <input type="text" x-model="productName" readonly
                            class="w-full mt-1 px-3 py-2 bg-gray-700 border border-gray-600 rounded-md" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Jumlah</label>
                        <input type="number" x-model="qty" min="1"
                            class="w-full mt-1 px-3 py-2 bg-gray-700 border border-gray-600 rounded-md" />
                    </div>
                    <!-- Footer -->
                    <div class="flex justify-end space-x-2 pt-3">
                        <button type="button" @click="closeModal()"
                            class="px-4 py-2 rounded-md bg-gray-600 hover:bg-gray-500">Batal</button>
                        <button type="submit" class="px-4 py-2 rounded-md bg-blue-600 hover:bg-blue-700">Simpan</button>
                    </div>
                </form>
            </div>
        </div>


        {{-- === ADD STOCK MODAL === --}}
        <div x-data="addStockModal()" x-init="init()" x-show="open" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-70">
            <div class="bg-gray-800 text-gray-200 rounded-2xl shadow-xl w-full max-w-md p-6">
                <!-- Header -->
                <div class="flex justify-between items-center border-b border-gray-700 pb-3 mb-4">
                    <h2 class="text-lg font-semibold">📦 Tambah Stok ke Gudang</h2>
                    <button @click="closeModal()" class="text-gray-400 hover:text-white text-xl">&times;</button>
                </div>
                <!-- Body -->
                <form @submit.prevent="submitForm" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium">Produk</label>
                        <input type="text" x-model="productName" readonly
                            class="w-full mt-1 px-3 py-2 bg-gray-700 border border-gray-600 rounded-md" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Jumlah</label>
                        <input type="number" x-model="qty" min="1"
                            class="w-full mt-1 px-3 py-2 bg-gray-700 border border-gray-600 rounded-md" />
                    </div>
                    <!-- Footer -->
                    <div class="flex justify-end space-x-2 pt-3">
                        <button type="button" @click="closeModal()"
                            class="px-4 py-2 rounded-md bg-gray-600 hover:bg-gray-500">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 rounded-md bg-green-600 hover:bg-green-700">Simpan</button>
                    </div>
                </form>
            </div>
        </div>


        {{-- === STOCK TOKO MODAL === --}}
        <div x-data="stokTokoModal()" x-init="init()" x-show="show" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-70">
            <div class="bg-gray-800 text-gray-200 rounded-2xl shadow-xl w-full max-w-md p-6">
                <!-- Header -->
                <div class="flex justify-between items-center border-b border-gray-700 pb-3 mb-4">
                    <h2 class="text-lg font-semibold" x-text="modalTitle">🛒 Tambah Stok ke Toko</h2>
                    <button @click="closeModal()" class="text-gray-400 hover:text-white text-xl">&times;</button>
                </div>
                <!-- Body -->
                <form @submit.prevent="submitForm" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium">Produk</label>
                        <input type="text" x-model="productName" readonly
                            class="w-full mt-1 px-3 py-2 bg-gray-700 border border-gray-600 rounded-md" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Jumlah</label>
                        <input type="number" x-model="qty" min="1" :max="maxStok"
                            class="w-full mt-1 px-3 py-2 bg-gray-700 border border-gray-600 rounded-md" />
                        <p class="text-xs text-gray-400 mt-1">
                            Stok Gudang: <span x-text="maxStok"></span> | Stok Toko: <span x-text="stokToko"></span>
                        </p>
                    </div>
                    <!-- Footer -->
                    <div class="flex justify-end space-x-2 pt-3">
                        <button type="button" @click="closeModal()"
                            class="px-4 py-2 rounded-md bg-gray-600 hover:bg-gray-500">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 rounded-md bg-yellow-600 hover:bg-yellow-700">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection


@push('scripts')
    <script>
        function toggleFilterDropdown() {
            const dropdown = document.getElementById('filterDropdown')
            dropdown.classList.toggle('hidden')
        }

        window.addEventListener('click', function(event) {
            const dropdown = document.getElementById('filterDropdown')
            const button = document.querySelector('[onclick="toggleFilterDropdown()"]')

            if (
                !dropdown.contains(event.target) &&
                !button.contains(event.target) &&
                !dropdown.classList.contains('hidden')
            ) {
                dropdown.classList.add('hidden')
            }
        })

        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search)
            const filterParams = [
                'category',
                'status_produk',
                'status_penjualan',
                'min_price',
                'max_price',
                'min_qty',
                'max_qty',
            ]
            let hasActiveFilter = false

            for (const param of filterParams) {
                if (urlParams.has(param) && urlParams.get(param) !== '') {
                    if (
                        (param.includes('price') || param.includes('qty')) &&
                        urlParams.get(param) === ''
                    ) {
                        continue
                    }
                    if (
                        urlParams.get(param) !== '-- Semua Kategori --' &&
                        urlParams.get(param) !== '-- Semua --'
                    ) {
                        hasActiveFilter = true
                        break
                    }
                }
            }

            if (hasActiveFilter) {
                const dropdown = document.getElementById('filterDropdown')
                dropdown.classList.remove('hidden')
            }
        })

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


        function saleModal() {
            return {
                open: false,
                productId: null,
                productName: '',
                qty: 1,
                init() {
                    window.addEventListener('open-sale-modal', e => this.openModal(e.detail));
                },
                openModal({
                    productId,
                    productName
                }) {
                    this.open = true;
                    this.productId = productId;
                    this.productName = productName;
                    this.qty = 1;
                },
                closeModal() {
                    this.open = false;
                },
                notify(msg, type = 'info') {
                    window.dispatchEvent(new CustomEvent('notify', {
                        detail: {
                            message: msg,
                            type
                        }
                    }));
                },
                async submitForm() {
                    if (this.qty < 1) return this.notify('Jumlah minimal 1', 'warning');
                    try {
                        const res = await fetch(`/productin/sale/${this.productId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                qty: this.qty
                            })
                        });
                        const data = await res.json();
                        if (!res.ok || !data.success) return this.notify(data.message || 'Gagal jual produk', 'error');
                        this.notify(data.message, 'success');
                        setTimeout(() => {
                            this.closeModal();
                            window.location.reload();
                        }, 800);
                    } catch (e) {
                        this.notify('Gagal terhubung ke server', 'error');
                    }
                }
            }
        }

        function addStockModal() {
            return {
                open: false,
                productInId: null,
                productName: '',
                qty: 1,
                init() {
                    window.addEventListener('open-add-stock-modal', e => this.openModal(e.detail));
                },
                openModal({
                    id,
                    name
                }) {
                    this.open = true;
                    this.productInId = id;
                    this.productName = name;
                    this.qty = 1;
                },
                closeModal() {
                    this.open = false;
                },
                notify(msg, type = 'info') {
                    window.dispatchEvent(new CustomEvent('notify', {
                        detail: {
                            message: msg,
                            type
                        }
                    }));
                },
                async submitForm() {
                    if (this.qty < 1) return this.notify('Jumlah minimal 1', 'warning');
                    try {
                        const res = await fetch(`/productin/add-stock/${this.productInId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                tambah_qty: this.qty
                            })
                        });
                        const data = await res.json();
                        if (!res.ok || !data.success) return this.notify(data.message || 'Gagal tambah stok', 'error');
                        this.notify(data.message, 'success');
                        setTimeout(() => {
                            this.closeModal();
                            window.location.reload();
                        }, 800);
                    } catch (e) {
                        this.notify('Gagal terhubung ke server', 'error');
                    }
                }
            }
        }

        function stokTokoModal() {
            return {
                show: false,
                productInId: null,
                productName: '',
                maxStok: 0,
                stokToko: 0,
                qty: 1,
                modalTitle: '',
                init() {
                    window.addEventListener('open-stock-toko-modal', e => {
                        const {
                            id,
                            name,
                            max,
                            stokToko
                        } = e.detail;
                        this.openModal(id, name, max, stokToko);
                    });
                },
                openModal(id, name, max, stokToko) {
                    this.productInId = id;
                    this.productName = name;
                    this.maxStok = max;
                    this.stokToko = stokToko ?? 0;
                    this.qty = 1;
                    this.modalTitle = `Tambah Stok ke Toko: ${name}`;
                    this.show = true;
                },
                closeModal() {
                    this.show = false;
                },
                notify(msg, type = 'info') {
                    window.dispatchEvent(new CustomEvent('notify', {
                        detail: {
                            message: msg,
                            type
                        }
                    }));
                },
                async submitForm() {
                    if (this.qty < 1) return this.notify('Jumlah minimal 1', 'warning');
                    if (this.qty > this.maxStok) return this.notify(
                        `Jumlah melebihi stok gudang. Maksimum ${this.maxStok}`, 'warning'
                    );

                    try {
                        const res = await fetch(`/productin/add-stock-toko/${this.productInId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                qty: this.qty
                            })
                        });

                        const data = await res.json();

                        if (!res.ok || !data.success) {
                            return this.notify(data.message || 'Gagal tambah stok ke toko', 'error');
                        }

                        this.notify(data.message, 'success');
                        this.closeModal();

                        // 🔥 Update stok di state modal
                        this.stokToko += this.qty;
                        this.maxStok -= this.qty;

                        // 🔥 Update tampilan stok langsung di DOM (realtime)
                        const el = document.querySelector(`#stok-toko-${this.productInId}`);
                        if (el) {
                            el.textContent = this.stokToko;
                        }

                        // 🔄 Auto reload setelah 1.5 detik (opsional)
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);

                    } catch (e) {
                        console.error(e);
                        this.notify('Gagal terhubung ke server', 'error');
                    }
                }
            }
        }
    </script>
@endpush
