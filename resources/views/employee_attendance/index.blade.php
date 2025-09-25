@extends('layouts.master')

@section('title')
    <title>KASIRIN.ID - Absensi Pegawai</title>
@endsection

@section('content')
    <!-- Header Section -->
    <section class="mb-6 rounded-lg bg-white p-6 shadow-sm dark:bg-gray-800 dark:shadow-md">
        <div class="mx-auto flex max-w-7xl flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
            <!-- Title -->
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Absensi Pegawai</h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Lihat dan kelola data absensi pegawai secara
                    real-time</p>
            </div>
        </div>
    </section>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8" x-data="{ search: '' }">
        <div class="overflow-hidden rounded-lg bg-white shadow-md dark:bg-gray-900">
            <div class="p-6">
                <!-- Toolbar -->
                <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex gap-2">
                        <!-- Scan QR Absen -->
                        <a href="{{ route('employee-attendance.scan') }}"
                            class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700">
                            <!-- Camera Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h2l2-3h10l2 3h2a2 2 0 012 2v9a2 2 0 01-2
                                             2H3a2 2 0 01-2-2V9a2 2 0 012-2z" />
                                <circle cx="12" cy="13" r="3" />
                            </svg>
                            <span>Scan QR Absen</span>
                        </a>


                        <!-- Export PDF -->
                        <a href="{{ route('employee-attendance.export-pdf') }}"
                            class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-red-700">
                            <i class="fa-solid fa-file-pdf text-lg"></i>
                            <span>Export PDF</span>
                        </a>

                    </div>

                    <!-- Search -->
                    <div class="relative">
                        <input type="text" x-model="search" placeholder="Cari pegawai..."
                            class="block w-full rounded-lg border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200">
                        <svg class="absolute right-3 top-2.5 h-4 w-4 text-gray-400 dark:text-gray-300" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" />
                        </svg>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto rounded-lg shadow">
                    <table class="min-w-full text-sm text-left border-collapse">
                        <thead
                            class="bg-gray-100 text-xs font-semibold uppercase text-gray-700 dark:bg-gray-800 dark:text-gray-200">
                            <tr
                                class="bg-gray-100 text-xs font-semibold uppercase text-gray-700 dark:bg-gray-800 dark:text-gray-200">

                                <th scope="col" class="px-4 py-3 text-left">Nama Pegawai</th>
                                <th scope="col" class="px-4 py-3 text-left">NIP</th>
                                <th scope="col" class="px-4 py-3 text-left">Tanggal</th>
                                <th scope="col" class="px-4 py-3 text-left">Check In</th>
                                <th scope="col" class="px-4 py-3 text-left">Check Out</th>
                                <th scope="col" class="px-4 py-3 text-left">Status</th>
                                <th scope="col" class="px-4 py-3 text-center">Aksi</th>
                            </tr>

                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-900">
                            @foreach ($attendances as $item)
                                <tr
                                    x-show="
                                    search === '' ||
                                    '{{ strtolower($item->employee->name) }}'.includes(search.toLowerCase()) ||
                                    '{{ strtolower($item->employee->employee_number) }}'.includes(search.toLowerCase())
                                ">
                                    <td class="px-4 py-3">{{ $item->employee->name }}</td>
                                    <td class="px-4 py-3">{{ $item->employee->employee_number }}</td>
                                    <td class="px-4 py-3">{{ \Carbon\Carbon::parse($item->date)->format('d/m/Y') }}</td>
                                    <td class="px-4 py-3">{{ $item->check_in ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ $item->check_out ?? '-' }}</td>
                                    <td class="px-4 py-3">
                                        @if ($item->check_in && !$item->check_out)
                                            <span class="font-medium text-yellow-600">Hadir</span>
                                        @elseif ($item->check_in && $item->check_out)
                                            <span class="font-medium text-green-600">Sudah Pulang</span>
                                        @else
                                            <span class="text-gray-500">Belum Absen</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        @if (!$item->check_out)
                                            <a href="{{ route('employee-attendance.scan', ['type' => 'check_out']) }}"
                                                class="inline-block rounded bg-green-600 px-3 py-1 text-xs text-white transition hover:bg-green-700">
                                                Absen Pulang
                                            </a>
                                        @else
                                            <span class="text-xs font-medium text-green-600"> Selesai</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
