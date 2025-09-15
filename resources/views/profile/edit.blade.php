@extends('layouts.master')

@section('title')
    <title>KASIRIN.ID - Edit Profile</title>
@endsection

@section('content')
    <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white text-center">
            Edit Profil
        </h2>
        <form method="POST" action="{{ route('profile.update') }}" class="space-y-5">
            @csrf

            {{-- Nama --}}
            <div>
                <label class="block text-sm font-medium mb-1 dark:text-gray-200">Nama</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                    class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring-2 focus:ring-blue-500
                    dark:bg-gray-700 dark:text-white dark:border-gray-600"
                    required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-sm font-medium mb-1 dark:text-gray-200">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                    class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring-2 focus:ring-blue-500
                    dark:bg-gray-700 dark:text-white dark:border-gray-600"
                    required>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label class="block text-sm font-medium mb-1 dark:text-gray-200">Password (opsional)</label>
                <div class="relative">
                    <input type="password" name="password" id="password"
                        class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring-2 focus:ring-blue-500
                        dark:bg-gray-700 dark:text-white dark:border-gray-600 pr-10">
                    <button type="button" onclick="togglePassword('password', 'togglePasswordIcon')"
                        class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 dark:text-gray-300">
                        <svg id="togglePasswordIcon" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274
                                            4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div>
                <label class="block text-sm font-medium mb-1 dark:text-gray-200">Konfirmasi Password</label>
                <div class="relative">
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring-2 focus:ring-blue-500
                        dark:bg-gray-700 dark:text-white dark:border-gray-600 pr-10">
                    <button type="button" onclick="togglePassword('password_confirmation', 'toggleConfirmIcon')"
                        class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 dark:text-gray-300">
                        <svg id="toggleConfirmIcon" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274
                                            4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow-md transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    {{-- Flowbite Icons --}}
    <script src="https://unpkg.com/flowbite-icons"></script>

    {{-- Toggle Password Script --}}
    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === "password") {
                input.type = "text";
                icon.innerHTML = `
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7
                               0.46-1.466 1.294-2.75 2.373-3.737M9.88 9.88A3 3 0 1114.12 14.12M3 3l18 18" />
                    </svg>
                `;
            } else {
                input.type = "password";
                icon.innerHTML = `
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274
                               4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                `;
            }
        }
    </script>
@endsection
