@extends('layouts.master')

@section('title')
    <title>KASIRIN.ID - Edit Pegawai</title>
@endsection

@section('content')
    <!-- Header -->
    <section class="mb-6 rounded-lg bg-white p-6 shadow-sm dark:bg-gray-900 dark:text-gray-100">
        <div class="flex flex-col items-start justify-between gap-2 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Edit Pegawai</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Perbarui informasi pegawai di sistem</p>
            </div>
        </div>
    </section>

    <!-- Form edit -->
    <div class="rounded-lg bg-white p-6 shadow-sm dark:bg-gray-900 dark:text-gray-100">
        <form action="{{ route('employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf
            @method('PUT')

            @include('employees._form')

            <div class="flex gap-2">
                <button type="submit"
                    class="inline-flex items-center rounded bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700">
                    <i class="fa fa-save mr-1"></i> Simpan Perubahan
                </button>
                <a href="{{ route('employees.index') }}"
                    class="inline-flex items-center rounded bg-gray-600 px-4 py-2 text-sm font-medium text-white hover:bg-gray-700 dark:bg-gray-700 dark:hover:bg-gray-600">
                    <i class="fa fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
