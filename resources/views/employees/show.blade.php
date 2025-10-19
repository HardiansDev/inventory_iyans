@extends('layouts.master')

@section('title')
    <title>KASIRIN.ID - Detail Pegawai</title>
@endsection

@section('content')
    <!-- Header -->
    <section class="mb-6 rounded-lg bg-white p-6 shadow-sm dark:bg-gray-800 dark:text-gray-100">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Detail Pegawai</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Informasi lengkap tentang pegawai</p>
            </div>
        </div>
    </section>

    <!-- Detail Card -->
    <div class="rounded-lg bg-white p-8 shadow-sm dark:bg-gray-800 dark:text-gray-100">
        <!-- Foto di Tengah -->
        <div class="flex flex-col items-center text-center mb-8">
            <div class="relative w-40 h-40 mb-4">
                @if ($employee->photo)
                    <img src="{{ $employee->photo }}" alt="Foto Pegawai"
                        class="w-40 h-40 rounded-full border border-gray-300 dark:border-gray-600 object-cover shadow-md" />
                @else
                    <div
                        class="flex h-40 w-40 items-center justify-center rounded-full border border-dashed border-gray-400 dark:border-gray-600 text-gray-400 italic">
                        Tidak ada foto
                    </div>
                @endif
            </div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $employee->name ?? 'N/A' }}</h2>
            <p class="text-md text-gray-500 dark:text-gray-400">{{ $employee->position->name ?? 'N/A' }} -
                {{ $employee->department->name ?? 'N/A' }}</p>
        </div>


        <div class="grid grid-cols-4 gap-8">
            <div class="col-span-4 lg:col-span-3">
                <h3
                    class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4 border-b pb-2 border-gray-200 dark:border-gray-700">
                    Data Pekerjaan & Kontak</h3>

                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-6">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Pegawai</dt>
                        <dd class="text-base font-normal text-gray-800 dark:text-gray-100">{{ $employee->name ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">NIP</dt>
                        <dd class="text-base font-normal text-gray-800 dark:text-gray-100">
                            {{ $employee->employee_number ?? '-' }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Posisi</dt>
                        <dd class="text-base font-normal text-gray-800 dark:text-gray-100">
                            {{ $employee->position->name ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Departemen</dt>
                        <dd class="text-base font-normal text-gray-800 dark:text-gray-100">
                            {{ $employee->department->name ?? '-' }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                        <dd class="text-base text-gray-800 dark:text-gray-100">{{ $employee->email ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">No. HP</dt>
                        <dd class="text-base text-gray-800 dark:text-gray-100">{{ $employee->phone ?? '-' }}</dd>
                    </div>

                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Alamat Domisili</dt>
                        <dd class="text-base text-gray-800 dark:text-gray-100 whitespace-pre-wrap text-justify">
                            {{ $employee->address ?? '-' }}
                        </dd>
                    </div>

                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Alamat KTP</dt>
                        <dd class="text-base text-gray-800 dark:text-gray-100 whitespace-pre-wrap text-justify">
                            {{ $employee->address_ktp ?? '-' }}
                        </dd>
                    </div>
                </dl>

                <h3
                    class="text-lg font-semibold text-gray-800 dark:text-gray-100 mt-8 mb-4 border-b pb-2 border-gray-200 dark:border-gray-700">
                    Kontak Darurat</h3>

                <dl class="grid grid-cols-1 sm:grid-cols-3 gap-x-8 gap-y-6">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Kontak Darurat</dt>
                        <dd class="text-base text-gray-800 dark:text-gray-100">
                            {{ $employee->emergency_contact_name ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Hubungan</dt>
                        <dd class="text-base text-gray-800 dark:text-gray-100">
                            {{ $employee->emergency_contact_relation ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">No. Telp Darurat</dt>
                        <dd class="text-base text-gray-800 dark:text-gray-100">
                            {{ $employee->emergency_contact_phone ?? '-' }}</dd>
                    </div>
                </dl>
            </div>

            <div class="col-span-4 lg:col-span-1">
                <h3
                    class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4 border-b pb-2 border-gray-200 dark:border-gray-700">
                    Data Personal & Status</h3>

                <dl class="space-y-6">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tempat, Tanggal Lahir</dt>
                        <dd class="text-base text-gray-800 dark:text-gray-100">
                            {{ ($employee->birth_place ?? '-') . ', ' . ($employee->birth_date ? \Carbon\Carbon::parse($employee->birth_date)->format('d F Y') : '-') }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Umur</dt>
                        <dd class="text-base text-gray-800 dark:text-gray-100">
                            {{ $employee->birth_date ? \Carbon\Carbon::parse($employee->birth_date)->age . ' Tahun' : '-' }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Jenis Kelamin</dt>
                        <dd class="text-base text-gray-800 dark:text-gray-100">
                            @if ($employee->gender == 'L')
                                Laki-laki
                            @elseif ($employee->gender == 'P')
                                Perempuan
                            @else
                                -
                            @endif
                        </dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Agama</dt>
                        <dd class="text-base text-gray-800 dark:text-gray-100">{{ $employee->religion ?? '-' }}</dd>
                    </div>

                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Riwayat Pendidikan</dt>

                        @forelse ($employee->educations as $education)
                            <div
                                class="mb-3 p-3 rounded-lg border border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                                <p class="text-base font-semibold text-gray-800 dark:text-gray-100">
                                    {{ $education->education_level }} - {{ $education->institution_name }}
                                </p>

                                <p class="text-sm text-gray-600 dark:text-gray-300">
                                    {{ $education->major ?? 'Umum' }}
                                    ({{ $education->start_year ?? '?' }} - {{ $education->end_year ?? 'Sekarang' }})
                                </p>

                                @if ($education->gpa)
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">IPK: {{ $education->gpa }}</p>
                                @endif
                            </div>
                        @empty
                            <dd class="text-base text-gray-800 dark:text-gray-100">Tidak ada data pendidikan.</dd>
                        @endforelse

                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status Pernikahan</dt>
                        <dd class="text-base text-gray-800 dark:text-gray-100">{{ $employee->marital_status ?? '-' }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Kewarganegaraan</dt>
                        <dd class="text-base text-gray-800 dark:text-gray-100">{{ $employee->nationals ?? '-' }}</dd>
                    </div>

                    <div class="pt-2 border-t border-gray-200 dark:border-gray-700">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Masuk Kerja</dt>
                        <dd class="text-base text-gray-800 dark:text-gray-100">
                            {{ $employee->date_joined ? \Carbon\Carbon::parse($employee->date_joined)->format('d F Y') : '-' }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status Aktif Kerja</dt>
                        <dd class="text-base text-gray-800 dark:text-gray-100">
                            @if ($employee->is_active)
                                <span
                                    class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-sm text-green-800 dark:bg-green-900 dark:text-green-200 font-semibold">
                                    Aktif
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-sm text-red-800 dark:bg-red-900 dark:text-red-200 font-semibold">
                                    Nonaktif
                                </span>
                            @endif
                        </dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status Kepegawaian</dt>
                        <dd class="text-base text-gray-800 dark:text-gray-100">{{ $employee->status->name ?? '-' }}</dd>
                    </div>


                </dl>
            </div>

        </div>
        <!-- Tombol Kembali -->
        <div class="mt-10 flex justify-center">
            <a href="{{ route('employees.index') }}"
                class="inline-flex items-center rounded-md bg-gray-700 px-4 py-2 text-sm font-medium text-white transition hover:bg-gray-800 dark:bg-gray-600 dark:hover:bg-gray-500">
                <i class="fa fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
    </div>
@endsection
