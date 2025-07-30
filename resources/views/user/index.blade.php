@extends('layouts.master')

@section('title')
    <title>Sistem Inventory Iyan | Pengguna</title>
@endsection

@section('content')
    <section class="mb-6 rounded-lg bg-white p-6 shadow-sm">
        <div class="mx-auto flex max-w-7xl flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
            <!-- Title -->
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Manajemen Pengguna</h1>
                <p class="mt-1 text-sm text-gray-500">
                    Kelola data pengguna dalam sistem Anda
                </p>
            </div>

            <!-- Breadcrumb -->
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
                            <i class="fa fa-dashboard mr-1"></i>
                            <span>Dashboard</span>
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
                    <li class="text-gray-400">Pengguna / Role</li>
                </ol>
            </nav>
        </div>
    </section>


    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
        <!-- Form Tambah User (Kiri) -->
        <div class="rounded-lg bg-white p-6 shadow">
            <h2 class="rounded-t bg-blue-600 p-3 text-lg font-semibold text-white">Tambah Pengguna</h2>
            <form
                action="{{ route('user.store') }}"
                method="POST"
                id="userForm"
                class="mt-6 space-y-5"
            >
                @csrf

                {{-- Nama Lengkap --}}
                <div>
                    <label
                        for="name"
                        class="block text-sm font-medium text-gray-700"
                    >
                        Nama Lengkap
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        placeholder="Masukkan Nama Lengkap"
                        required
                        class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                    />
                </div>

                {{-- Email --}}
                <div>
                    <label
                        for="email"
                        class="block text-sm font-medium text-gray-700"
                    >
                        Email
                    </label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        placeholder="Masukkan Email"
                        required
                        class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                    />
                </div>

                {{-- Kata Sandi --}}
                <div>
                    <label
                        for="password"
                        class="block text-sm font-medium text-gray-700"
                    >
                        Kata Sandi
                    </label>
                    <div class="relative mt-1">
                        <input
                            type="password"
                            name="password"
                            id="passwordInput"
                            placeholder="Masukkan Password"
                            required
                            class="w-full rounded-md border border-gray-300 px-3 py-2 pr-10 text-sm shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                        />
                        <button
                            type="button"
                            id="togglePassword"
                            class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500"
                        >
                            <i class="fa fa-eye-slash"></i>
                        </button>
                    </div>
                </div>

                {{-- Role --}}
                <div>
                    <label
                        for="role"
                        class="block text-sm font-medium text-gray-700"
                    >
                        Peran
                    </label>
                    <select
                        name="role"
                        id="role"
                        required
                        class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                    >
                        <option
                            value=""
                            disabled
                            selected
                        >Pilih Peran</option>
                        <option value="superadmin">Super Admin</option>
                        <option value="admin_gudang">Admin Gudang</option>
                        <option value="kasir">Kasir</option>
                        <option value="manager">Manager</option>
                    </select>
                </div>

                {{-- Tombol --}}
                <div class="flex justify-end gap-3 pt-2">
                    <button
                        type="submit"
                        class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700"
                    >
                        <i class="fa fa-plus mr-2"></i> Tambah
                    </button>
                    <button
                        type="button"
                        id="resetButton"
                        class="inline-flex items-center rounded-md bg-gray-300 px-4 py-2 text-sm font-medium text-gray-800 shadow-sm hover:bg-gray-400"
                    >
                        <i class="fa fa-undo mr-2"></i> Reset
                    </button>
                </div>
            </form>

        </div>

        <!-- List Data User (Kanan) -->
        <div class="rounded-lg bg-white p-6 shadow md:col-span-2">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-800">Pengguna / Role</h2>
                <!-- Form Pencarian -->
                <div class="mb-4 flex justify-end">
                    <form
                        action="{{ route('user.index') }}"
                        method="GET"
                        class="flex items-center gap-2"
                    >
                        <input
                            type="search"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Cari user..."
                            class="w-60 rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:w-72"
                        />
                        <button
                            type="submit"
                            class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm text-white shadow-sm hover:bg-blue-700"
                        >
                            <i class="fas fa-search mr-2"></i>
                            Cari
                        </button>
                        <a
                            href="{{ route('user.index') }}"
                            class="ml-2 inline-flex items-center rounded-md bg-gray-300 px-4 py-2 text-sm text-gray-800 shadow-sm hover:bg-gray-400"
                        >
                            <i class="fas fa-redo-alt mr-2"></i>
                            Reset
                        </a>
                    </form>
                </div>

            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full border text-left text-sm text-gray-700">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-4 py-2">No</th>
                            <th class="border px-4 py-2">Email</th>
                            <th class="border px-4 py-2">Nama Lengkap</th>
                            <th class="border px-4 py-2">Peran</th>
                            <th class="border px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $index => $user)
                            <tr class="border-b">
                                <td class="px-4 py-2">{{ $index + $users->firstItem() }}</td>
                                <td class="px-4 py-2">{{ $user->email }}</td>
                                <td class="px-4 py-2">{{ $user->name }}</td>
                                <td class="px-4 py-2">
                                    <span class="inline-block rounded bg-gray-300 px-2 py-1 text-xs text-gray-800">
                                        {{ str_replace('_', ' ', $user->role) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2">
                                    <form
                                        action="{{ route('user.destroy', $user->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="rounded bg-red-500 px-3 py-1 text-sm text-white hover:bg-red-600"
                                        >
                                            <i class="fas fa-trash-alt"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td
                                    colspan="5"
                                    class="py-4 text-center text-gray-500"
                                >Tidak ada data pengguna.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {!! $users->appends(Request::except('page'))->links() !!}
            </div>
        </div>
    </div>

    <script>
        document.getElementById('resetButton').addEventListener('click', function() {
            document.getElementById('userForm').reset();
        });

        document.getElementById('togglePassword').addEventListener('click', function() {
            const input = document.getElementById('passwordInput');
            const icon = this.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        });

        document.getElementById('toggleSearch').addEventListener('click', function() {
            document.getElementById('searchForm').classList.toggle('hidden');
        });
    </script>
@endsection
