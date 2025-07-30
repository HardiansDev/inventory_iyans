@extends('layouts.master')

@section('title')
    <title>Tambah Pegawai | Sistem Inventory Iyan</title>
@endsection

@section('content')
    <!-- Header Section -->
    <section class="mb-6 rounded-md bg-gray-100 py-4 dark:bg-gray-800">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <h1 class="text-xl font-semibold text-gray-900 dark:text-white">Tambah Pegawai</h1>
                <nav class="text-sm text-gray-500 dark:text-gray-300">
                    <ol class="list-reset flex">
                        <li>
                            <a
                                href="{{ route('dashboard') }}"
                                class="text-blue-600 hover:underline"
                            >Dashboard</a>
                        </li>
                        <li><span class="mx-2">/</span></li>
                        <li>
                            <a
                                href="{{ route('employees.index') }}"
                                class="text-blue-600 hover:underline"
                            >Pegawai</a>
                        </li>
                        <li><span class="mx-2">/</span></li>
                        <li class="text-gray-700 dark:text-gray-200">Tambah</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>

    <!-- Form Tambah Pegawai -->
    <div class="mx-auto max-w-4xl px-4">
        <div class="overflow-hidden rounded-lg bg-white shadow-md dark:bg-gray-900">
            <div class="p-6">
                <form
                    action="{{ route('employees.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="space-y-6"
                >
                    @csrf

                    @include('employees._form')

                    <div class="flex justify-start gap-4">
                        <button
                            type="submit"
                            class="rounded-md bg-green-600 px-4 py-2 text-white transition hover:bg-green-700"
                        >
                            Simpan
                        </button>
                        <a
                            href="{{ route('employees.index') }}"
                            class="rounded-md bg-gray-300 px-4 py-2 text-gray-800 transition hover:bg-gray-400"
                        >
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
