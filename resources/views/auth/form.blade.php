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

<body class="flex min-h-screen items-center justify-center bg-gray-100 px-4">
    <!-- Login Form -->
    <div id="form-login" class="w-full max-w-md rounded-xl bg-white p-8 shadow-lg border border-gray-200 transition-all">
        <h2 class="mb-6 text-center text-2xl font-bold text-gray-800">Masuk</h2>

        @if (session('error'))
            <div class="mb-4 rounded bg-red-50 px-4 py-2 text-red-700 border border-red-200">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="mb-4 rounded bg-green-50 px-4 py-2 text-green-700 border border-green-200">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="mb-1 block text-sm font-semibold text-gray-700">Email</label>
                <input type="email" name="email"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="Contoh: abcd@gmail.com" required />
            </div>
            <div>
                <label for="password" class="mb-1 block text-sm font-semibold text-gray-700">Kata Sandi</label>
                <div class="relative">
                    <input type="password" id="password" name="password"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 pr-10 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        placeholder="********" required />
                    <button type="button"
                        class="toggle-password absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700">
                        <!-- Mata terbuka (default hidden) -->
                        <svg class="eye-open h-5 w-5 hidden" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5
                            c4.477 0 8.268 2.943 9.542 7
                            -1.274 4.057-5.065 7-9.542 7
                            -4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <!-- Mata tertutup (default visible) -->
                        <svg class="eye-closed h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19
                            c-4.477 0-8.268-2.943-9.542-7
                            a10.05 10.05 0 012.913-4.411
                            m3.29-2.028A9.956 9.956 0 0112 5
                            c4.477 0 8.268 2.943 9.542 7
                            a9.96 9.96 0 01-4.133 5.411
                            M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" />
                        </svg>
                    </button>
                </div>
            </div>
            <div>
                <label for="captcha" class="mb-1 block text-sm font-semibold text-gray-700">
                    Berapa hasil dari: {{ session('captcha_question') }}
                </label>
                <input type="text" name="captcha_answer"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="Jawaban" required />
            </div>
            <button type="submit"
                class="w-full rounded-lg bg-blue-600 py-2 font-semibold text-white hover:bg-blue-700 transition">
                Masuk
            </button>
        </form>

        <p class="mt-4 text-center text-sm text-gray-600">
            Belum punya akun?
            <a href="#" id="to-register" class="font-semibold text-blue-600 hover:underline">Daftar Yuk</a>
        </p>
    </div>

    <!-- Register Form -->
    <div id="form-register"
        class="hidden w-full max-w-md rounded-xl bg-white p-8 shadow-lg border border-gray-200 transition-all">
        <h2 class="mb-6 text-center text-2xl font-bold text-gray-800">Daftar</h2>

        @if ($errors->any())
            <div class="mb-4 rounded bg-red-50 px-4 py-2 text-red-700 border border-red-200">
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
                <label class="mb-1 block text-sm font-semibold text-gray-700">Nama Lengkap</label>
                <input type="text" name="name"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-purple-500"
                    placeholder="Nama lengkap" required />
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold text-gray-700">Email</label>
                <input type="email" name="email"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-purple-500"
                    placeholder="Email" required />
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold text-gray-700">Peran</label>
                <select name="role"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-purple-500"
                    required>
                    <option disabled selected>Pilih Peran</option>

                    {{-- Kalau belum ada superadmin, tampilkan --}}
                    @unless ($superadminExists)
                        <option value="superadmin">Super Admin</option>
                    @endunless

                    <option value="admin_gudang">Admin Gudang</option>
                    <option value="kasir">Kasir</option>
                    <option value="manager">Manager</option>
                </select>
            </div>

            <div>
                <label for="password" class="mb-1 block text-sm font-semibold text-gray-700">Kata Sandi</label>
                <div class="relative">
                    <input type="password" id="password" name="password"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 pr-10 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        placeholder="********" required />
                    <button type="button"
                        class="toggle-password absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700">
                        <!-- Mata terbuka (default hidden) -->
                        <svg class="eye-open h-5 w-5 hidden" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5
                            c4.477 0 8.268 2.943 9.542 7
                            -1.274 4.057-5.065 7-9.542 7
                            -4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <!-- Mata tertutup (default visible) -->
                        <svg class="eye-closed h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19
                            c-4.477 0-8.268-2.943-9.542-7
                            a10.05 10.05 0 012.913-4.411
                            m3.29-2.028A9.956 9.956 0 0112 5
                            c4.477 0 8.268 2.943 9.542 7
                            a9.96 9.96 0 01-4.133 5.411
                            M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" />
                        </svg>
                    </button>

                </div>
            </div>

            <div class="mt-4">
                <label for="password_confirmation" class="mb-1 block text-sm font-semibold text-gray-700">Konfirmasi
                    Sandi</label>
                <div class="relative">
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 pr-10 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        placeholder="********" required />
                    <button type="button"
                        class="toggle-password absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700">
                        <!-- Mata terbuka (default hidden) -->
                        <svg class="eye-open h-5 w-5 hidden" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5
                            c4.477 0 8.268 2.943 9.542 7
                            -1.274 4.057-5.065 7-9.542 7
                            -4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <!-- Mata tertutup (default visible) -->
                        <svg class="eye-closed h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19
                            c-4.477 0-8.268-2.943-9.542-7
                            a10.05 10.05 0 012.913-4.411
                            m3.29-2.028A9.956 9.956 0 0112 5
                            c4.477 0 8.268 2.943 9.542 7
                            a9.96 9.96 0 01-4.133 5.411
                            M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" />
                        </svg>
                    </button>
                </div>
            </div>
            <button type="submit"
                class="w-full rounded-lg bg-purple-600 py-2 font-semibold text-white hover:bg-purple-700 transition">
                Silakan Daftar
            </button>
        </form>

        <p class="mt-4 text-center text-sm text-gray-600">
            Sudah punya akun?
            <a href="#" id="to-login" class="font-semibold text-purple-600 hover:underline">Masuk Yuk</a>
        </p>
    </div>

    <script>
        const loginForm = document.getElementById('form-login');
        const registerForm = document.getElementById('form-register');

        document.getElementById('to-register').addEventListener('click', (e) => {
            e.preventDefault();
            loginForm.classList.add('hidden');
            registerForm.classList.remove('hidden');
        });

        document.getElementById('to-login').addEventListener('click', (e) => {
            e.preventDefault();
            registerForm.classList.add('hidden');
            loginForm.classList.remove('hidden');
        });


        document.querySelectorAll('.toggle-password').forEach(btn => {
            btn.addEventListener('click', () => {
                const input = btn.parentElement.querySelector('input');
                const eyeOpen = btn.querySelector('.eye-open');
                const eyeClosed = btn.querySelector('.eye-closed');

                const isHidden = input.type === 'password';
                input.type = isHidden ? 'text' : 'password';

                eyeOpen.classList.toggle('hidden', !isHidden);
                eyeClosed.classList.toggle('hidden', isHidden);
            });
        });
    </script>
</body>

</html>
