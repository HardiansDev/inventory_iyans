@extends('layouts.master')

@section('title')
    <title>Sistem Inventory Iyan | Supplier</title>
@endsection

@section('content')
    <!-- Header -->
    <section class="mb-6 rounded-lg bg-white p-6 shadow-sm">
        <div class="mx-auto flex max-w-7xl flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Manajemen Supplier</h1>
                <p class="mt-1 text-sm text-gray-500">
                    Kelola data supplier dalam sistem inventory Anda
                </p>
            </div>


        </div>
    </section>

    <!-- Konten -->
    <section class="rounded bg-white p-6 shadow-sm">
        <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-2">
            <!-- Tombol Trigger Modal Tambah -->
            <div class="flex md:justify-start">
                <button onclick="openAddSupplierModal()"
                    class="flex w-full items-center justify-center gap-2 rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 md:w-auto">
                    <i class="fas fa-plus-circle"></i>
                    <span>Tambah Supplier</span>
                </button>
            </div>

            <!-- Form Pencarian Supplier -->
            <div class="flex md:justify-end">
                <form action="{{ route('supplier.index') }}" method="GET"
                    class="flex w-full flex-col items-stretch gap-2 sm:flex-row sm:items-center sm:gap-2 md:w-auto">
                    <input type="search" name="search" value="{{ $search }}" placeholder="Cari..."
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:w-72" />
                    <div class="flex gap-2">
                        <button type="submit"
                            class="flex flex-1 items-center justify-center rounded-md bg-blue-600 px-4 py-2 text-sm text-white shadow-sm hover:bg-blue-700 sm:flex-none">
                            <i class="fas fa-search mr-2"></i>
                            Cari
                        </button>
                        <a href="{{ route('supplier.index') }}"
                            class="flex flex-1 items-center justify-center rounded-md bg-gray-300 px-4 py-2 text-sm text-gray-800 shadow-sm hover:bg-gray-400 sm:flex-none">
                            <i class="fas fa-redo-alt mr-2"></i>
                            Reset
                        </a>
                    </div>

                </form>
            </div>
        </div>


        <!-- Tabel Data -->
        <div class="overflow-x-auto rounded-lg border border-gray-200 shadow">
            <table id="example1" class="min-w-full divide-y divide-gray-200 bg-white text-sm text-gray-700">
                <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                    <tr>
                        {{-- <th class="px-4 py-2 border">No</th> --}}
                        <th class="px-4 py-2">Nama Supplier</th>
                        <th class="px-4 py-2">Alamat</th>
                        <th class="px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($suppliers as $index => $item)
                        <tr class="hover:bg-gray-50">
                            {{-- <td class="px-4 py-2 ">{{ $index + $suppliers->firstItem() }}</td> --}}
                            <td class="px-4 py-2">{{ $item->name }}</td>
                            <td class="px-4 py-2">{{ $item->address }}</td>
                            <td class="px-4 py-2 text-center">
                                <div class="flex justify-center gap-2">
                                    <!-- Tombol Edit (di bagian tabel) -->
                                    <button type="button"
                                        onclick="openEditModal({{ $item->id }}, '{{ $item->name }}', '{{ $item->address }}')"
                                        class="rounded bg-yellow-400 px-3 py-1 text-sm text-white hover:bg-yellow-500">
                                        <i class="fas fa-edit"></i>
                                        Edit
                                    </button>

                                    <button type="button"
                                        onclick="openDeleteModal({{ $item->id }}, '{{ $item->name }}')"
                                        class="rounded bg-red-500 px-3 py-1 text-sm text-white hover:bg-red-600">
                                        <i class="fas fa-trash-alt"></i>
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                                Data Supplier tidak ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <!-- Modal Tambah Supplier -->
            <div id="addSupplierModal"
                class="fixed inset-0 z-50 flex hidden items-center justify-center bg-black bg-opacity-50">
                <div class="w-full max-w-lg rounded-lg bg-white p-6 shadow-lg">
                    <h2 class="mb-4 text-lg font-semibold text-gray-800">Tambah Supplier</h2>
                    <form action="{{ route('supplier.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="addSupplierName" class="block text-sm font-medium text-gray-700">
                                Nama Supplier
                            </label>
                            <input type="text" name="name" id="addSupplierName"
                                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-blue-500"
                                placeholder="Nama Supplier" required />
                        </div>
                        <div class="mb-4">
                            <label for="addSupplierAddress" class="block text-sm font-medium text-gray-700">
                                Alamat Supplier
                            </label>
                            <textarea type="text" name="address" id="addSupplierAddress"
                                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-blue-500"
                                placeholder="Alamat Supplier" required></textarea>
                        </div>
                        <div class="flex justify-end gap-2">
                            <button type="button" onclick="closeAddSupplierModal()"
                                class="rounded bg-gray-300 px-4 py-2 text-gray-800 hover:bg-gray-400">
                                Batal
                            </button>
                            <button type="submit" class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Edit Supplier -->
            <div id="editSupplierModal"
                class="fixed inset-0 z-50 flex hidden items-center justify-center bg-black bg-opacity-50">
                <div class="w-full max-w-lg rounded-lg bg-white p-6 shadow-lg">
                    <h2 class="mb-4 text-lg font-semibold text-gray-800">Edit Supplier</h2>
                    <form id="editSupplierForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="editSupplierName" class="block text-sm font-medium text-gray-700">
                                Nama Supplier
                            </label>
                            <input type="text" name="name" id="editSupplierName"
                                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-blue-500"
                                required />
                        </div>
                        <div class="mb-4">
                            <label for="editSupplierAddress" class="block text-sm font-medium text-gray-700">
                                Alamat Supplier
                            </label>
                            <textarea type="text" name="address" id="editSupplierAddress"
                                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-blue-500"
                                required></textarea>
                        </div>
                        <div class="flex justify-end gap-2">
                            <button type="button" onclick="closeEditModal()"
                                class="rounded bg-gray-300 px-4 py-2 text-gray-800 hover:bg-gray-400">
                                Batal
                            </button>
                            <button type="submit" class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
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
        <div class="w-full max-w-md rounded-lg bg-white p-6 shadow-lg">
            <h2 class="mb-4 text-lg font-semibold text-gray-800">Konfirmasi Hapus</h2>
            <p class="mb-6 text-gray-700">
                Yakin ingin menghapus supplier
                <span id="supplierName" class="font-bold"></span>
                ?
            </p>

            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeDeleteModal()"
                        class="rounded bg-gray-300 px-4 py-2 text-gray-800 hover:bg-gray-400">
                        Batal
                    </button>
                    <button type="submit" class="rounded bg-red-600 px-4 py-2 text-white hover:bg-red-700">
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

        function openEditModal(id, name, address) {
            const modal = document.getElementById('editSupplierModal')
            const form = document.getElementById('editSupplierForm')
            const nameInput = document.getElementById('editSupplierName')
            const addressInput = document.getElementById('editSupplierAddress')

            nameInput.value = name
            addressInput.value = address
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
