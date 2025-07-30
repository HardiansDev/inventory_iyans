@extends('layouts.master')

@section('title')
    <title>Sistem Inventory Iyan | Absensi Pegawai</title>
@endsection

@section('content')
    <!-- Header Section -->
    <section class="mb-6 rounded-md bg-gray-100 py-4 dark:bg-gray-800">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <h1 class="text-xl font-semibold text-gray-900 dark:text-white">Absensi Pegawai</h1>
                <nav class="text-sm text-gray-500 dark:text-gray-300">
                    <ol class="list-reset flex">
                        <li>
                            <a
                                href="{{ route('dashboard') }}"
                                class="text-blue-600 hover:underline"
                            >Dashboard</a>
                        </li>
                        <li><span class="mx-2">/</span></li>
                        <li class="text-gray-700 dark:text-gray-200">Absensi Pegawai</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="overflow-hidden rounded-lg bg-white shadow-md dark:bg-gray-900">
            <div class="p-6">
                <div class="mb-4">
                    <a
                        href="{{ route('employee-attendance.scan') }}"
                        class="inline-flex items-center rounded bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="mr-2 h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 5h6M9 12h6m-7 7h8"
                            />
                        </svg>
                        Scan QR Absen
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 text-sm dark:border-gray-700">
                        <thead class="bg-gray-100 text-xs uppercase text-gray-700 dark:bg-gray-800 dark:text-gray-200">
                            <tr>
                                <th class="border-b px-4 py-3">No</th>
                                <th class="border-b px-4 py-3">Nama Pegawai</th>
                                <th class="border-b px-4 py-3">NIP</th>
                                <th class="border-b px-4 py-3">Tanggal</th>
                                <th class="border-b px-4 py-3">Check In</th>
                                <th class="border-b px-4 py-3">Check Out</th>
                                <th class="border-b px-4 py-3">Status</th>
                                <th class="border-b px-4 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-900">
                            @foreach ($attendances as $item)
                                <tr>
                                    <td class="px-4 py-3 text-center">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3">{{ $item->employee->name }}</td>
                                    <td class="px-4 py-3">{{ $item->employee->employee_number }}</td>
                                    <td class="px-4 py-3">
                                        {{ \Carbon\Carbon::parse($item->date)->format('d/m/Y') }}
                                    </td>
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
                                            <a
                                                href="{{ route('employee-attendance.scan') }}"
                                                class="inline-block rounded bg-green-600 px-3 py-1 text-xs text-white transition hover:bg-green-700"
                                            >
                                                Absen Pulang
                                            </a>
                                        @else
                                            <span class="text-xs font-medium text-green-600">✓ Selesai</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination (jika tidak pakai datatable) --}}
                {{-- <div class="mt-4">{{ $attendances->links() }}</div> --}}
            </div>
        </div>
    </div>
@endsection
