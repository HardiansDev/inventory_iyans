@extends('layouts.master')

@section('title')
    <title>Detail Pegawai | Sistem Inventory Iyan</title>
@endsection

@section('content')
    <!-- Header Section -->
    <section class="mb-6 rounded-lg bg-white p-6 shadow-sm dark:bg-gray-800 dark:text-gray-100">
        <div class="flex flex-col items-start justify-between gap-2 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Detail Pegawai</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Informasi lengkap tentang pegawai</p>
            </div>
        </div>
    </section>

    <!-- Detail Card -->
    <div class="rounded-lg bg-white p-6 shadow-sm dark:bg-gray-800 dark:text-gray-100">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">NIP</dt>
                        <dd class="text-base text-gray-800 dark:text-gray-100">{{ $employee->employee_number ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama</dt>
                        <dd class="text-base text-gray-800 dark:text-gray-100">{{ $employee->name ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                        <dd class="text-base text-gray-800 dark:text-gray-100">{{ $employee->email ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">No. HP</dt>
                        <dd class="text-base text-gray-800 dark:text-gray-100">{{ $employee->phone ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Jenis Kelamin</dt>
                        <dd class="text-base text-gray-800 dark:text-gray-100">
                            {{ $employee->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Lahir</dt>
                        <dd class="text-base text-gray-800 dark:text-gray-100">{{ $employee->birth_date ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Alamat</dt>
                        <dd class="text-base text-gray-800 dark:text-gray-100">{{ $employee->address ?? '-' }}</dd>
                    </div>
                </dl>
            </div>

            <div class="flex flex-col items-start md:items-center">
                <div class="mb-6 w-full md:w-2/3">
                    <dt class="mb-1 text-sm font-medium text-gray-500 dark:text-gray-400">Foto</dt>
                    @if ($employee->photo)
                        <img src="{{ $employee->photo }}" alt="Foto Pegawai"
                            class="max-h-48 w-full rounded-lg border border-gray-200 dark:border-gray-600 object-cover shadow" />
                    @else
                        <p class="italic text-gray-400 dark:text-gray-500">Tidak ada foto</p>
                    @endif
                </div>

                <dl class="w-full space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Departemen</dt>
                        <dd class="text-base text-gray-800 dark:text-gray-100">{{ $employee->department->name ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Posisi</dt>
                        <dd class="text-base text-gray-800 dark:text-gray-100">{{ $employee->position->name ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                        <dd class="text-base text-gray-800 dark:text-gray-100">{{ $employee->status->name ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Masuk</dt>
                        <dd class="text-base text-gray-800 dark:text-gray-100">{{ $employee->date_joined ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status Aktif</dt>
                        <dd>
                            @if ($employee->is_active)
                                <span
                                    class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-sm text-green-800 dark:bg-green-900 dark:text-green-200">Aktif</span>
                            @else
                                <span
                                    class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-sm text-red-800 dark:bg-red-900 dark:text-red-200">Nonaktif</span>
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-8">
            <a href="{{ route('employees.index') }}"
                class="inline-flex items-center rounded-md bg-gray-600 px-4 py-2 text-sm text-white hover:bg-gray-700 dark:bg-gray-700 dark:hover:bg-gray-600">
                <i class="fa fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
    </div>
@endsection
