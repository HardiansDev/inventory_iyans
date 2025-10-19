@extends('layouts.master')

@section('title')
    <title>HRIS - Pendidikan Pegawai</title>
@endsection

@section('content')
    <section class="mb-6 rounded-lg bg-white dark:bg-gray-800 p-6 shadow-sm">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Data Pendidikan Pegawai</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Daftar seluruh riwayat pendidikan pegawai</p>
            </div>
            <a href="{{ route('education.create') }}"
                class="inline-flex items-center rounded-md bg-yellow-500 px-4 py-2 text-sm font-medium text-white shadow hover:bg-yellow-600">
                <i class="fa fa-plus mr-2"></i> Tambah Pendidikan
            </a>
        </div>
    </section>

    <div class="rounded-lg bg-white dark:bg-gray-800 p-6 shadow-sm">
        <div class="overflow-x-auto rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                <thead class="bg-gray-100 dark:bg-gray-700 uppercase font-medium">
                    <tr>
                        <th class="px-4 py-3 text-left">Pegawai</th>
                        <th class="px-4 py-3 text-left">Jenjang</th>
                        <th class="px-4 py-3 text-left">Institusi</th>
                        <th class="px-4 py-3 text-left">Jurusan</th>
                        <th class="px-4 py-3 text-center">Tahun</th>
                        <th class="px-4 py-3 text-left">GPA</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($educations as $edu)
                        <tr>
                            <td class="px-4 py-2">{{ $edu->employee->name ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $edu->education_level ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $edu->institution_name ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $edu->major ?? '-' }}</td>
                            <td class="px-4 py-2 text-center">
                                {{ $edu->start_year ?? '-' }} - {{ $edu->end_year ?? '-' }}
                            </td>
                            <td class="px-4 py-2">{{ $edu->gpa ?? '-' }}</td>
                            <td class="px-4 py-2 text-center whitespace-nowrap">
                                {{-- TOMBOL DETAIL --}}
                                <a href="{{ route('education.show', $edu->id) }}"
                                    class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-500 inline-flex items-center text-sm mr-2"
                                    title="Lihat Detail">
                                    <i class="fa fa-eye mr-1"></i> Detail
                                </a>

                                {{-- Pemisah (Optional, bisa dihilangkan jika menggunakan tombol ikon) --}}
                                <span class="text-gray-400 dark:text-gray-600">|</span>

                                {{-- TOMBOL EDIT --}}
                                <a href="{{ route('education.edit', $edu->id) }}"
                                    class="text-yellow-500 hover:text-yellow-700 dark:text-yellow-400 dark:hover:text-yellow-500 inline-flex items-center text-sm mx-2"
                                    title="Edit Data">
                                    <i class="fa fa-edit mr-1"></i> Edit
                                </a>

                                <span class="text-gray-400 dark:text-gray-600">|</span>

                                {{-- FORM HAPUS --}}
                                <form action="{{ route('education.destroy', $edu->id) }}" method="POST"
                                    class="inline ml-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-500 inline-flex items-center text-sm"
                                        onclick="return confirm('Yakin ingin menghapus data pendidikan {{ $edu->education_level }} dari {{ $edu->employee->name ?? '' }}?')">
                                        <i class="fa fa-trash-alt mr-1"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-gray-500 dark:text-gray-400">
                                Tidak ada data pendidikan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $educations->links('vendor.pagination.tailwind') }}
        </div>
    </div>
@endsection
