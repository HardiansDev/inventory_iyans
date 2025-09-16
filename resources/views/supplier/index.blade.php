@extends('layouts.master')

@section('title')
    <title>KASIRIN.ID - Supplier</title>
@endsection

@section('content')
    <!-- Header -->
    <section class="mb-6 rounded-lg bg-white p-6 shadow-sm dark:bg-gray-800 dark:text-gray-200">
        <div class="mx-auto flex max-w-7xl flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Manajemen Supplier</h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Kelola data supplier dalam sistem inventory Anda
                </p>
            </div>
        </div>
    </section>

    <!-- Konten -->
    <section class="rounded bg-white p-6 shadow-sm dark:bg-gray-800 dark:text-gray-200">
        <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-2">
            <!-- Tombol Trigger Modal Tambah -->
            <div class="flex md:justify-start">
                <button onclick="openAddSupplierModal()"
                    class="flex w-full items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 md:w-auto">
                    <i class="fas fa-plus-circle"></i>
                    <span>Tambah Supplier</span>
                </button>
            </div>

            <!-- Form Pencarian Supplier -->
            <div class="flex md:justify-end">
                <form action="{{ route('supplier.index') }}" method="GET"
                    class="flex w-full flex-col items-stretch gap-2 sm:flex-row sm:items-center sm:gap-2 md:w-auto">
                    <input type="search" name="search" value="{{ $search }}" placeholder="Cari..."
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-700 shadow-sm
                        focus:border-blue-500 focus:ring-blue-500 sm:w-72
                        dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" />
                    <div class="flex gap-2">
                        <button type="submit"
                            class="flex flex-1 items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm text-white shadow-sm hover:bg-blue-700 sm:flex-none">
                            <i class="fas fa-search mr-2"></i>
                            Cari
                        </button>
                        <a href="{{ route('supplier.index') }}"
                            class="flex flex-1 items-center justify-center rounded-lg bg-gray-300 px-4 py-2 text-sm text-gray-800 shadow-sm hover:bg-gray-400 sm:flex-none
                            dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500">
                            <i class="fas fa-redo-alt mr-2"></i>
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabel Data -->
        <div class="overflow-x-auto rounded-lg border border-gray-200 shadow dark:border-gray-700">
            <table id="example1"
                class="min-w-full divide-y divide-gray-200 bg-white text-sm text-gray-700 dark:bg-gray-800 dark:text-gray-200 dark:divide-gray-700">
                <thead
                    class="bg-gray-50 text-left font-semibold uppercase tracking-wider text-gray-600 dark:bg-gray-700 dark:text-gray-300">
                    <tr>
                        <th class="px-4 py-2 font-medium">Supplier</th>
                        <th class="px-4 py-2 font-medium">Produk</th>
                        <th class="px-4 py-2 font-medium">Alamat</th>
                        <th class="px-4 py-2 font-medium">No Telp</th>
                        <th class="px-4 py-2 font-medium">Email</th>
                        <th class="px-4 py-2 text-center font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($suppliers as $index => $item)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-4 py-2">{{ $item->name }}</td>
                            <td class="px-4 py-2">{{ $item->name_prod }}</td>
                            <td class="px-4 py-2">{{ $item->address }}</td>
                            <td class="px-4 py-2">{{ $item->telp }}</td>
                            <td class="px-4 py-2">{{ $item->email_sup }}</td>
                            <td class="px-4 py-2 text-center">
                                <div class="flex justify-center gap-2">
                                    <button type="button"
                                        onclick="openEditModal(
                                            {{ $item->id }},
                                            '{{ addslashes($item->name) }}',
                                            '{{ addslashes($item->name_prod) }}',
                                            '{{ addslashes($item->address) }}',
                                            '{{ $item->telp }}',
                                            '{{ $item->email_sup }}'
                                        )"
                                        class="rounded-lg bg-yellow-400 px-3 py-1 text-sm text-white hover:bg-yellow-500 dark:bg-yellow-500 dark:hover:bg-yellow-600">
                                        <i class="fas fa-edit"></i>
                                        Edit
                                    </button>
                                    <button type="button"
                                        onclick="openDeleteModal({{ $item->id }}, '{{ $item->name }}')"
                                        class="rounded-lg bg-red-500 px-3 py-1 text-sm text-white hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-700">
                                        <i class="fas fa-trash-alt"></i>
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                                Data Supplier tidak ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Modal Tambah Supplier -->
            <div id="addSupplierModal"
                class="fixed inset-0 z-50 flex hidden items-center justify-center bg-black bg-opacity-50">
                <div class="w-full max-w-lg rounded-lg bg-white p-6 shadow-lg dark:bg-gray-800 dark:text-gray-200">
                    <h2 class="mb-4 text-lg font-semibold text-gray-800 dark:text-gray-100">Tambah Supplier</h2>
                    <form action="{{ route('supplier.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="addSupplierName" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Nama Supplier
                            </label>
                            <input type="text" name="name" id="addSupplierName"
                                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2
                                focus:border-blue-500 focus:ring-blue-500
                                dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                placeholder="Nama Supplier" required />
                        </div>
                        <div class="mb-4">
                            <label for="addSupplierProduct"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Nama Produk
                            </label>
                            <input type="text" name="name_prod" id="addSupplierProduct"
                                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2
                                focus:border-blue-500 focus:ring-blue-500
                                dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                placeholder="Nama Produk" required />
                        </div>
                        <div class="mb-4">
                            <label for="addSupplierAddress"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Alamat Supplier
                            </label>
                            <textarea name="address" id="addSupplierAddress"
                                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2
                                focus:border-blue-500 focus:ring-blue-500
                                dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                placeholder="Alamat Supplier" required></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="addSupplierTelp" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                No Telepon Supplier
                            </label>
                            <input type="tel" name="telp" id="addSupplierTelp"
                                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2
                                focus:border-blue-500 focus:ring-blue-500
                                dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                placeholder="08xxxxx" required />
                        </div>
                        <div class="mb-4">
                            <label for="addSupplierEmail"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Email Supplier
                            </label>
                            <input type="email" name="email_sup" id="addSupplierEmail"
                                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2
                                focus:border-blue-500 focus:ring-blue-500
                                dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                placeholder="supplier@mail.com" />
                        </div>
                        <div class="flex justify-end gap-2">
                            <button type="button" onclick="closeAddSupplierModal()"
                                class="rounded bg-gray-300 px-4 py-2 text-gray-800 hover:bg-gray-400
                                dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500">
                                Batal
                            </button>
                            <button type="submit"
                                class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700
                                dark:bg-blue-500 dark:hover:bg-blue-600">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Edit Supplier -->
            <div id="editSupplierModal"
                class="fixed inset-0 z-50 flex hidden items-center justify-center bg-black bg-opacity-50">
                <div class="w-full max-w-lg rounded-lg bg-white p-6 shadow-lg dark:bg-gray-800 dark:text-gray-200">
                    <h2 class="mb-4 text-lg font-semibold text-gray-800 dark:text-gray-100">Edit Supplier</h2>
                    <form id="editSupplierForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="editSupplierName"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Nama Supplier
                            </label>
                            <input type="text" name="name" id="editSupplierName"
                                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2
                                focus:border-blue-500 focus:ring-blue-500
                                dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                required />
                        </div>
                        <div class="mb-4">
                            <label for="editSupplierProduct"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Nama Produk
                            </label>
                            <input type="text" name="name_prod" id="editSupplierProduct"
                                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2
                                focus:border-blue-500 focus:ring-blue-500
                                dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                required />
                        </div>
                        <div class="mb-4">
                            <label for="editSupplierAddress"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Alamat Supplier
                            </label>
                            <textarea name="address" id="editSupplierAddress"
                                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2
                                focus:border-blue-500 focus:ring-blue-500
                                dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                required></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="editSupplierTelp"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                No Telepon Supplier
                            </label>
                            <input type="tel" name="telp" id="editSupplierTelp"
                                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2
                                focus:border-blue-500 focus:ring-blue-500
                                dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                placeholder="08xxxxx" required />
                        </div>
                        <div class="mb-4">
                            <label for="editSupplierEmail"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Email Supplier
                            </label>
                            <input type="email" name="email_sup" id="editSupplierEmail"
                                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2
                                focus:border-blue-500 focus:ring-blue-500
                                dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                placeholder="supplier@mail.com" />
                        </div>
                        <div class="flex justify-end gap-2">
                            <button type="button" onclick="closeEditModal()"
                                class="rounded bg-gray-300 px-4 py-2 text-gray-800 hover:bg-gray-400
                                dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500">
                                Batal
                            </button>
                            <button type="submit"
                                class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700
                                dark:bg-blue-500 dark:hover:bg-blue-600">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

        <!-- Pagination -->
        <div class="mt-4 flex justify-end">
            {{ $suppliers->appends(Request::except('page'))->links('vendor.pagination.tailwind') }}
        </div>
    </section>

    <!-- Modal Konfirmasi Hapus -->
    <div id="deleteModal" class="fixed inset-0 z-50 flex hidden items-center justify-center bg-black bg-opacity-50">
        <div class="w-full max-w-md rounded-lg bg-white p-6 shadow-lg dark:bg-gray-800 dark:text-gray-200">
            <h2 class="mb-4 text-lg font-semibold text-gray-800 dark:text-gray-100">Konfirmasi Hapus</h2>
            <p class="mb-6 text-gray-700 dark:text-gray-300">
                Yakin ingin menghapus supplier
                <span id="supplierName" class="font-bold"></span>?
            </p>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeDeleteModal()"
                        class="rounded bg-gray-300 px-4 py-2 text-gray-800 hover:bg-gray-400
                        dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500">
                        Batal
                    </button>
                    <button type="submit"
                        class="rounded bg-red-600 px-4 py-2 text-white hover:bg-red-700
                        dark:bg-red-500 dark:hover:bg-red-600">
                        Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        function openDeleteModal(id, name) {
            const modal = document.getElementById('deleteModal')
            const form = document.getElementById('deleteForm')
            const nameSpan = document.getElementById('supplierName')

            form.action = `/supplier/${id}`
            nameSpan.textContent = name

            modal.classList.remove('hidden')
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden')
        }

        window.addEventListener('click', function(e) {
            const modal = document.getElementById('deleteModal')
            if (e.target === modal) {
                closeDeleteModal()
            }
        })

        function openEditModal(id, name, name_prod, address, telp, email_sup) {
            const modal = document.getElementById('editSupplierModal')
            const form = document.getElementById('editSupplierForm')
            const nameInput = document.getElementById('editSupplierName')
            const productInput = document.getElementById('editSupplierProduct')
            const addressInput = document.getElementById('editSupplierAddress')
            const telpInput = document.getElementById('editSupplierTelp')
            const emailInput = document.getElementById('editSupplierEmail')

            nameInput.value = name
            productInput.value = name_prod
            addressInput.value = address
            telpInput.value = telp
            emailInput.value = email_sup

            form.action = `/supplier/${id}`

            modal.classList.remove('hidden')
        }


        function closeEditModal() {
            document.getElementById('editSupplierModal').classList.add('hidden')
        }

        // Klik luar modal menutup modal
        window.addEventListener('click', function(e) {
            const modal = document.getElementById('editSupplierModal')
            if (e.target === modal) {
                closeEditModal()
            }
        })

        function openAddSupplierModal() {
            document.getElementById('addSupplierModal').classList.remove('hidden')
        }

        function closeAddSupplierModal() {
            document.getElementById('addSupplierModal').classList.add('hidden')
        }

        // Klik luar modal menutup modal
        window.addEventListener('click', function(e) {
            const modal = document.getElementById('addSupplierModal')
            if (e.target === modal) {
                closeAddSupplierModal()
            }
        })
    </script>
@endpush
