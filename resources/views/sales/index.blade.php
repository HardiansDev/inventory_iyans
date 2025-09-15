@extends('layouts.master')

@section('title')
    <title>KASIRIN.ID - Penjualan</title>
@endsection

@section('content')
    <section class="mb-6 rounded-lg bg-white p-6 shadow-sm dark:bg-gray-800">
        <div class="mx-auto flex max-w-7xl flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
            <!-- Judul dan Deskripsi -->
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Menu Jualan</h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                    Kelola dan proses transaksi penjualan produk secara efisien
                </p>
            </div>
        </div>
    </section>

    <section x-data="wishlistHandler()" x-init="init()" class="relative mx-auto mb-6 max-w-7xl px-4">
        <!-- GRID PRODUK -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            @foreach ($sales as $sale)
                @php
                    $productIn = $sale->productIn;
                    $product = $productIn?->product;
                    $category = $product?->category;
                @endphp

                <div
                    class="rounded-lg bg-white shadow transition hover:shadow-lg dark:bg-gray-900 dark:border dark:border-gray-700">
                    @if ($product)
                        <img src="{{ $product->photo }}" class="h-48 w-full rounded-t-lg object-cover"
                            alt="{{ $product->name }}" />
                    @else
                        <div class="p-4 text-sm text-red-600 dark:text-red-400">Data Produk Dihapus</div>
                    @endif

                    <div class="p-4" x-data="{ qty: 1 }">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                            {{ $product->name ?? 'Produk telah dihapus' }}
                        </h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $category->name ?? 'Kategori tidak tersedia' }}
                        </p>
                        <p class="mb-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ $sale->qty }} Stok Tersedia
                        </p>
                        <p class="mb-3 text-xl font-bold text-green-600 dark:text-green-400">
                            Rp {{ number_format($product?->price ?? 0, 0, ',', '.') }}
                        </p>

                        <!-- Qty + Pesan -->
                        <div class="flex items-center gap-2">
                            <button @click="if (qty > 1) qty--"
                                class="flex h-8 w-8 items-center justify-center rounded-full bg-red-500 font-bold text-white hover:bg-red-600">-</button>
                            <input type="number" x-model="qty"
                                class="qty-input w-14 rounded-md border border-gray-300 text-center text-sm dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                                min="1" />
                            <button @click="if (qty < {{ $sale->qty }}) qty++"
                                class="flex h-8 w-8 items-center justify-center rounded-full bg-green-500 font-bold text-white hover:bg-green-600">+</button>

                            <button
                                @click="$dispatch('add-wishlist', {
                                    salesId: '{{ $sale->id }}',
                                    name: '{{ $product->name ?? 'Tidak Tersedia' }}',
                                    price: {{ $product->price ?? 0 }},
                                    qty: qty
                                })"
                                class="ml-auto rounded bg-yellow-500 px-4 py-2 text-sm text-white hover:bg-yellow-600 disabled:opacity-50"
                                :disabled="{{ $product && $sale->qty > 0 ? 'false' : 'true' }}">
                                {{ $product && $sale->qty > 0 ? 'Pesan' : 'Tidak Tersedia' }}
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Floating Cart Icon -->
        <div x-show="wishlist.length > 0" @click="openCart = !openCart"
            class="fixed bottom-4 right-4 z-50 flex h-14 w-14 cursor-pointer items-center justify-center rounded-full bg-yellow-500 text-white shadow-lg hover:bg-yellow-600"
            title="Lihat Pesanan">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 7M7 13l-1.3 2.7a1 1 0 001.4 1.3L10 15h4l1.3 1.3a1 1 0 001.4-1.3L17 13M5 21a1 1 0 102 0 1 1 0 00-2 0zm12 0a1 1 0 102 0 1 1 0 00-2 0z" />
            </svg>
            <span
                class="absolute right-0 top-0 -translate-y-1/2 translate-x-1/2 transform rounded-full bg-red-600 px-2 py-1 text-xs font-bold text-white"
                x-text="wishlist.length"></span>
        </div>

        <!-- Modal Wishlist -->
        <div x-show="openCart" @click.outside="openCart = false"
            class="fixed bottom-20 right-4 z-50 w-80 rounded-lg border bg-white p-4 shadow-xl dark:bg-gray-800 dark:border-gray-700">
            <h2 class="mb-2 text-lg font-bold text-gray-800 dark:text-white">Pesanan Anda</h2>
            <ul class="max-h-60 space-y-2 overflow-y-auto">
                <template x-for="(item, index) in wishlist" :key="index">
                    <li class="border-b pb-2 dark:border-gray-600">
                        <div class="flex justify-between">
                            <span x-text="item.name" class="dark:text-gray-200"></span>
                            <button @click="removeFromWishlist(index)"
                                class="text-xs text-red-500 hover:underline">Hapus</button>
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            Qty: <span x-text="item.qty"></span> × Rp <span
                                x-text="item.price.toLocaleString('id-ID')"></span>
                        </div>
                    </li>
                </template>
            </ul>
            <div class="mt-3 text-right font-semibold text-gray-800 dark:text-white">
                Total: <span x-text="totalFormatted"></span>
            </div>
            <div class="mt-4 text-right">
                <button x-show="wishlist.length > 0" @click="checkout()"
                    class="w-full rounded bg-teal-600 px-4 py-2 text-white hover:bg-teal-700">Checkout</button>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        function wishlistHandler() {
            return {
                wishlist: [],
                totalPrice: 0,
                openCart: false,

                init() {
                    this.$el.addEventListener('add-wishlist', (e) => {
                        this.addToWishlist(e.detail);
                    });
                },

                addToWishlist(product) {
                    if (product.qty < 1) return;

                    const existing = this.wishlist.find(item => item.sales_id === product.salesId);

                    if (existing) {
                        existing.qty = product.qty;
                    } else {
                        this.wishlist.push({
                            sales_id: product.salesId,
                            name: product.name,
                            qty: product.qty,
                            price: product.price
                        });
                    }

                    this.updateTotalPrice();
                },

                removeFromWishlist(index) {
                    this.wishlist.splice(index, 1);
                    this.updateTotalPrice();
                },

                updateTotalPrice() {
                    this.totalPrice = this.wishlist.reduce((sum, item) => sum + (item.price * item.qty), 0);
                    if (this.wishlist.length === 0) this.openCart = false;
                },

                get totalFormatted() {
                    return 'Rp ' + this.totalPrice.toLocaleString('id-ID');
                },

                checkout() {
                    fetch("{{ route('set.wishlist') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": document.querySelector('meta[name=\"csrf-token\"]').getAttribute(
                                    'content'),
                            },
                            body: JSON.stringify(this.wishlist)
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                window.location.href = "{{ route('detail-cekout') }}";
                            } else {
                                alert("Gagal menyimpan wishlist.");
                            }
                        })
                        .catch(error => {
                            console.error("Error:", error);
                            alert("Terjadi kesalahan saat menyimpan wishlist.");
                        });
                }
            };
        }
    </script>
@endpush
