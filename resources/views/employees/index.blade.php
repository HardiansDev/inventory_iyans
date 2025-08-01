@extends('layouts.master')

@section('title')
    <title>Sistem Inventory Iyan | Pegawai</title>
@endsection

@section('content')
    <!-- Header Section -->
    <section class="mb-6 rounded-lg bg-white p-6 shadow-sm">
        <div class="mx-auto flex max-w-7xl flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Manajemen Pegawai</h1>
                <p class="mt-1 text-sm text-gray-500">Kelola data pegawai dalam sistem Anda</p>
            </div>

        </div>
    </section>

    <!-- Tabel Pegawai -->
    <div class="rounded-lg bg-white p-6 shadow-sm">
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-700">Daftar Pegawai</h2>
            <a href="{{ route('employees.create') }}"
                class="inline-flex items-center rounded-md bg-yellow-500 px-4 py-2 text-sm font-medium text-white shadow hover:bg-yellow-600">
                <i class="fa fa-plus mr-2"></i> Tambah Pegawai
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full table-auto border text-sm text-gray-700">
                <thead class="bg-gray-100 text-left text-xs font-semibold uppercase text-gray-600">
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
                <tbody class="divide-y divide-gray-200">
                    @foreach ($employees as $e)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $e->employee_number }}</td>
                            <td class="px-4 py-2">{{ $e->name }}</td>
                            <td class="px-4 py-2">{{ $e->department->name ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $e->position->name ?? '-' }}</td>
                            <td class="px-4 py-2">
                                <span
                                    class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-800">
                                    {{ $e->status->name ?? '-' }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-center">
                                <a href="{{ route('employees.downloadQr', $e->id) }}"
                                    class="text-blue-600 underline hover:text-blue-800"
                                    title="Download QR {{ $e->name }}">
                                    Download QR
                                </a>
                            </td>
                            <td class="px-4 py-2 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('employees.show', $e->id) }}"
                                        class="rounded bg-blue-500 px-3 py-1 text-xs text-white hover:bg-blue-600">
                                        <i class="fa fa-eye mr-1"></i> Lihat
                                    </a>
                                    <a href="{{ route('employees.edit', $e->id) }}"
                                        class="rounded bg-yellow-500 px-3 py-1 text-xs text-white hover:bg-yellow-600">
                                        <i class="fa fa-edit mr-1"></i> Edit
                                    </a>
                                    <form action="{{ route('employees.destroy', $e->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus pegawai ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="rounded bg-red-500 px-3 py-1 text-xs text-white hover:bg-red-600">
                                            <i class="fa fa-trash mr-1"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{-- {{ $employees->links() }} --}}
        </div>
    </div>
@endsection
