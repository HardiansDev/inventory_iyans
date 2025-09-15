@extends('layouts.master')

@section('title')
    <title>KASIRIN.ID - Tambah Pegawai</title>
@endsection

@section('content')
    <!-- Header -->
    <section class="mb-6 rounded-lg bg-white p-6 shadow-sm dark:bg-gray-800 dark:shadow-lg">
        <div class="flex flex-col items-start justify-between gap-2 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Pegawai</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Tambah informasi pegawai di sistem</p>
            </div>
        </div>
    </section>

    <!-- Form Tambah Pegawai -->
    <div class="mx-auto max-w-4xl px-4">
        <div class="overflow-hidden rounded-lg bg-white shadow-md dark:bg-gray-900 dark:shadow-lg">
            <div class="p-6">
                <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    @include('employees._form')

                    <div class="flex justify-start gap-4">
                        <button type="submit"
                            class="rounded-md bg-green-600 px-4 py-2 text-white transition hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600">
                            Simpan
                        </button>
                        <a href="{{ route('employees.index') }}"
                            class="rounded-md bg-gray-300 px-4 py-2 text-gray-800 transition hover:bg-gray-400
                                   dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
