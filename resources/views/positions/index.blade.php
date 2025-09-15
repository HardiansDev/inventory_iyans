@extends('layouts.master')
@section('title')
    <title>KASIRIN.ID - Jabatan</title>
@endsection

@section('content')
    <section class="mb-6 rounded-lg bg-white p-6 shadow-sm dark:bg-gray-800 dark:text-gray-100">
        <div class="mx-auto max-w-7xl flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Manajemen Jabatan Pegawai</h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">Kelola data jabatan dan gaji pokok pegawai</p>
            </div>
        </div>
    </section>

    <section class="rounded bg-white p-6 shadow-sm dark:bg-gray-800 dark:text-gray-100">
        <div class="mb-4">
            <button onclick="openPositionModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                <i class="fas fa-plus-circle"></i> Tambah Jabatan
            </button>
        </div>

        <div class="overflow-x-auto rounded-lg border border-gray-200 shadow dark:border-gray-700">
            <table
                class="min-w-full divide-y divide-gray-200 bg-white text-sm text-gray-700 dark:bg-gray-900 dark:text-gray-200 dark:divide-gray-700">
                <thead
                    class="bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider dark:bg-gray-700 dark:text-gray-300">
                    <tr>
                        <th class="px-4 py-2">Nama Jabatan</th>
                        <th class="px-4 py-2">Gaji Pokok</th>
                        <th class="px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($positions as $position)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-4 py-2">{{ $position->name }}</td>
                            <td class="px-4 py-2">Rp {{ number_format($position->base_salary, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 text-center">
                                <div class="flex justify-center gap-2">
                                    <button
                                        onclick="openEditModal({{ $position->id }}, '{{ $position->name }}', '{{ $position->base_salary }}')"
                                        class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button onclick="openDeleteModal({{ $position->id }}, '{{ $position->name }}')"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">Tidak ada
                                data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    {{-- Modal Tambah --}}
    <div id="positionModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
        <div class="w-full max-w-md rounded-lg bg-white p-6 shadow-lg dark:bg-gray-800 dark:text-gray-100">
            <h2 class="mb-4 text-lg font-semibold">Tambah Jabatan</h2>
            <form action="{{ route('position.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama
                        Jabatan</label>
                    <input type="text" name="name" required
                        class="w-full mt-1 px-3 py-2 border rounded focus:ring focus:border-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-200" />
                </div>
                <div class="mb-4">
                    <label for="base_salary" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Gaji
                        Pokok</label>
                    <input type="number" name="base_salary" required
                        class="w-full mt-1 px-3 py-2 border rounded focus:ring focus:border-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-200" />
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closePositionModal()"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-gray-200 px-4 py-2 rounded">Batal</button>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Tambah</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div id="editPositionModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
        <div class="w-full max-w-md rounded-lg bg-white p-6 shadow-lg dark:bg-gray-800 dark:text-gray-100">
            <h2 class="mb-4 text-lg font-semibold">Edit Jabatan</h2>
            <form id="editPositionForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Jabatan</label>
                    <input type="text" name="name" id="editPositionName" required
                        class="w-full mt-1 px-3 py-2 border rounded dark:bg-gray-900 dark:border-gray-700 dark:text-gray-200" />
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Gaji Pokok</label>
                    <input type="number" name="base_salary" id="editPositionSalary" required
                        class="w-full mt-1 px-3 py-2 border rounded dark:bg-gray-900 dark:border-gray-700 dark:text-gray-200" />
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeEditModal()"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-gray-200 px-4 py-2 rounded">Batal</button>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Hapus --}}
    <div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
        <div class="w-full max-w-md rounded-lg bg-white p-6 shadow-lg dark:bg-gray-800 dark:text-gray-100">
            <h2 class="mb-4 text-lg font-semibold">Konfirmasi Hapus</h2>
            <p class="mb-6">Yakin ingin menghapus jabatan <span id="positionName" class="font-bold"></span>?</p>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeDeleteModal()"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-gray-200 px-4 py-2 rounded">Batal</button>
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">Hapus</button>
                </div>
            </form>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        function openPositionModal() {
            document.getElementById('positionModal').classList.remove('hidden');
            document.getElementById('positionModal').classList.add('flex');
        }

        function closePositionModal() {
            document.getElementById('positionModal').classList.remove('flex');
            document.getElementById('positionModal').classList.add('hidden');
        }

        function openEditModal(id, name, salary) {
            document.getElementById('editPositionForm').action = `/position/${id}`;
            document.getElementById('editPositionName').value = name;
            document.getElementById('editPositionSalary').value = salary;
            document.getElementById('editPositionModal').classList.remove('hidden');
            document.getElementById('editPositionModal').classList.add('flex');
        }

        function closeEditModal() {
            document.getElementById('editPositionModal').classList.remove('flex');
            document.getElementById('editPositionModal').classList.add('hidden');
        }

        function openDeleteModal(id, name) {
            document.getElementById('deleteForm').action = `/position/${id}`;
            document.getElementById('positionName').textContent = name;
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteModal').classList.add('flex');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('flex');
            document.getElementById('deleteModal').classList.add('hidden');
        }

        window.addEventListener('click', function(e) {
            ['positionModal', 'editPositionModal', 'deleteModal'].forEach(id => {
                const modal = document.getElementById(id);
                if (e.target === modal) {
                    modal.classList.remove('flex');
                    modal.classList.add('hidden');
                }
            });
        });
    </script>
@endpush
