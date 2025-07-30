@extends('layouts.master')

@section('title')
    <title>Sistem Inventory Iyan | Produk Masuk</title>
@endsection

@section('content')
    <!-- Header -->
    <section class="mb-6 rounded-lg bg-white p-6 shadow-sm">
        <div class="mx-auto flex max-w-7xl flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Data Produk Masuk</h1>
                <p class="mt-1 text-sm text-gray-500">
                    Lihat dan kelola data produk yang masuk ke dalam inventori
                </p>
            </div>

            <!-- Breadcrumb -->
            <nav
                class="text-sm text-gray-600"
                aria-label="Breadcrumb"
            >
                <ol class="flex items-center space-x-2">
                    <li>
                        <a
                            href="{{ route('dashboard') }}"
                            class="flex items-center text-gray-500 hover:text-blue-600"
                        >
                            <i class="fa fa-dashboard mr-1"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <svg
                            class="mx-1 h-4 w-4 text-gray-400"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path d="M6 9a1 1 0 000 2h8a1 1 0 000-2H6z" />
                        </svg>
                    </li>
                    <li class="text-gray-400">Produk Masuk</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <!-- Header Action -->
                    <div class="mb-6 grid grid-cols-1 gap-3 sm:grid-cols-2 sm:items-center">
                        <!-- KIRI: Tombol Aksi -->
                        <div class="flex flex-wrap items-center gap-2">
                            <!-- Tombol Minta Produk -->
                            <a
                                href="{{ route('productin.create') }}"
                                class="inline-flex items-center rounded bg-green-600 px-4 py-2 text-sm text-white shadow-sm hover:bg-green-700"
                            >
                                <i class="fas fa-plus-circle mr-2"></i>
                                Minta Produk
                            </a>

                            <!-- Tombol Bulk Delete -->
                            <form
                                method="POST"
                                action="{{ route('productin.bulkDelete') }}"
                                onsubmit="return confirm('Yakin ingin menghapus produk terpilih?')"
                            >
                                @csrf
                                <input
                                    type="hidden"
                                    name="ids"
                                    id="bulkDeleteIds"
                                />
                                <button
                                    id="deleteAllBtn"
                                    type="submit"
                                    class="inline-flex hidden items-center gap-2 rounded bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 disabled:opacity-50"
                                    disabled
                                >
                                    <i class="fas fa-trash-alt"></i>
                                    Pilih Menghapus
                                </button>
                            </form>

                            <!-- Filter Data -->
                            <div class="relative">
                                <button
                                    onclick="toggleFilterDropdown()"
                                    type="button"
                                    class="inline-flex items-center rounded border border-blue-600 px-4 py-2 text-sm text-blue-600 shadow-sm hover:bg-blue-50"
                                >
                                    <i class="fas fa-filter mr-2"></i>
                                    Filter Data
                                </button>

                                <!-- Dropdown Box Filter -->
                                <div
                                    id="filterDropdown"
                                    class="absolute right-0 z-50 mt-2 hidden w-80 rounded-lg border border-gray-200 bg-white p-4 shadow-lg"
                                >
                                    <!-- Form Filter -->
                                    <form
                                        action="{{ route('productin.index') }}"
                                        method="GET"
                                        class="space-y-4"
                                    >
                                        <!-- Kategori -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">
                                                Kategori
                                            </label>
                                            <select
                                                name="category"
                                                class="w-full rounded border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-blue-400"
                                            >
                                                <option value="">-- Semua Kategori --</option>
                                                @foreach ($categories as $category)
                                                    <option
                                                        value="{{ $category->id }}"
                                                        {{ request('category') == $category->id ? 'selected' : '' }}
                                                    >
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Status Produk -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">
                                                Status Produk
                                            </label>
                                            <select
                                                name="status_produk"
                                                class="w-full rounded border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-blue-400"
                                            >
                                                <option value="">-- Semua --</option>
                                                <option
                                                    value="menunggu"
                                                    {{ request('status_produk') == 'menunggu' ? 'selected' : '' }}
                                                >Menunggu</option>
                                                <option
                                                    value="disetujui"
                                                    {{ request('status_produk') == 'disetujui' ? 'selected' : '' }}
                                                >Disetujui</option>
                                                <option
                                                    value="ditolak"
                                                    {{ request('status_produk') == 'ditolak' ? 'selected' : '' }}
                                                >Ditolak</option>
                                            </select>
                                        </div>

                                        <!-- Status Penjualan -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">
                                                Status Penjualan
                                            </label>
                                            <select
                                                name="status_penjualan"
                                                class="w-full rounded border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-blue-400"
                                            >
                                                <option value="">-- Semua --</option>
                                                <option
                                                    value="belum dijual"
                                                    {{ request('status_penjualan') == 'belum dijual' ? 'selected' : '' }}
                                                >Belum Dijual</option>
                                                <option
                                                    value="sedang dijual"
                                                    {{ request('status_penjualan') == 'sedang dijual' ? 'selected' : '' }}
                                                >Sedang Dijual</option>
                                                <option
                                                    value="stok tinggal dikit"
                                                    {{ request('status_penjualan') == 'stok tinggal dikit' ? 'selected' : '' }}
                                                >Stok Tinggal Dikit</option>
                                                <option
                                                    value="stok habis terjual"
                                                    {{ request('status_penjualan') == 'stok habis terjual' ? 'selected' : '' }}
                                                >Stok Habis Terjual</option>
                                            </select>
                                        </div>

                                        <!-- Filter Harga -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">
                                                Harga (Min - Max)
                                            </label>
                                            <div class="flex gap-2">
                                                <input
                                                    type="number"
                                                    name="min_price"
                                                    value="{{ request('min_price') }}"
                                                    placeholder="Min"
                                                    class="w-1/2 rounded border px-3 py-2 text-sm"
                                                />
                                                <input
                                                    type="number"
                                                    name="max_price"
                                                    value="{{ request('max_price') }}"
                                                    placeholder="Max"
                                                    class="w-1/2 rounded border px-3 py-2 text-sm"
                                                />
                                            </div>
                                        </div>

                                        <!-- Filter Qty -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">
                                                Qty (Min - Max)
                                            </label>
                                            <div class="flex gap-2">
                                                <input
                                                    type="number"
                                                    name="min_qty"
                                                    value="{{ request('min_qty') }}"
                                                    placeholder="Min"
                                                    class="w-1/2 rounded border px-3 py-2 text-sm"
                                                />
                                                <input
                                                    type="number"
                                                    name="max_qty"
                                                    value="{{ request('max_qty') }}"
                                                    placeholder="Max"
                                                    class="w-1/2 rounded border px-3 py-2 text-sm"
                                                />
                                            </div>
                                        </div>

                                        <!-- Tombol Aksi Filter -->
                                        <div class="flex justify-between pt-2">
                                            <a
                                                href="{{ route('productin.index') }}"
                                                class="inline-flex items-center rounded-md bg-gray-300 px-4 py-2 text-sm text-gray-800 shadow-sm hover:bg-gray-400"
                                            >
                                                <i class="fas fa-undo mr-1"></i>
                                                Reset Filter

                                            </a>
                                            <button
                                                type="submit"
                                                class="rounded bg-blue-600 px-4 py-2 text-sm text-white hover:bg-blue-700"
                                            >
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
                            <form
                                method="GET"
                                action="{{ route('productin.index') }}"
                                class="flex flex-col items-end gap-2 sm:flex-row sm:items-center"
                            >
                                <input
                                    type="text"
                                    name="search"
                                    value="{{ request('search') }}"
                                    placeholder="Cari nama produk..."
                                    class="w-full rounded border px-3 py-2 text-sm shadow focus:border-blue-300 focus:outline-none focus:ring sm:w-56"
                                >
                                <div class="flex gap-2">
                                    <button
                                        type="submit"
                                        class="flex items-center gap-1 rounded bg-blue-600 px-3 py-2 text-sm text-white hover:bg-blue-700"
                                    >
                                        <i class="fas fa-search"></i>
                                        Cari
                                    </button>
                                    <a
                                        href="{{ route('productin.index') }}"
                                        class="ml-2 inline-flex items-center rounded-md bg-gray-300 px-4 py-2 text-sm text-gray-800 shadow-sm hover:bg-gray-400""
                                    >
                                        <i class="fas fa-redo-alt mr-2"></i>
                                        Reset
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>


                    <div class="overflow-x-auto rounded-lg border border-gray-200 shadow">
                        <table
                            id="example1"
                            class="min-w-full divide-y divide-gray-200 bg-white text-sm text-gray-700"
                        >
                            <thead
                                class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wider text-gray-600"
                            >
                                <tr>
                                    <th class="px-4 py-3 text-center">
                                        <input
                                            type="checkbox"
                                            id="selectAll"
                                            class="form-checkbox text-blue-600"
                                        />
                                    </th>
                                    <th class="px-4 py-3">Nama Produk</th>
                                    <th class="px-4 py-3">Kode Produk</th>
                                    <th class="px-4 py-3">Tanggal Masuk</th>
                                    <th class="px-4 py-3">Gambar Produk</th>
                                    <th class="px-4 py-3">Kategori Produk</th>
                                    <th class="px-4 py-3">Harga</th>
                                    <th class="px-4 py-3">Qty</th>
                                    <th class="px-4 py-3">Penerima</th>
                                    <th class="px-4 py-3">Status</th>
                                    <th class="px-4 py-3">Status Penjualan</th>
                                    <th class="px-4 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="relative z-10 divide-y divide-gray-200 overflow-visible">
                                @forelse ($productIns as $productIn)
                                    <tr
                                        x-data="{ visible: true }"
                                        x-show="visible"
                                        id="productin-{{ $productIn->id }}"
                                        class="hover:bg-gray-50"
                                    >
                                        <td class="px-4 py-3 text-center">
                                            <input
                                                type="checkbox"
                                                class="form-checkbox select-item text-blue-600"
                                                value="{{ $productIn->id }}"
                                                name="ids[]"
                                            />
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
                                                <img
                                                    src="{{ asset('storage/fotoproduct/produk/' . $productIn->product->photo) }}"
                                                    alt="Image"
                                                    class="h-12 w-12 rounded object-cover"
                                                />
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
                                        <td class="px-4 py-2">{{ $productIn->recipient }}</td>
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
                                                class="{{ $statusClass }} inline-flex rounded-full px-3 py-1 text-xs font-medium"
                                            >
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
                                                        class="inline-flex rounded-full bg-blue-100 px-2 py-1 text-xs text-blue-700"
                                                    >
                                                        Sedang Dijual
                                                    </span>
                                                @elseif ($statusPenjualan === 'stok habis terjual')
                                                    <span
                                                        class="inline-flex rounded-full bg-red-100 px-2 py-1 text-xs text-red-700"
                                                    >
                                                        Stok Habis
                                                    </span>
                                                @elseif ($statusPenjualan === 'stok tinggal dikit')
                                                    <span
                                                        class="inline-flex rounded-full bg-yellow-100 px-2 py-1 text-xs text-yellow-700"
                                                    >
                                                        Stok Tinggal Dikit
                                                    </span>
                                                @elseif ($statusPenjualan === 'belum dijual')
                                                    <span
                                                        class="inline-flex rounded-full bg-gray-100 px-2 py-1 text-xs text-gray-700"
                                                    >
                                                        Belum Dijual
                                                    </span>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif

                                                @if ($statusPenjualan !== 'belum dijual')
                                                    <div class="mt-1 text-xs text-gray-500">
                                                        <i class="fas fa-box me-1"></i>
                                                        Sisa Stok: {{ $stokToko }}
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="relative whitespace-nowrap px-4 py-2">
                                            <div
                                                x-data="{ open: false }"
                                                class="relative inline-block text-left"
                                            >
                                                <!-- Dropdown Toggle -->
                                                <button
                                                    @click="open = !open"
                                                    @click.away="open = false"
                                                    type="button"
                                                    class="inline-flex items-center rounded bg-gray-100 px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1"
                                                >
                                                    <i class="fas fa-cogs mr-1"></i>
                                                    Aksi
                                                    <svg
                                                        class="ml-1 h-3 w-3"
                                                        viewBox="0 0 20 20"
                                                        fill="currentColor"
                                                    >
                                                        <path
                                                            fill-rule="evenodd"
                                                            d="M5.23 7.21a.75.75 0 011.06.02L10 11.585l3.71-4.355a.75.75 0 111.14.976l-4.25 5a.75.75 0 01-1.14 0l-4.25-5a.75.75 0 01.02-1.06z"
                                                            clip-rule="evenodd"
                                                        />
                                                    </svg>
                                                </button>

                                                <!-- Dropdown Menu -->
                                                <div
                                                    x-show="open"
                                                    x-transition
                                                    class="absolute right-0 top-full z-50 mt-2 w-52 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5"
                                                    style="overflow: visible"
                                                >
                                                    <div class="py-1 text-sm text-gray-700">
                                                        @if ($productIn->status === 'disetujui' || session('status') === 'produk disetujui')
                                                            @if ($productIn->sales->isEmpty())
                                                                <button
                                                                    type="button"
                                                                    class="flex w-full items-center px-4 py-2 text-blue-600 hover:bg-gray-100"
                                                                    @click="$dispatch('open-sale-modal', { productId: {{ $productIn->id }}, productName: '{{ optional($productIn->product)->name ?? 'Produk Dihapus' }}' })"
                                                                >
                                                                    🏪
                                                                    <span class="ml-2">
                                                                        Jual di Toko
                                                                    </span>
                                                                </button>
                                                            @else
                                                                <button
                                                                    type="button"
                                                                    class="btn-add-stock flex w-full items-center px-4 py-2 hover:bg-gray-100"
                                                                    @click="$dispatch('open-add-stock-modal', { id: {{ $productIn->id }}, name: '{{ optional($productIn->product)->name ?? 'Produk Dihapus' }}' })"
                                                                >

                                                                    <span class="ml-2">
                                                                        Tambah Stok ke Gudang
                                                                    </span>
                                                                </button>
                                                                @php
                                                                    $totalQtySales = $productIn->sales->sum('qty');
                                                                @endphp

                                                                <button
                                                                    type="button"
                                                                    class="btn-add-stock flex w-full items-center px-4 py-2 hover:bg-gray-100"
                                                                    @click="$dispatch('open-stock-toko-modal', {
                                                                    id: {{ $productIn->id }},
                                                                    name: '{{ optional($productIn->product)->name ?? 'Produk Dihapus' }}',
                                                                    max: {{ $productIn->qty }},
                                                                    stokToko: {{ $totalQtySales }}
                                                                })"
                                                                >
                                                                    <span class="ml-2">Tambah Stok ke Toko</span>
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
                                        <td
                                            colspan="11"
                                            class="py-6 text-center text-gray-500"
                                        >
                                            Maaf, data tidak ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>


                        {{-- modal tambah stok toko --}}
                        <div
                            x-data="stokTokoModal()"
                            x-init="window.addEventListener('open-stock-toko-modal', e => {
                                openModal(e.detail.id, e.detail.name, e.detail.max, e.detail.stokToko);
                            })"
                            x-show="show"
                            x-cloak
                            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
                        >
                            <div class="mx-auto w-full max-w-md rounded-lg bg-white p-6 shadow-lg">
                                <h2
                                    class="mb-4 text-lg font-bold"
                                    x-text="modalTitle"
                                ></h2>

                                <form @submit.prevent="submitForm">
                                    <input
                                        type="hidden"
                                        x-model="productInId"
                                    >

                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700">Jumlah Qty</label>
                                        <input
                                            type="number"
                                            class="mt-1 w-full rounded-md border p-2 focus:border-blue-300 focus:outline-none focus:ring"
                                            min="1"
                                            x-model="qty"
                                        >
                                        <small class="text-gray-500">
                                            <span x-text="'Stok tersedia di Gudang: ' + maxStok"></span><br>
                                            <span x-text="'Stok tersedia di Toko: ' + stokToko"></span>
                                        </small>

                                    </div>

                                    <div class="flex justify-end space-x-2">
                                        <button
                                            type="button"
                                            @click="closeModal"
                                            class="rounded bg-gray-200 px-4 py-2"
                                        >Batal</button>
                                        <button
                                            type="submit"
                                            class="rounded bg-blue-600 px-4 py-2 text-white"
                                        >Tambah ke Toko</button>
                                    </div>
                                </form>
                            </div>
                        </div>



                        <!-- Modal Tambah Stok Gudang -->
                        <div
                            x-data="addStockModal()"
                            x-show="open"
                            x-cloak
                            @open-add-stock-modal.window="openModal($event.detail)"
                            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
                        >
                            <div class="w-full max-w-md rounded-lg bg-white p-6 shadow">
                                <h2 class="mb-4 text-xl font-semibold text-gray-800">Tambah Stok ke Gudang</h2>
                                <p class="mb-2 text-gray-600">Produk: <span
                                        class="font-semibold"
                                        x-text="productName"
                                    ></span></p>
                                <form @submit.prevent="submitForm">
                                    <input
                                        type="hidden"
                                        x-model="productInId"
                                    >
                                    <div class="mb-4">
                                        <label class="block text-gray-700">Jumlah Tambah (Qty)</label>
                                        <input
                                            type="number"
                                            min="1"
                                            x-model.number="qty"
                                            class="mt-1 w-full rounded-md border p-2 focus:border-blue-300 focus:outline-none focus:ring"
                                            required
                                        >
                                    </div>
                                    <template x-if="errorMessage">
                                        <div
                                            class="mb-2 text-sm text-red-600"
                                            x-text="errorMessage"
                                        ></div>
                                    </template>
                                    <template x-if="successMessage">
                                        <div
                                            class="mb-2 text-sm text-green-600"
                                            x-text="successMessage"
                                        ></div>
                                    </template>
                                    <div class="flex justify-end space-x-2">
                                        <button
                                            type="button"
                                            @click="closeModal"
                                            class="rounded bg-gray-300 px-4 py-2 text-gray-800 hover:bg-gray-400"
                                        >Batal</button>
                                        <button
                                            type="submit"
                                            class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
                                        >Tambah</button>
                                    </div>
                                </form>
                            </div>
                        </div>


                        <!-- Modal Alpine -->
                        <div
                            x-data="{ open: false, productId: null, productName: '', qty: 1 }"
                            x-show="open"
                            x-cloak
                            @open-sale-modal.window="
                                open = true;
                                productId = $event.detail.productId;
                                productName = $event.detail.productName;
                                qty = 1;
                                $nextTick(() => $refs.qtyInput.focus());
                            "
                            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
                        >
                            <div class="w-full max-w-md rounded-lg bg-white p-6 shadow-lg">
                                <h2 class="mb-4 text-xl font-semibold text-gray-800">Jual Produk: <span
                                        x-text="productName"
                                    ></span></h2>

                                <form
                                    method="POST"
                                    action="{{ route('sales.store') }}"
                                >
                                    @csrf
                                    <input
                                        type="hidden"
                                        name="product_ins_id"
                                        :value="productId"
                                    >

                                    <div class="mb-4">
                                        <label
                                            for="qty"
                                            class="block text-gray-700"
                                        >Jumlah (Qty)</label>
                                        <input
                                            type="number"
                                            name="qty"
                                            x-ref="qtyInput"
                                            min="1"
                                            x-model="qty"
                                            class="mt-1 w-full rounded-md border p-2 focus:border-blue-300 focus:outline-none focus:ring"
                                            required
                                        >
                                    </div>

                                    <div class="flex justify-end space-x-2">
                                        <button
                                            type="button"
                                            @click="open = false"
                                            class="rounded bg-gray-300 px-4 py-2 text-gray-800 hover:bg-gray-400"
                                        >Batal</button>
                                        <button
                                            type="submit"
                                            class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
                                        >Jual ke Toko</button>
                                    </div>
                                </form>
                            </div>
                        </div>


                        <div
                            x-data="{
                                openModal: false,
                                selectedProductId: null,
                                selectedProductName: null,
                                rejectionNote: '',
                            }"
                            x-cloak
                            @open-rejection-modal.window="
                                    openModal = true;
                                    selectedProductId = $event.detail.id;
                                    selectedProductName = $event.detail.name;
                                "
                        >
                            <div
                                x-show="openModal"
                                x-cloak
                                class="fixed inset-0 z-50 flex items-center justify-center bg-gray-600 bg-opacity-75"
                            >
                                <div
                                    class="m-4 w-full max-w-sm rounded-lg bg-white p-6 shadow-xl"
                                    @click.away="openModal = false"
                                >
                                    <h3 class="mb-4 text-lg font-semibold">
                                        Tolak
                                        <span x-text="selectedProductName"></span>
                                    </h3>
                                    <form
                                        :action="'{{ route('productin.updateStatus', '') }}/' + selectedProductId"
                                        method="POST"
                                    >
                                        @csrf
                                        @method('PUT')
                                        <input
                                            type="hidden"
                                            name="status"
                                            value="ditolak"
                                        />
                                        <div class="mb-4">
                                            <label
                                                for="catatan"
                                                class="mb-2 block text-sm font-bold text-gray-700"
                                            >
                                                Catatan Penolakan:
                                            </label>
                                            <textarea
                                                name="catatan"
                                                id="catatan"
                                                rows="4"
                                                class="focus:shadow-outline w-full appearance-none rounded border px-3 py-2 leading-tight text-gray-700 shadow focus:outline-none"
                                                x-model="rejectionNote"
                                                required
                                            ></textarea>
                                        </div>
                                        <div class="flex justify-end">
                                            <button
                                                type="button"
                                                @click="openModal = false"
                                                class="mr-2 rounded bg-gray-300 px-4 py-2 font-bold text-gray-800 hover:bg-gray-400"
                                            >
                                                Batal
                                            </button>
                                            <button
                                                type="submit"
                                                class="rounded bg-red-500 px-4 py-2 font-bold text-white hover:bg-red-700"
                                            >
                                                Kirim Penolakan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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


        function addStockModal() {
            return {
                open: false,
                productInId: null,
                productName: '',
                qty: 1,

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
                    this.productInId = null;
                    this.productName = '';
                    this.qty = 1;
                },

                notify(message, type = 'info') {
                    window.dispatchEvent(new CustomEvent('notify', {
                        detail: {
                            message,
                            type
                        }
                    }));
                },

                async submitForm() {
                    if (this.qty < 1) {
                        this.notify('Jumlah minimal 1', 'warning');
                        return;
                    }

                    try {
                        const response = await fetch(`/productin/add-stock/${this.productInId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content'),
                            },
                            body: JSON.stringify({
                                tambah_qty: this.qty
                            })
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            this.notify(data.message || 'Terjadi kesalahan.', 'error');
                            return;
                        }

                        this.notify(data.message, 'success');

                        setTimeout(() => {
                            this.closeModal();
                            window.location.reload();
                        }, 1000);

                    } catch (error) {
                        this.notify('Gagal mengirim data.', 'error');
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

                notify(message, type = 'info') {
                    window.dispatchEvent(new CustomEvent('notify', {
                        detail: {
                            message,
                            type
                        }
                    }));
                },

                submitForm() {
                    if (this.qty < 1) {
                        this.notify('Jumlah minimal 1', 'warning');
                        return;
                    }

                    if (this.qty > this.maxStok) {
                        this.notify(`Jumlah melebihi stok gudang. Maksimum ${this.maxStok}`, 'warning');
                        return;
                    }

                    fetch(`/productin/add-stock-toko/${this.productInId}`, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                qty: this.qty
                            })
                        })
                        .then(async res => {
                            const contentType = res.headers.get("content-type") || "";
                            if (!res.ok || !contentType.includes("application/json")) {
                                const text = await res.text();
                                throw new Error('Terjadi kesalahan dari server.');
                            }
                            return res.json();
                        })
                        .then(data => {
                            if (data.success) {
                                this.notify(data.message, 'success');
                                this.closeModal();
                                setTimeout(() => {
                                    window.location.href = data.redirect_url || '/productin';
                                }, 800);
                            } else {
                                this.notify(data.message || 'Gagal menambahkan stok ke toko.', 'error');
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            this.notify(err.message || 'Gagal terhubung ke server.', 'error');
                        });
                }
            };
        }
    </script>
@endpush
