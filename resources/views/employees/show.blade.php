@extends('layouts.master')

@section('title')
    <title>Detail Pegawai | Sistem Inventory Iyan</title>
@endsection

@section('content')
    <!-- Header Section -->
    <section class="mb-6 rounded-lg bg-white p-6 shadow-sm">
        <div class="flex flex-col items-start justify-between gap-2 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Detail Pegawai</h1>
                <p class="text-sm text-gray-500">Informasi lengkap tentang pegawai</p>
            </div>
            <nav
                class="text-sm text-gray-600"
                aria-label="Breadcrumb"
            >
                <ol class="flex items-center space-x-2">
                    <li>
                        <a
                            href="{{ route('dashboard') }}"
                            class="flex items-center text-gray-500 hover:text-blue-600"
                        >
                            <i class="fa fa-dashboard mr-1"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <svg
                            class="mx-1 h-4 w-4 text-gray-400"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path d="M6 9a1 1 0 000 2h8a1 1 0 000-2H6z" />
                        </svg>
                    </li>
                    <li>
                        <a
                            href="{{ route('employees.index') }}"
                            class="text-gray-500 hover:text-blue-600"
                        >Pegawai</a>
                    </li>
                    <li>
                        <svg
                            class="mx-1 h-4 w-4 text-gray-400"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path d="M6 9a1 1 0 000 2h8a1 1 0 000-2H6z" />
                        </svg>
                    </li>
                    <li class="text-gray-400">Detail</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Detail Card -->
    <div class="rounded-lg bg-white p-6 shadow-sm">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">NIP</dt>
                        <dd class="text-base text-gray-800">{{ $employee->employee_number ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Nama</dt>
                        <dd class="text-base text-gray-800">{{ $employee->name ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                        <dd class="text-base text-gray-800">{{ $employee->email ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">No. HP</dt>
                        <dd class="text-base text-gray-800">{{ $employee->phone ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Jenis Kelamin</dt>
                        <dd class="text-base text-gray-800">{{ $employee->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Tanggal Lahir</dt>
                        <dd class="text-base text-gray-800">{{ $employee->birth_date ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                        <dd class="text-base text-gray-800">{{ $employee->address ?? '-' }}</dd>
                    </div>
                </dl>
            </div>

            <div class="flex flex-col items-start md:items-center">
                <div class="mb-6 w-full md:w-2/3">
                    <dt class="mb-1 text-sm font-medium text-gray-500">Foto</dt>
                    @if ($employee->photo)
                        <img
                            src="{{ asset('storage/fotoproduct/pegawai/' . $employee->photo) }}"
                            alt="Foto Pegawai"
                            class="max-h-48 w-full rounded-lg border object-cover shadow"
                        />
                    @else
                        <p class="italic text-gray-400">Tidak ada foto</p>
                    @endif
                </div>

                <dl class="w-full space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Departemen</dt>
                        <dd class="text-base text-gray-800">{{ $employee->department->name ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Posisi</dt>
                        <dd class="text-base text-gray-800">{{ $employee->position->name ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="text-base text-gray-800">{{ $employee->status->name ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Tanggal Masuk</dt>
                        <dd class="text-base text-gray-800">{{ $employee->date_joined ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status Aktif</dt>
                        <dd>
                            @if ($employee->is_active)
                                <span
                                    class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-sm text-green-800"
                                >Aktif</span>
                            @else
                                <span
                                    class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-sm text-red-800"
                                >Nonaktif</span>
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-8">
            <a
                href="{{ route('employees.index') }}"
                class="inline-flex items-center rounded-md bg-gray-600 px-4 py-2 text-sm text-white hover:bg-gray-700"
            >
                <i class="fa fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
    </div>
@endsection
