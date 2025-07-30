@extends('layouts.master')

@section('title')
    <title>Edit Pegawai | Sistem Inventory Iyan</title>
@endsection

@section('content')
    <!-- Header -->
    <section class="mb-6 rounded-lg bg-white p-6 shadow-sm">
        <div class="flex flex-col items-start justify-between gap-2 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Edit Pegawai</h1>
                <p class="text-sm text-gray-500">Perbarui informasi pegawai di sistem</p>
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
                    <li class="text-gray-400">Edit</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Form -->
    <div class="rounded-lg bg-white p-6 shadow-sm">
        <form
            action="{{ route('employees.update', $employee->id) }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-6"
        >
            @csrf
            @method('PUT')

            @include('employees._form')

            <div class="flex gap-2">
                <button
                    type="submit"
                    class="inline-flex items-center rounded bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700"
                >
                    <i class="fa fa-save mr-1"></i> Simpan Perubahan
                </button>
                <a
                    href="{{ route('employees.index') }}"
                    class="inline-flex items-center rounded bg-gray-600 px-4 py-2 text-sm font-medium text-white hover:bg-gray-700"
                >
                    <i class="fa fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
