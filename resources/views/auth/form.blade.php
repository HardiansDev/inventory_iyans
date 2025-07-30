<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Sistem Inventory Iyan | Masuk & Daftar</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            body {
                font-family: Arial, sans-serif;
            }
        </style>
    </head>

    <body
        class="flex min-h-screen items-center justify-center bg-gradient-to-br from-blue-400 to-purple-400 px-4"
    >
        <div
            class="relative w-full max-w-md rounded-lg bg-white p-8 shadow-xl transition-all"
            id="form-login"
        >
            <h2 class="mb-6 text-center text-2xl font-bold text-blue-600">Masuk</h2>

            {{-- Pesan --}}
            @if (session('error'))
                <div class="mb-4 rounded bg-red-100 px-4 py-2 text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="mb-4 rounded bg-green-100 px-4 py-2 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="email" class="mb-1 block text-sm font-semibold">Email</label>
                    <input
                        type="email"
                        name="email"
                        class="w-full rounded-full border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                        placeholder="Masukkan email kamu"
                        required
                    />
                </div>
                <div>
                    <label for="password" class="mb-1 block text-sm font-semibold">
                        Kata Sandi
                    </label>
                    <input
                        type="password"
                        name="password"
                        class="w-full rounded-full border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                        placeholder="Masukkan kata sandi kamu"
                        required
                    />
                </div>
                <div>
                    <label for="captcha" class="mb-1 block text-sm font-semibold">
                        Berapa hasil dari: {{ session('captcha_question') }}
                    </label>
                    <input
                        type="text"
                        name="captcha_answer"
                        class="w-full rounded-full border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                        placeholder="Jawaban"
                        required
                    />
                </div>
                <button
                    type="submit"
                    class="w-full rounded-full bg-gradient-to-r from-blue-500 to-purple-500 py-2 font-semibold text-white transition-all hover:from-purple-600 hover:to-blue-600"
                >
                    Masuk
                </button>
            </form>

            <p class="mt-4 text-center text-sm">
                Belum punya akun?
                <a href="#" id="to-register" class="font-semibold text-blue-600 hover:underline">
                    Daftar Yuk
                </a>
            </p>
        </div>

        <div
            class="hidden w-full max-w-md rounded-lg bg-white p-8 shadow-xl transition-all"
            id="form-register"
        >
            <h2 class="mb-6 text-center text-2xl font-bold text-purple-600">Daftar</h2>

            {{-- Validasi --}}
            @if ($errors->any())
                <div class="mb-4 rounded bg-red-100 px-4 py-2 text-red-700">
                    <ul class="list-inside list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="mb-1 block text-sm font-semibold">Nama Lengkap</label>
                    <input
                        type="text"
                        name="name"
                        class="w-full rounded-full border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-purple-400"
                        placeholder="Nama lengkap"
                        required
                    />
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold">Email</label>
                    <input
                        type="email"
                        name="email"
                        class="w-full rounded-full border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-purple-400"
                        placeholder="Email"
                        required
                    />
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold">Peran</label>
                    <select
                        name="role"
                        class="w-full rounded-full border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-purple-400"
                        required
                    >
                        <option disabled selected>Pilih Peran</option>
                        <option value="superadmin">Super Admin</option>
                        <option value="admin_gudang">Admin Gudang</option>
                        <option value="kasir">Kasir</option>
                        <option value="manager">Manager</option>
                    </select>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold">Kata Sandi</label>
                    <input
                        type="password"
                        name="password"
                        class="w-full rounded-full border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-purple-400"
                        placeholder="Password"
                        required
                    />
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold">Konfirmasi Sandi</label>
                    <input
                        type="password"
                        name="password_confirmation"
                        class="w-full rounded-full border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-purple-400"
                        placeholder="Ulangi password"
                        required
                    />
                </div>
                <button
                    type="submit"
                    class="w-full rounded-full bg-gradient-to-r from-purple-500 to-blue-500 py-2 font-semibold text-white transition-all hover:from-blue-600 hover:to-purple-600"
                >
                    Silakan Daftar
                </button>
            </form>

            <p class="mt-4 text-center text-sm">
                Sudah punya akun?
                <a href="#" id="to-login" class="font-semibold text-purple-600 hover:underline">
                    Masuk Yuk
                </a>
            </p>
        </div>

        <script>
            const loginForm = document.getElementById('form-login')
            const registerForm = document.getElementById('form-register')

            document.getElementById('to-register').addEventListener('click', (e) => {
                e.preventDefault()
                loginForm.classList.add('hidden')
                registerForm.classList.remove('hidden')
            })

            document.getElementById('to-login').addEventListener('click', (e) => {
                e.preventDefault()
                registerForm.classList.add('hidden')
                loginForm.classList.remove('hidden')
            })
        </script>
    </body>
</html>
