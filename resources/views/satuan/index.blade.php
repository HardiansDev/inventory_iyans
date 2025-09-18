@extends('layouts.master')
@section('title')
    <title>KASIRIN.ID - Satuan</title>
@endsection


@section('content')
    <div x-data="satuanIndex()" x-init="init()" class="p-6">
        <!-- Header -->
        <section class="mb-6 rounded-lg bg-white p-6 shadow-sm dark:bg-gray-800 dark:text-gray-200">
            <div class="mx-auto flex max-w-7xl flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">Manajemen Satuan</h1>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Kelola data satuan produk agar stok lebih terorganisir
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <button @click="openCreate = true" type="button"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                        <i class="fas fa-plus-circle mr-2"></i> Tambah Satuan
                    </button>
                </div>
            </div>
        </section>


        {{-- Table --}}
        <div class="overflow-x-auto rounded-lg shadow-md">
            <table
                class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm text-gray-700 dark:text-gray-200">
                <thead class="bg-gray-100 dark:bg-gray-700 uppercase font-medium">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium">Nama Satuan</th>
                        <th class="px-4 py-3 text-left font-medium">Keterangan</th>
                        <th class="px-4 py-3 text-center font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($satuans as $satuan)
                        <tr class="border-t border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900">
                            <td class="px-3 py-3">{{ $satuan->nama_satuan }}</td>
                            <td class="px-3 py-3">{{ $satuan->keterangan ?? '-' }}</td>
                            <td class="px-3 py-3 text-center">
                                <div x-data="{ open: false }" class="relative inline-block text-left">
                                    <!-- Trigger Dropdown -->
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
                                            <button
                                                @click="openEditModal({ id: {{ $satuan->id }}, nama_satuan: '{{ addslashes($satuan->nama_satuan) }}', keterangan: '{{ addslashes($satuan->keterangan ?? '') }}' }); open = false"
                                                class="flex w-full items-center px-3 py-2 text-sm text-yellow-500 dark:text-yellow-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                                <i class="fas fa-pencil-alt mr-2"></i> Edit
                                            </button>

                                            <!-- Hapus -->
                                            <button
                                                @click="openDeleteModal({ id: {{ $satuan->id }}, nama_satuan: '{{ addslashes($satuan->nama_satuan) }}' }); open = false"
                                                class="flex w-full items-center px-3 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                                <i class="fas fa-trash mr-2"></i> Hapus
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-3 py-6 text-center text-gray-500 dark:text-gray-400">
                                Belum ada data satuan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- CREATE MODAL -->
        <div x-show="openCreate" x-cloak x-transition.opacity.duration.200ms
            class="fixed inset-0 z-40 flex items-center justify-center p-4">
            <!-- Overlay -->
            <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="openCreate = false"></div>

            <!-- Modal Box -->
            <div @keydown.escape.window="openCreate = false"
                class="relative w-full max-w-lg bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">

                <!-- Header -->
                <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Tambah Satuan</h3>
                    <button @click="openCreate = false" class="text-gray-500 hover:text-gray-700 dark:text-gray-300">
                        ✕
                    </button>
                </div>

                <!-- Form -->
                <form action="{{ route('satuan.store') }}" method="POST" class="p-5 space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Satuan</label>
                        <input type="text" name="nama_satuan" value="{{ old('nama_satuan') }}"
                            class="mt-1 w-full rounded-lg border border-gray-300 dark:border-gray-600 
                              dark:bg-gray-800 dark:text-gray-100 p-2 focus:ring-2 
                              focus:ring-blue-500 focus:border-blue-500">
                        @error('nama_satuan')
                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Keterangan</label>
                        <textarea name="keterangan" rows="3"
                            class="mt-1 w-full rounded-lg border border-gray-300 dark:border-gray-600 
                                 dark:bg-gray-800 dark:text-gray-100 p-2 focus:ring-2 
                                 focus:ring-blue-500 focus:border-blue-500">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" @click="openCreate = false"
                            class="px-4 py-2 rounded-lg bg-gray-200 text-gray-800 hover:bg-gray-300 
                               dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- EDIT MODAL -->
        <div x-show="openEdit" x-cloak x-transition.opacity.duration.200ms
            class="fixed inset-0 z-40 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="openEdit = false"></div>

            <div @keydown.escape.window="openEdit = false"
                class="relative w-full max-w-lg bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">

                <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100"> Edit Satuan</h3>
                    <button @click="openEdit = false"
                        class="text-gray-500 hover:text-gray-700 dark:text-gray-300">✕</button>
                </div>

                <form :action="`${baseUrl}/${edit.id}`" method="POST" class="p-5 space-y-4">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Satuan</label>
                        <input type="text" name="nama_satuan" x-model="edit.nama_satuan"
                            class="mt-1 w-full rounded-lg border border-gray-300 dark:border-gray-600 
                              dark:bg-gray-800 dark:text-gray-100 p-2 focus:ring-2 
                              focus:ring-yellow-500 focus:border-yellow-500">
                        <template x-if="serverError.nama_satuan">
                            <p class="text-sm text-red-600 dark:text-red-400 mt-1" x-text="serverError.nama_satuan"></p>
                        </template>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Keterangan</label>
                        <textarea name="keterangan" rows="3" x-model="edit.keterangan"
                            class="mt-1 w-full rounded-lg border border-gray-300 dark:border-gray-600 
                                 dark:bg-gray-800 dark:text-gray-100 p-2 focus:ring-2 
                                 focus:ring-yellow-500 focus:border-yellow-500"></textarea>
                        <template x-if="serverError.keterangan">
                            <p class="text-sm text-red-600 dark:text-red-400 mt-1" x-text="serverError.keterangan"></p>
                        </template>
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" @click="openEdit = false"
                            class="px-4 py-2 rounded-lg bg-gray-200 text-gray-800 hover:bg-gray-300 
                               dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 rounded-lg bg-yellow-500 text-white hover:bg-yellow-600">
                            Perbarui
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- DELETE CONFIRM MODAL -->
        <div x-show="openDelete" x-cloak x-transition.opacity.duration.200ms
            class="fixed inset-0 z-40 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="openDelete = false"></div>

            <div
                class="relative w-full max-w-md bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-5">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100"> Hapus Satuan</h3>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                    Yakin ingin menghapus: <span class="font-medium" x-text="deleteTarget.nama_satuan"></span> ?
                </p>

                <div class="mt-4 flex justify-end gap-2">
                    <button @click="openDelete = false"
                        class="px-4 py-2 rounded-lg bg-gray-200 text-gray-800 hover:bg-gray-300 
                           dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                        Batal
                    </button>

                    <form :action="`${baseUrl}/${deleteTarget.id}`" method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script>
        function satuanIndex() {
            return {
                baseUrl: '{{ url('satuan') }}',
                openCreate: false,
                openEdit: false,
                openDelete: false,
                edit: {
                    id: '',
                    nama_satuan: '',
                    keterangan: ''
                },
                deleteTarget: {
                    id: '',
                    nama_satuan: ''
                },
                serverError: {},

                init() {
                    // Jika ada error dari server (validasi), otomatis buka modal
                    @if ($errors->any())
                        // kalau error dari create
                        @if (!old('id') && !old('edit_id'))
                            this.openCreate = true
                        @else
                            // kalau error dari edit
                            this.edit.id = "{{ old('id') ?? old('edit_id') }}"
                            this.edit.nama_satuan = `{{ addslashes(old('nama_satuan', '')) }}`
                            this.edit.keterangan = `{{ addslashes(old('keterangan', '')) }}`
                            this.openEdit = true

                            // inject error server ke objek Alpine
                            this.serverError = {
                                @foreach ($errors->getMessages() as $key => $msgs)
                                    "{{ $key }}": "{{ addslashes(implode(' ', $msgs)) }}",
                                @endforeach
                            }
                        @endif
                    @endif
                },

                // buka modal edit dengan payload dari tombol edit
                openEditModal(payload) {
                    this.edit.id = payload.id
                    this.edit.nama_satuan = payload.nama_satuan
                    this.edit.keterangan = payload.keterangan
                    this.serverError = {}
                    this.openEdit = true
                },

                // buka modal delete dengan payload dari tombol hapus
                openDeleteModal(payload) {
                    this.deleteTarget.id = payload.id
                    this.deleteTarget.nama_satuan = payload.nama_satuan
                    this.openDelete = true
                }
            }
        }
    </script>
@endsection
