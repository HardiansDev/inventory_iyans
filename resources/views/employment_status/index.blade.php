@extends('layouts.master')
@section('title')
    <title>KASIRIN.ID - Status Pegawai</title>
@endsection

@section('content')
    <!-- Header -->
    <section class="mb-6 rounded-lg bg-white p-6 shadow-sm dark:bg-gray-800">
        <div class="mx-auto flex max-w-7xl flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Manajemen Status Kepegawaian</h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Kelola data status pekerjaan pegawai di sistem Anda
                </p>
            </div>
        </div>
    </section>

    <!-- Konten -->
    <section class="rounded bg-white p-6 shadow-sm dark:bg-gray-800">
        <div class="mb-4 grid grid-cols-1 gap-4 md:grid-cols-2">
            <div>
                <button onclick="openStatusModal()"
                    class="flex w-full items-center gap-2 rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 md:w-auto">
                    <i class="fas fa-plus-circle"></i>
                    <span>Tambah Status</span>
                </button>
            </div>
        </div>

        <!-- Tabel -->
        <div class="overflow-x-auto rounded-lg border border-gray-200 shadow dark:border-gray-700">
            <table
                class="min-w-full divide-y divide-gray-200 bg-white text-sm text-gray-700 dark:divide-gray-700 dark:bg-gray-800 dark:text-gray-200">
                <thead
                    class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:bg-gray-700 dark:text-gray-300">
                    <tr>
                        <th class="px-4 py-2">Nama Status</th>
                        <th class="px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($statuses as $status)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-4 py-2">{{ $status->name }}</td>
                            <td class="px-4 py-2 text-center">
                                <div class="flex justify-center gap-2">
                                    <button onclick="openEditModal({{ $status->id }}, '{{ $status->name }}')"
                                        class="rounded bg-yellow-400 px-3 py-1 text-sm text-white hover:bg-yellow-500">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button onclick="openDeleteModal({{ $status->id }}, '{{ $status->name }}')"
                                        class="rounded bg-red-500 px-3 py-1 text-sm text-white hover:bg-red-600">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">Tidak ada
                                data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    {{-- Modal Tambah --}}
    <div id="statusModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
        <div class="w-full max-w-md rounded-lg bg-white p-6 shadow-lg dark:bg-gray-800">
            <h2 class="mb-4 text-lg font-semibold text-gray-800 dark:text-white">Tambah Status</h2>
            <form action="{{ route('employment_status.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama
                        Status</label>
                    <input type="text" name="name" id="name" required
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-gray-800 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white" />
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeStatusModal()"
                        class="rounded bg-gray-300 px-4 py-2 text-gray-800 hover:bg-gray-400 dark:bg-gray-600 dark:text-white dark:hover:bg-gray-500">Batal</button>
                    <button type="submit"
                        class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">Tambah</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div id="editStatusModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
        <div class="w-full max-w-md rounded-lg bg-white p-6 shadow-lg dark:bg-gray-800">
            <h2 class="mb-4 text-lg font-semibold text-gray-800 dark:text-white">Edit Status</h2>
            <form id="editStatusForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="editStatusName" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama
                        Status</label>
                    <input type="text" name="name" id="editStatusName" required
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-gray-800 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white" />
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeEditModal()"
                        class="rounded bg-gray-300 px-4 py-2 text-gray-800 hover:bg-gray-400 dark:bg-gray-600 dark:text-white dark:hover:bg-gray-500">Batal</button>
                    <button type="submit"
                        class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Hapus --}}
    <div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
        <div class="w-full max-w-md rounded-lg bg-white p-6 shadow-lg dark:bg-gray-800">
            <h2 class="mb-4 text-lg font-semibold text-gray-800 dark:text-white">Konfirmasi Hapus</h2>
            <p class="mb-6 text-gray-700 dark:text-gray-300">Yakin ingin menghapus status <span id="statusName"
                    class="font-bold"></span>?</p>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeDeleteModal()"
                        class="rounded bg-gray-300 px-4 py-2 text-gray-800 hover:bg-gray-400 dark:bg-gray-600 dark:text-white dark:hover:bg-gray-500">Batal</button>
                    <button type="submit" class="rounded bg-red-600 px-4 py-2 text-white hover:bg-red-700">Hapus</button>
                </div>
            </form>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        function openStatusModal() {
            const modal = document.getElementById('statusModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeStatusModal() {
            const modal = document.getElementById('statusModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        function openEditModal(id, name) {
            const modal = document.getElementById('editStatusModal');
            const form = document.getElementById('editStatusForm');
            const input = document.getElementById('editStatusName');
            form.action = `/employment_status/${id}`;
            input.value = name;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeEditModal() {
            const modal = document.getElementById('editStatusModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        function openDeleteModal(id, name) {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteForm');
            const nameSpan = document.getElementById('statusName');
            form.action = `/employment_status/${id}`;
            nameSpan.textContent = name;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        // Tutup modal saat klik luar
        window.addEventListener('click', function(e) {
            const modals = ['statusModal', 'editStatusModal', 'deleteModal'];
            modals.forEach(id => {
                const modal = document.getElementById(id);
                if (e.target === modal) {
                    modal.classList.remove('flex');
                    modal.classList.add('hidden');
                }
            });
        });
    </script>
@endpush
