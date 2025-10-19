@extends('layouts.master')

@section('title')
    <title>Tambah Pendidikan Pegawai</title>
@endsection

@section('content')
    <!-- Header -->
    <section class="mb-6 rounded-lg bg-white dark:bg-gray-800 p-6 shadow-sm">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Tambah Pendidikan Pegawai</h1>
            <a href="{{ route('education.index') }}"
                class="inline-flex items-center rounded-md bg-gray-700 px-4 py-2 text-sm font-medium text-white transition hover:bg-gray-800 dark:bg-gray-600 dark:hover:bg-gray-500">
                <i class="fa fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
    </section>

    <!-- Form -->
    <div class="rounded-2xl bg-white dark:bg-gray-800 p-8 shadow-md border border-gray-100 dark:border-gray-700">
        <form action="{{ route('education.store') }}" method="POST" class="space-y-8">
            @csrf

            <!-- Section: Data Pegawai -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="employee_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                        Pegawai
                    </label>
                    <select name="employee_id" id="employee_id"
                        class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2 text-sm shadow-sm text-gray-700 dark:text-gray-200 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        <option value="">-- Pilih Pegawai --</option>
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="education_level" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                        Jenjang Pendidikan
                    </label>
                    <select name="education_level" id="education_level"
                        class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2 text-sm shadow-sm text-gray-700 dark:text-gray-200 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        <option value="">-- Pilih Jenjang --</option>
                        <option value="SD">SD</option>
                        <option value="SMP">SMP</option>
                        <option value="SMA/SMK">SMA/SMK</option>
                        <option value="D3">D3</option>
                        <option value="S1">S1</option>
                        <option value="S2">S2</option>
                        <option value="S3">S3</option>
                    </select>
                </div>
            </div>

            <!-- Section: Institusi & Jurusan -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="institution_name"
                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Nama Institusi</label>
                    <input type="text" name="institution_name" id="institution_name"
                        class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2 text-sm shadow-sm text-gray-700 dark:text-gray-200 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        placeholder="Contoh: Universitas Indonesia">
                </div>

                <div>
                    <label for="major"
                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Jurusan</label>
                    <input type="text" name="major" id="major"
                        class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2 text-sm shadow-sm text-gray-700 dark:text-gray-200 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        placeholder="Contoh: Teknik Informatika">
                </div>
            </div>

            <!-- Section: Tahun -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="start_year" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Tahun
                        Masuk</label>
                    <input type="number" name="start_year" id="start_year"
                        class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2 text-sm shadow-sm text-gray-700 dark:text-gray-200 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        placeholder="Contoh: 2015">
                </div>

                <div>
                    <label for="end_year" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Tahun
                        Lulus</label>
                    <input type="number" name="end_year" id="end_year"
                        class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2 text-sm shadow-sm text-gray-700 dark:text-gray-200 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        placeholder="Contoh: 2019">
                </div>
            </div>

            <!-- Section: Ijazah & IPK -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="certificate_number"
                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Nomor Ijazah</label>
                    <input type="text" name="certificate_number" id="certificate_number"
                        class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2 text-sm shadow-sm text-gray-700 dark:text-gray-200 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        placeholder="Contoh: 1234-ABC-5678">
                </div>

                <div>
                    <label for="gpa"
                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">IPK</label>
                    <input type="text" name="gpa" id="gpa"
                        class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2 text-sm shadow-sm text-gray-700 dark:text-gray-200 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        placeholder="Contoh: 3.85">
                </div>
            </div>

            <!-- Submit -->
            <div class="flex justify-end border-t border-gray-200 dark:border-gray-700 pt-6">
                <button type="submit"
                    class="rounded-lg bg-yellow-500 px-6 py-2 text-sm font-semibold text-white shadow-md hover:bg-yellow-600 focus:ring-4 focus:ring-yellow-300 dark:focus:ring-yellow-700 transition">
                    <i class="fa fa-save mr-2"></i> Simpan
                </button>
            </div>
        </form>
    </div>
@endsection
