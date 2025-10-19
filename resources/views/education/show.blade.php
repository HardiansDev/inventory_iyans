@extends('layouts.master')

@section('title')
    <title>HRIS - Detail Pendidikan Pegawai</title>
@endsection

@section('content')
    <section
        class="mb-6 rounded-xl bg-white dark:bg-gray-800 p-6 shadow-lg border-t-4 border-yellow-500 dark:border-yellow-600">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-gray-100">Detail Riwayat Pendidikan</h1>

            </div>
            <div class="flex space-x-3">
                <a href="{{ route('education.edit', $education->id) }}"
                    class="inline-flex items-center rounded-lg bg-yellow-500 px-4 py-2 text-sm font-medium text-white transition hover:bg-yellow-600 shadow-md">
                    <i class="fa fa-edit mr-2"></i> Edit
                </a>
                <a href="{{ route('education.index') }}"
                    class="inline-flex items-center rounded-lg bg-gray-700 px-4 py-2 text-sm font-medium text-white transition hover:bg-gray-800 dark:bg-gray-600 dark:hover:bg-gray-500 shadow-md">
                    <i class="fa fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        </div>
    </section>

    <div class="rounded-xl bg-white dark:bg-gray-800 p-8 shadow-lg">

        <h2
            class="text-xl font-bold text-gray-900 dark:text-gray-100 pb-2 mb-4 border-b border-gray-200 dark:border-gray-700">
            Pegawai Terkait</h2>
        <dl class="space-y-2 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Pegawai</dt>
                    <dd class="text-base font-semibold text-gray-800 dark:text-gray-100">
                        {{ $education->employee->name ?? '-' }}</dd>
                </div>
                <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">NIP</dt>
                    <dd class="text-base font-semibold text-gray-800 dark:text-gray-100">
                        {{ $education->employee->employee_number ?? '-' }}</dd>
                </div>
            </div>
            <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Posisi & Departemen</dt>
                <dd class="text-base text-gray-800 dark:text-gray-100">
                    {{ $education->employee->position->name ?? '-' }} - {{ $education->employee->department->name ?? '-' }}
                </dd>
            </div>
        </dl>

        <h2
            class="text-xl font-bold text-gray-900 dark:text-gray-100 pb-2 mb-4 border-b border-gray-200 dark:border-gray-700">
            Detail Akademik</h2>
        <dl class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="md:col-span-1 p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Jenjang Pendidikan</dt>
                <dd class="text-base text-gray-800 dark:text-gray-100">{{ $education->education_level ?? '-' }}
                </dd>
            </div>

            <div class="md:col-span-2 p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Institusi</dt>
                <dd class="text-base text-gray-800 dark:text-gray-100">{{ $education->institution_name ?? '-' }}
                </dd>
            </div>

            <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Jurusan</dt>
                <dd class="text-base text-gray-800 dark:text-gray-100">{{ $education->major ?? 'Tidak Ada / Umum' }}</dd>
            </div>

            <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tahun Masuk</dt>
                <dd class="text-base text-gray-800 dark:text-gray-100">{{ $education->start_year ?? '-' }}</dd>
            </div>

            <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tahun Lulus</dt>
                <dd class="text-base text-gray-800 dark:text-gray-100">{{ $education->end_year ?? 'Belum Lulus' }}</dd>
            </div>

            <div class="md:col-span-2 p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nomor Ijazah</dt>
                <dd class="text-base text-gray-800 dark:text-gray-100">{{ $education->certificate_number ?? '-' }}</dd>
            </div>

            <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">IPK / Nilai Rata-rata</dt>
                <dd class="text-base text-gray-800 dark:text-gray-100">{{ $education->gpa ?? '-' }}</dd>
            </div>

        </dl>

    </div>
@endsection
