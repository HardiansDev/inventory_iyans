<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('title')
    <script src="https://cdn.tailwindcss.com"></script>







    {{-- Chart.js (hanya sekali) --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- Flowbite (cukup satu versi stabil terbaru) --}}
    <script src="https://unpkg.com/flowbite@latest/dist/flowbite.min.js"></script>

    {{-- html2pdf (untuk export PDF) --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

    {{-- XLSX (untuk export Excel) --}}
    <script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>

    {{-- Alpine.js (untuk interaktifitas ringan) --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>


    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />

    <style>
        [x-cloak] {
            display: none !important;
        }

        @media (min-width: 768px) {
            html.sidebar-collapsed #sidebar {
                transform: translateX(-15rem);
                /* hidden sidebar */
            }
        }

        @media (max-width: 767px) {
            #sidebar {
                transform: translateX(-15rem);
                z-index: 60 !important;
                /* hidden by default */
            }

            html.sidebar-open-mobile #sidebar {
                transform: translateX(0);
            }
        }
    </style>

</head>

<body x-data class="bg-gray-100 text-gray-800" style="font-family: 'Poppins', sans-serif;">
    <nav id="navbar"
        class="fixed top-0 z-50 h-16 flex items-center justify-between bg-white px-4 shadow-md transition-all duration-300"
        style="left: 15rem; right: 0;">
        <button id="sidebar-toggle" class="p-2 text-gray-700 hover:text-gray-900">
            <i id="sidebar-icon" class="fas fa-bars-staggered text-lg transition-all duration-300"></i>
        </button>


        <div class="flex items-center space-x-4 ml-auto">

            {{-- Notifikasi untuk Superadmin --}}
            @if (Auth::user()->role === 'superadmin')
                <div class="relative">
                    <button id="notifBtn" class="relative p-2 text-gray-800 focus:outline-none dark:text-white">
                        <i class="fas fa-bell text-lg"></i>
                        @php
                            $pendingRequests = \App\Models\ProductIn::where('status', 'menunggu')->count();
                        @endphp
                        @if ($pendingRequests > 0)
                            <span
                                class="absolute -right-1 -top-1 h-4 w-4 flex items-center justify-center rounded-full bg-red-500 text-xs text-white">
                                {{ $pendingRequests }}
                            </span>
                        @endif
                    </button>

                    {{-- Dropdown Notifikasi --}}
                    <div id="notificationMenu"
                        class="absolute right-0 mt-2 hidden w-64 rounded-md bg-white dark:bg-gray-800 shadow-lg z-[60]">
                        <div class="py-2 text-sm text-gray-700  max-h-72 overflow-y-auto">
                            @if ($pendingRequests > 0)
                                @foreach (\App\Models\ProductIn::where('status', 'menunggu')->latest()->take(5)->get() as $notif)
                                    <a href="{{ route('product.confirmation', $notif->id) }}"
                                        class="block border-b dark:border-gray-700 px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        Permintaan: <strong>{{ $notif->requester_name }}</strong><br>
                                        Produk: <strong>{{ $notif->product->name ?? '-' }}</strong><br>
                                        <small
                                            class="text-gray-500 dark:text-gray-400">{{ $notif->created_at->diffForHumans() }}</small>
                                    </a>
                                @endforeach
                            @else
                                <p class="px-4 py-2 text-gray-500 dark:text-gray-400">Tidak ada notifikasi.</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            {{-- User Menu --}}
            <div class="relative inline-block text-left">
                <button id="userMenuButton" class="flex items-center text-sm focus:outline-none">
                    <i class="fas fa-user-circle text-2xl text-gray-600 "></i>
                    <span class="ml-2 dark:text-white">{{ Auth::user()->name }}</span>
                </button>

                {{-- Dropdown User --}}
                <div id="userMenu" class="absolute right-0 mt-2 hidden w-48 rounded-md bg-white shadow-lg z-50">
                    <a href="#" @click.prevent="$dispatch('open-logout-modal')"
                        class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:text-red-400 dark:hover:bg-gray-700">
                        <i class="fas fa-power-off mr-2"></i> Keluar
                    </a>
                </div>
            </div>
        </div>
    </nav>


    @include('layouts.module.sidebar')


    <div x-data="{ show: false }" @open-logout-modal.window="show = true" x-show="show" x-transition x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">

        <div @click.away="show = false" class="w-full max-w-md rounded-lg bg-white p-6 shadow-lg">
            <h2 class="mb-4 text-lg font-semibold text-gray-800 ">Konfirmasi Logout</h2>
            <p class="mb-6 text-gray-600 dark:text-gray-400">Apakah Anda yakin ingin keluar dari akun?</p>
            <div class="flex justify-end space-x-4">
                <button @click="show = false"
                    class="rounded bg-gray-200 px-4 py-2 text-sm text-gray-700 hover:bg-gray-300 ">
                    Batal
                </button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="rounded bg-red-600 px-4 py-2 text-sm text-white hover:bg-red-700">
                        Ya, Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <main id="mainContent" class="min-h-[calc(100vh-4rem)] pt-24 px-4 pb-24 transition-all duration-300">
        @yield('content')
    </main>

    @include('layouts.module.footer')
    @if (session('success') || session('error') || session('info') || session('warning'))
        <div x-data="{ show: true, type: '{{ session('success') ? 'success' : (session('error') ? 'error' : (session('warning') ? 'warning' : 'info')) }}' }" x-show="show" x-init="setTimeout(() => (show = false), 4000)" x-transition x-cloak
            :class="{
                'bg-green-500 text-white': type === 'success',
                'bg-red-500 text-white': type === 'error',
                'bg-yellow-500 text-black': type === 'warning',
                'bg-blue-500 text-white': type === 'info'
            }"
            class="fixed right-5 top-5 z-[9999] w-full max-w-xs rounded-md px-4 py-3 shadow-lg" role="alert">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <i
                        :class="{
                            'fas fa-check-circle': type === 'success',
                            'fas fa-exclamation-circle': type === 'error',
                            'fas fa-exclamation-triangle': type === 'warning',
                            'fas fa-info-circle': type === 'info'
                        }"></i>
                    <span class="text-sm">
                        {{ session('success') ?? (session('error') ?? (session('warning') ?? session('info'))) }}
                    </span>
                </div>
                <button @click="show = false" class="text-white hover:opacity-70">&times;</button>
            </div>
        </div>
    @endif


    <div x-data="{ show: false, message: '', type: 'info', timeout: null }" x-show="show" x-transition x-cloak x-init="window.addEventListener('notify', e => {
        message = e.detail.message;
        type = e.detail.type || 'info';
        show = true;
    
        clearTimeout(timeout);
        timeout = setTimeout(() => show = false, 4000);
    });"
        :class="{
            'bg-green-500 text-white': type === 'success',
            'bg-red-500 text-white': type === 'error',
            'bg-yellow-500 text-black': type === 'warning',
            'bg-blue-500 text-white': type === 'info'
        }"
        class="fixed right-5 top-5 z-[9999] w-full max-w-xs rounded-md px-4 py-3 shadow-lg" role="alert">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <i
                    :class="{
                        'fas fa-check-circle': type === 'success',
                        'fas fa-exclamation-circle': type === 'error',
                        'fas fa-exclamation-triangle': type === 'warning',
                        'fas fa-info-circle': type === 'info'
                    }"></i>
                <span x-text="message" class="text-sm"></span>
            </div>
            <button @click="show = false" class="text-white hover:opacity-70">&times;</button>
        </div>
    </div>


    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const html = document.documentElement;
            const navbar = document.getElementById('navbar');
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('sidebar-toggle');
            const mainContent = document.getElementById('mainContent');

            const notifBtn = document.getElementById('notifBtn');
            const notifMenu = document.getElementById('notificationMenu');
            const userMenuBtn = document.getElementById('userMenuButton');
            const userMenu = document.getElementById('userMenu');
            const footer = document.getElementById('mainFooter');



            function updateLayout() {
                if (window.innerWidth >= 768) {
                    const collapsed = html.classList.contains('sidebar-collapsed');
                    navbar.style.left = collapsed ? '0' : '15rem';
                    mainContent.style.marginLeft = collapsed ? '0' : '15rem';
                    footer.style.marginLeft = collapsed ? '0' : '15rem';
                } else {
                    navbar.style.left = '0';
                    mainContent.style.marginLeft = '0';
                    footer.style.marginLeft = '0';
                }
            }

            // Set posisi awal
            updateLayout();

            // Toggle Sidebar
            toggleBtn?.addEventListener('click', (e) => {
                e.stopPropagation();
                const icon = document.getElementById('sidebar-icon');
                if (window.innerWidth >= 768) {
                    html.classList.toggle('sidebar-collapsed');
                    const collapsed = html.classList.contains('sidebar-collapsed');
                    icon.className = collapsed ?
                        'fas fa-arrow-right text-lg transition-all duration-300' :
                        'fas fa-bars-staggered text-lg transition-all duration-300';
                } else {
                    html.classList.toggle('sidebar-open-mobile');
                }
                updateLayout();
            });

            // Close sidebar mobile jika klik luar
            document.addEventListener('click', (e) => {
                if (window.innerWidth < 768 && html.classList.contains('sidebar-open-mobile')) {
                    if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
                        html.classList.remove('sidebar-open-mobile');
                    }
                }
            });

            // Resize
            window.addEventListener('resize', () => {
                if (window.innerWidth >= 768) {
                    html.classList.remove('sidebar-open-mobile');
                } else {
                    html.classList.remove('sidebar-collapsed');
                }
                updateLayout();
            });

            // Dropdown Notifikasi
            notifBtn?.addEventListener('click', (e) => {
                e.stopPropagation();
                notifMenu?.classList.toggle('hidden');
            });

            // Dropdown User Menu
            userMenuBtn?.addEventListener('click', (e) => {
                e.stopPropagation();
                userMenu?.classList.toggle('hidden');
            });

            // Klik luar untuk tutup dropdown
            window.addEventListener('click', () => {
                notifMenu?.classList.add('hidden');
                userMenu?.classList.add('hidden');
            });
        });
    </script>
</body>

</html>
