@extends('layouts.master')

@section('title')
    <title>Sistem Inventory Iyan | Pegawai</title>
@endsection

@section('content')
    <!-- Header Section -->
    <section class="mb-6 rounded-lg bg-white dark:bg-gray-800 p-6 shadow-sm">
        <div class="mx-auto flex max-w-7xl flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Manajemen Pegawai</h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Kelola data pegawai dalam sistem Anda</p>
            </div>
        </div>
    </section>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('employees.index') }}" class="mb-6">
        <div class="grid grid-cols-1 gap-4 rounded-lg bg-white dark:bg-gray-800 p-6 shadow sm:grid-cols-2 lg:grid-cols-6">
            <!-- Departemen -->
            <div class="col-span-1">
                <label for="department"
                    class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">Departemen</label>
                <select name="department" id="department"
                    class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2 text-sm shadow-sm text-gray-700 dark:text-gray-200 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <option value="">-- Semua Departemen --</option>
                    @foreach ($departments as $dept)
                        <option value="{{ $dept->id }}" {{ request('department') == $dept->id ? 'selected' : '' }}>
                            {{ $dept->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Posisi -->
            <div class="col-span-1">
                <label for="position" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">Posisi</label>
                <select name="position" id="position"
                    class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2 text-sm shadow-sm text-gray-700 dark:text-gray-200 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <option value="">-- Semua Posisi --</option>
                    @foreach ($positions as $pos)
                        <option value="{{ $pos->id }}" {{ request('position') == $pos->id ? 'selected' : '' }}>
                            {{ $pos->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Status -->
            <div class="col-span-1">
                <label for="status" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                <select name="status" id="status"
                    class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2 text-sm shadow-sm text-gray-700 dark:text-gray-200 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <option value="">-- Semua Status --</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status->id }}" {{ request('status') == $status->id ? 'selected' : '' }}>
                            {{ $status->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Search -->
            <div class="col-span-1">
                <label for="search" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">Cari
                    Pegawai</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                    placeholder="Nama / NIP"
                    class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2 text-sm shadow-sm text-gray-700 dark:text-gray-200 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
            </div>

            <!-- Tombol Aksi -->
            <div class="col-span-2 flex items-end justify-start gap-2">
                <button type="submit"
                    class="rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                    Terapkan Filter
                </button>
                <a href="{{ route('employees.index') }}"
                    class="rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 shadow-sm transition hover:bg-gray-100 dark:hover:bg-gray-600">
                    Reset
                </a>
            </div>
        </div>
    </form>

    <!-- Tabel Pegawai -->
    <div class="rounded-lg bg-white dark:bg-gray-800 p-6 shadow-sm">
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Daftar Pegawai</h2>
            <a href="{{ route('employees.create') }}"
                class="inline-flex items-center rounded-md bg-yellow-500 px-4 py-2 text-sm font-medium text-white shadow hover:bg-yellow-600">
                <i class="fa fa-plus mr-2"></i> Tambah Pegawai
            </a>
        </div>

        <div class="overflow-x-auto overflow-y-visible rounded-lg border border-gray-200 dark:border-gray-700 shadow">
            <table
                class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800 text-sm text-gray-700 dark:text-gray-200">
                <thead
                    class="bg-gray-50 dark:bg-gray-700 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">
                    <tr>
                        <th class="px-4 py-3">NIP</th>
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">Departemen</th>
                        <th class="px-4 py-3">Posisi</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-center">QR Code</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach ($employees as $e)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="px-4 py-2">{{ $e->employee_number }}</td>
                            <td class="px-4 py-2">{{ $e->name }}</td>
                            <td class="px-4 py-2">{{ $e->department->name ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $e->position->name ?? '-' }}</td>
                            <td class="px-4 py-2">
                                <span
                                    class="inline-flex items-center rounded-full bg-blue-100 dark:bg-blue-900/40 px-3 py-1 text-xs font-medium text-blue-800 dark:text-blue-300">
                                    {{ $e->status->name ?? '-' }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-center">
                                <a href="{{ route('employees.downloadQr', $e->id) }}"
                                    class="text-blue-600 dark:text-blue-400 underline hover:text-blue-800 dark:hover:text-blue-300"
                                    title="Download QR {{ $e->name }}">
                                    Download QR
                                </a>
                            </td>
                            <td class="relative whitespace-nowrap px-4 py-3">
                                <div x-data="{ open: false }" class="relative inline-block text-left">
                                    <!-- Dropdown Toggle -->
                                    <button @click="open = !open" type="button"
                                        class="inline-flex items-center rounded bg-gray-100 dark:bg-gray-700 px-3 py-1.5 text-xs font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1">
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
                                            <a href="{{ route('employees.show', $e->id) }}"
                                                class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                                                <i class="fas fa-eye mr-2 w-4 text-blue-500"></i>
                                                Detail
                                            </a>
                                            <a href="{{ route('employees.edit', $e->id) }}"
                                                class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                                                <i class="fas fa-edit mr-2 w-4 text-yellow-500"></i>
                                                Edit
                                            </a>

                                            <!-- Tombol trigger modal -->
                                            <button type="button"
                                                onclick="openDeleteModal('{{ route('employees.destroy', $e->id) }}', '{{ $e->name }}')"
                                                class="flex w-full items-center px-4 py-2 text-left text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-600">
                                                <i class="fas fa-trash-alt mr-2 w-4"></i>
                                                Hapus
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Modal Konfirmasi Hapus -->
        <div id="deleteModal"
            class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 dark:bg-opacity-70">
            <div class="w-full max-w-md rounded-lg bg-white dark:bg-gray-800 p-6 shadow-lg">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Konfirmasi Hapus</h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                    Apakah kamu yakin ingin menghapus
                    <span id="itemName" class="font-semibold text-red-600 dark:text-red-400"></span>
                    ?
                </p>
                <form id="deleteForm" method="POST" class="mt-6">
                    @csrf
                    @method('DELETE')
                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="closeDeleteModal()"
                            class="rounded bg-gray-200 dark:bg-gray-600 px-4 py-2 text-sm text-gray-800 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-500">
                            Batal
                        </button>
                        <button type="submit"
                            class="rounded bg-red-600 px-4 py-2 text-sm text-white hover:bg-red-700 dark:hover:bg-red-500">
                            Hapus
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-6">
            {{ $employees->appends(request()->query())->links('vendor.pagination.tailwind') }}
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        // =========================
        // Modal Konfirmasi Hapus
        // =========================
        function openDeleteModal(actionUrl, itemName) {
            const modal = document.getElementById('deleteModal')
            const form = document.getElementById('deleteForm')
            const name = document.getElementById('itemName')

            form.action = actionUrl
            name.textContent = itemName
            modal.classList.remove('hidden')
            modal.classList.add('flex')
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal')
            modal.classList.remove('flex')
            modal.classList.add('hidden')
        }
    </script>
@endpush
