@extends('layouts.master')

@section('title')
    <title>KASIRIN.ID - Edit Produk</title>
@endsection

@section('content')
    <section class="mb-6 rounded-lg bg-white p-6 shadow-sm dark:bg-gray-800 dark:text-gray-100">
        <div
            class="mx-auto flex max-w-7xl flex-col items-start justify-between gap-4 sm:flex-row sm:items-center"
        >
            <!-- Title -->
            <div>
                <h1 class="text-2xl font-bold dark:bg-gray-800 dark:text-gray-100">Edit Produk</h1>
                <p class="mt-1 text-sm text-gray-500">
                    Ubah informasi produk sesuai kebutuhan Anda
                </p>
            </div>
        </div>
    </section>

    <!-- Form -->
    <div class="rounded-xl bg-white p-6 shadow-lg dark:bg-gray-800 dark:text-gray-100">
        <form
            action="{{ route('product.update', ['product' => $product->id]) }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-6"
        >
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                <!-- Nama Produk -->
                <div>
                    <label
                        for="productName"
                        class="mb-1 block text-sm font-semibold dark:bg-gray-800 dark:text-gray-100"
                    >
                        Nama Produk
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="productName"
                        class="w-full rounded-md border px-4 py-2 shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none dark:bg-gray-800 dark:text-gray-100"
                        value="{{ $product->name }}"
                        required
                    />
                </div>

                <!-- Kode Produk -->
                <div>
                    <label
                        for="productCode"
                        class="mb-1 block text-sm font-semibold dark:bg-gray-800 dark:text-gray-100"
                    >
                        Kode Produk
                    </label>
                    <input
                        type="text"
                        name="code"
                        id="productCode"
                        class="w-full cursor-not-allowed rounded-md border border-gray-200 bg-gray-100 px-4 py-2 text-gray-500"
                        value="{{ $product->code }}"
                        readonly
                    />
                </div>

                <div
                    x-data="photoHandler(
                                {{ $product->id }},
                                '{{ route('product.deletePhoto', $product->id) }}',
                            )"
                    class="relative"
                >
                    <label
                        for="productPhoto"
                        class="mb-1 block text-sm font-semibold dark:bg-gray-800 dark:text-gray-100"
                    >
                        Upload Foto
                    </label>
                    <input
                        type="file"
                        name="photo"
                        id="productPhoto"
                        class="w-full rounded-lg text-sm file:border-none file:bg-gray-100 file:px-3 file:py-2 dark:bg-gray-800 dark:text-gray-100 file:dark:bg-gray-800"
                    />

                    <!-- Preview Foto -->
                    <template x-if="photo">
                        <div class="relative mt-2 inline-block">
                            <img
                                :src="photo"
                                alt="Foto Produk"
                                class="h-24 w-24 rounded border shadow-md dark:bg-gray-800 dark:text-gray-100"
                            />

                            <!-- Tombol Delete (icon overlay) -->
                            <button
                                type="button"
                                @click="deletePhotoPreview()"
                                class="absolute top-1 right-1 flex h-6 w-6 items-center justify-center rounded-full bg-red-500 text-white shadow hover:bg-red-600"
                                title="Hapus Foto"
                            >
                                &times;
                            </button>
                        </div>
                    </template>

                    <p x-show="!photo" class="mt-2 text-sm text-gray-400">Foto tidak tersedia</p>

                    <!-- Tombol Save & Cancel lebih minimal -->
                    <div class="mt-3 flex gap-2">
                        <button
                            type="button"
                            class="rounded bg-blue-500 px-4 py-1 text-sm text-white transition hover:bg-blue-600"
                            @click="savePhotoChanges()"
                            x-text="loading ? 'Saving...' : 'Save'"
                            :disabled="loading"
                        ></button>

                        <button
                            type="button"
                            class="rounded bg-gray-300 px-4 py-1 text-sm text-gray-700 transition hover:bg-gray-400"
                            @click="cancelEdit()"
                        >
                            Cancel
                        </button>
                    </div>
                </div>

                <!-- Kategori -->
                <div>
                    <label
                        for="categorySelect"
                        class="mb-1 block text-sm font-semibold dark:bg-gray-800 dark:text-gray-100"
                    >
                        Kategori
                    </label>
                    <select
                        name="category_id"
                        id="categorySelect"
                        class="w-full rounded-md border px-4 py-2 shadow-sm focus:ring-2 focus:ring-blue-400 dark:bg-gray-800 dark:text-gray-100"
                        required
                    >
                        <option value="">Pilih Kategori</option>
                        @foreach ($datacategory as $category)
                            <option
                                value="{{ $category->id }}"
                                {{ $product->category_id == $category->id ? 'selected' : '' }}
                            >
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Harga Produk -->
                <div>
                    <label
                        for="productPrice"
                        class="mb-1 block text-sm font-semibold dark:bg-gray-800 dark:text-gray-100"
                    >
                        Harga Produk
                    </label>
                    <input
                        type="number"
                        name="price"
                        id="productPrice"
                        class="@error('price') border-red-500 @else dark:bg-gray-800 dark:text-gray-100 @enderror w-full rounded-md border px-4 py-2 shadow-sm focus:ring-2 focus:ring-blue-400"
                        value="{{ $product->price }}"
                        required
                    />
                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Stok -->
                <div>
                    <label
                        for="productStock"
                        class="mb-1 block text-sm font-semibold dark:bg-gray-800 dark:text-gray-100"
                    >
                        Stok
                    </label>
                    <input
                        type="number"
                        name="stock"
                        id="productStock"
                        class="w-full rounded-md border px-4 py-2 shadow-sm focus:ring-2 focus:ring-blue-400 dark:bg-gray-800 dark:text-gray-100"
                        value="{{ $product->stock }}"
                        required
                    />
                </div>

                <!-- Satuan -->
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Satuan
                    </label>
                    <select
                        name="satuan_id"
                        class="w-full rounded-md border px-4 py-2 shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none dark:bg-gray-800 dark:text-gray-100"
                        required
                    >
                        <option value="">Pilih Satuan</option>
                        @foreach ($satuans as $satuan)
                            <option
                                value="{{ $satuan->id }}"
                                {{ old('satuan_id', $product->satuan_id) == $satuan->id ? 'selected' : '' }}
                            >
                                {{ $satuan->nama_satuan }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="mt-8 flex justify-end space-x-3">
                <button
                    type="submit"
                    class="inline-flex items-center rounded-md bg-blue-600 px-5 py-2 text-white shadow hover:bg-blue-700"
                >
                    <i class="fas fa-save mr-2"></i>
                    Simpan Perubahan
                </button>
                <a
                    href="{{ route('product.index') }}"
                    class="inline-flex items-center rounded-md border bg-gray-100 px-5 py-2 shadow hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-100"
                >
                    <i class="fas fa-times mr-2"></i>
                    Batal
                </a>
            </div>
        </form>
    </div>

    <script>
        function photoHandler(productId, deleteUrl) {
            return {
                originalPhoto: '{{ $product->photo }}', // foto asli
                photo: '{{ $product->photo }}', // preview
                toDelete: false,
                loading: false,

                // Hapus foto sementara di preview
                deletePhotoPreview() {
                    this.toDelete = true
                    this.photo = null
                },

                // Simpan perubahan → hapus foto di backend
                savePhotoChanges() {
                    if (this.toDelete) {
                        this.loading = true
                        fetch(deleteUrl, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                Accept: 'application/json',
                            },
                        })
                            .then((res) => res.json())
                            .then((res) => {
                                if (res.success) {
                                    alert(res.message)
                                    this.originalPhoto = null
                                    this.toDelete = false
                                } else {
                                    alert('Gagal menghapus foto.')
                                    this.photo = this.originalPhoto
                                    this.toDelete = false
                                }
                                this.loading = false
                            })
                            .catch((err) => {
                                console.error(err)
                                alert('Terjadi error.')
                                this.photo = this.originalPhoto
                                this.toDelete = false
                                this.loading = false
                            })
                    }
                },

                // Cancel → kembalikan foto
                cancelEdit() {
                    this.photo = this.originalPhoto
                    this.toDelete = false
                },
            }
        }
    </script>
@endsection
