@extends('layouts.master')

@section('title')
    <title>Sistem Inventory Iyan | Pengguna</title>
@endsection

@section('content')
    <section class="mb-6 rounded-lg bg-white p-6 shadow-sm dark:bg-gray-800 dark:text-gray-100">
        <div class="mx-auto flex max-w-7xl flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Manajemen Pengguna</h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Kelola data pengguna dalam sistem Anda</p>
            </div>
        </div>
    </section>

    <div class="rounded-lg bg-white p-6 shadow dark:bg-gray-800 dark:text-gray-100">
        <!-- Header dengan tombol dan search -->
        <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <button onclick="openUserModal()"
                class="flex items-center justify-center gap-2 rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
                <i class="fa fa-plus"></i> Tambah Pengguna
            </button>

            <form action="{{ route('user.index') }}" method="GET" class="flex flex-col gap-2 sm:flex-row sm:items-center">
                <input type="search" name="search" value="{{ $search }}" placeholder="Cari user..."
                    class="w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 shadow-sm
                       focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700
                       dark:text-gray-100 dark:placeholder-gray-400 sm:w-72" />
                <div class="flex gap-2">
                    <button type="submit"
                        class="flex flex-1 items-center justify-center rounded-md bg-blue-600 px-4 py-2 text-sm text-white shadow-sm hover:bg-blue-700 sm:flex-none">
                        <i class="fas fa-search mr-2"></i> Cari
                    </button>
                    <a href="{{ route('user.index') }}"
                        class="flex flex-1 items-center justify-center rounded-md bg-gray-300 px-4 py-2 text-sm text-gray-800 shadow-sm hover:bg-gray-400
                           dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 sm:flex-none">
                        <i class="fas fa-redo-alt mr-2"></i> Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full border text-left text-sm text-gray-700 dark:text-gray-200 dark:border-gray-600">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="border px-4 py-2 dark:border-gray-600">No</th>
                        <th class="border px-4 py-2 dark:border-gray-600">Email</th>
                        <th class="border px-4 py-2 dark:border-gray-600">Nama Lengkap</th>
                        <th class="border px-4 py-2 dark:border-gray-600">Peran</th>
                        <th class="border px-4 py-2 dark:border-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $index => $user)
                        <tr class="border-b hover:bg-gray-50 dark:hover:bg-gray-700 dark:border-gray-600">
                            <td class="px-4 py-2">{{ $index + $users->firstItem() }}</td>
                            <td class="px-4 py-2">{{ $user->email }}</td>
                            <td class="px-4 py-2">{{ $user->name }}</td>
                            <td class="px-4 py-2">
                                <span
                                    class="inline-block rounded bg-gray-300 px-2 py-1 text-xs text-gray-800
                                         dark:bg-gray-600 dark:text-gray-100">
                                    {{ str_replace('_', ' ', $user->role) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">
                                <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="rounded bg-red-500 px-3 py-1 text-sm text-white hover:bg-red-600">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-4 text-center text-gray-500 dark:text-gray-400">Tidak ada data
                                pengguna.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {!! $users->appends(Request::except('page'))->links() !!}
        </div>
    </div>

    <!-- Modal -->
    <div id="userModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
        <div class="w-full max-w-lg rounded-lg bg-white p-6 shadow-lg dark:bg-gray-800 dark:text-gray-100">
            <div class="flex items-center justify-between border-b pb-3 dark:border-gray-600">
                <h2 class="text-lg font-bold text-gray-800 dark:text-gray-100">Tambah Pengguna</h2>
                <button onclick="closeUserModal()"
                    class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                    <i class="fa fa-times"></i>
                </button>
            </div>

            <form action="{{ route('user.store') }}" method="POST" id="userForm" class="mt-6 space-y-5">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama
                        Lengkap</label>
                    <input type="text" name="name" id="name" required
                        class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm
                           focus:border-blue-500 focus:ring focus:ring-blue-200
                           dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100" />
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                    <input type="email" name="email" id="email" required
                        class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm
                           focus:border-blue-500 focus:ring focus:ring-blue-200
                           dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100" />
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kata
                        Sandi</label>
                    <div class="relative mt-1">
                        <input type="password" name="password" id="passwordInput" required
                            class="w-full rounded-md border border-gray-300 px-3 py-2 pr-10 text-sm shadow-sm
                               focus:border-blue-500 focus:ring focus:ring-blue-200
                               dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100" />
                        <button type="button" id="togglePassword"
                            class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 dark:text-gray-400">
                            <i class="fa fa-eye-slash"></i>
                        </button>
                    </div>
                </div>
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Peran</label>
                    <select name="role" id="role" required
                        class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm
                           focus:border-blue-500 focus:ring focus:ring-blue-200
                           dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100">
                        <option value="" disabled selected>Pilih Peran</option>
                        <option value="superadmin">Super Admin</option>
                        <option value="admin_gudang">Admin Gudang</option>
                        <option value="kasir">Kasir</option>
                        <option value="manager">Manager</option>
                    </select>
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <button type="submit"
                        class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700">
                        <i class="fa fa-plus mr-2"></i> Tambah
                    </button>
                    <button type="button" onclick="closeUserModal()"
                        class="inline-flex items-center rounded-md bg-gray-300 px-4 py-2 text-sm font-medium text-gray-800 shadow-sm hover:bg-gray-400
                           dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                        <i class="fa fa-times mr-2"></i> Batal
                    </button>
                </div>
            </form>
        </div>
    </div>


    <script>
        function openUserModal() {
            document.getElementById('userModal').classList.remove('hidden');
            document.getElementById('userModal').classList.add('flex');
        }

        function closeUserModal() {
            document.getElementById('userModal').classList.add('hidden');
            document.getElementById('userModal').classList.remove('flex');
        }
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
    </script>
@endsection
