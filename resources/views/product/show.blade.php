@extends('layouts.master')

@section('title')
    <title>Detail Produk | Sistem Inventory Iyan</title>
@endsection

@section('content')
    <section class="mb-6 rounded-lg bg-white p-6 shadow-sm">
        <div class="mx-auto flex max-w-7xl flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
            <!-- Title -->
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Manajemen Produk</h1>
                <p class="mt-1 text-sm text-gray-500">
                    Kelola data produk dalam sistem inventory Anda
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
                            href="{{ route('product.index') }}"
                            class="flex items-center text-gray-500 hover:text-blue-600"
                        >
                            <i class="fa fa-box mr-1"></i>
                            <span>Produk</span>
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
                    <li class="text-gray-400">Detail Produk</li>
                </ol>
            </nav>
        </div>
    </section>
    <div class="container mx-auto my-8 max-w-5xl px-4">
        <div class="rounded-xl bg-white p-6 shadow-lg">
            <!-- Header -->
            <div class="mb-4 flex items-center justify-between border-b pb-4">
                <h2 class="text-xl font-semibold text-gray-700">Detail {{ $product->name }}</h2>
                <a
                    href="{{ route('product.index') }}"
                    class="inline-flex items-center rounded-lg bg-gray-100 px-4 py-2 text-sm text-gray-700 hover:bg-gray-200"
                >
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </div>

            <!-- Konten -->
            <div class="grid grid-cols-1 items-start gap-6 md:grid-cols-2">
                <!-- Gambar -->
                <div class="flex justify-center">
                    <img
                        src="{{ asset('/storage/fotoproduct/produk/' . $product->photo) }}"
                        alt="Foto Produk"
                        class="max-h-80 rounded-lg object-cover shadow-md"
                    />
                </div>

                <!-- Detail -->
                <div>
                    <table class="w-full text-sm text-gray-700">
                        <tbody class="space-y-4">
                            <tr class="border-b">
                                <th class="w-32 py-2 text-left font-medium">Nama</th>
                                <td class="py-2">: {{ $product->name }}</td>
                            </tr>
                            <tr class="border-b">
                                <th class="py-2 text-left font-medium">Kode Produk</th>
                                <td class="py-2">: {{ $product->code }}</td>
                            </tr>
                            <tr class="border-b">
                                <th class="py-2 text-left font-medium">Kategori</th>
                                <td class="py-2">: {{ $product->category->name }}</td>
                            </tr>
                            <tr class="border-b">
                                <th class="py-2 text-left font-medium">Harga</th>
                                <td class="py-2">
                                    : Rp {{ number_format($product->price, 0, ',', '.') }}
                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="py-2 text-left font-medium">Stok</th>
                                <td class="py-2">: {{ $product->stock }}</td>
                            </tr>

                            <tr>
                                <th class="py-2 text-left font-medium">Supplier</th>
                                <td class="py-2">: {{ $product->supplier->name }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
