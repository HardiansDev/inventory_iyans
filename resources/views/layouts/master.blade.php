<!DOCTYPE html>
<html lang="id" class="">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('title')
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>
    <script>
        // Tailwind dark mode pakai class
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {}
            }
        }
    </script>

    <!-- Anti-flicker: ini dipanggil duluan di <head> -->
    <script>
        if (
            localStorage.getItem('color-theme') === 'dark' ||
            (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)
        ) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <script>
        (function() {
            const theme = localStorage.getItem('theme');
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>


    {{-- Chart.js (hanya sekali) --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- Flowbite (cukup satu versi stabil terbaru) --}}
    <script src="https://unpkg.com/flowbite@latest/dist/flowbite.min.js"></script>

    {{-- html2pdf (untuk export PDF) --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

    {{-- XLSX (untuk export Excel) --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    {{-- Alpine.js (untuk interaktifitas ringan) --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>


    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />

    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            overflow-x: hidden;
            /* cegah scrollbar horizontal */
            overflow-y: auto;
            /* biar scroll vertikal tetap bisa */
            -ms-overflow-style: none;
            /* Edge lama */
            scrollbar-width: none;
            /* Firefox */
        }

        /* Brave / Chrome / Edge */
        html::-webkit-scrollbar,
        body::-webkit-scrollbar {
            display: none;
        }


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

        /* Hide scrollbar but keep scrolling */
        #sidebar {
            scrollbar-width: none;
            /* Firefox */
            -ms-overflow-style: none;
            /* IE/Edge */
        }

        #sidebar::-webkit-scrollbar {
            display: none;
            /* Chrome, Safari, Opera */
        }

        /* Untuk semua browser modern */
        .scroll-hidden::-webkit-scrollbar {
            display: none;
            /* Chrome, Safari, Opera */
        }

        .scroll-hidden {
            -ms-overflow-style: none;
            /* IE 10+ */
            scrollbar-width: none;
            /* Firefox */
        }
    </style>

</head>

<body x-data class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200 min-h-screen"
    style="font-family: 'Poppins', sans-serif;">
    <nav id="navbar"
        class="fixed top-0 z-50 h-16 flex items-center justify-between bg-white dark:bg-gray-900 px-6 shadow-md transition-all duration-300"
        style="left: 15rem; right: 0;">

        <!-- Sidebar Toggle -->
        <button id="sidebar-toggle"
            class="p-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md transition-colors duration-200 focus:outline-none">
            <i id="sidebar-icon" class="fas fa-bars-staggered text-lg transition-all duration-300"></i>
        </button>

        <!-- Right Section -->
        <div class="flex items-center space-x-4 ml-auto">
            <div class="p-4 flex justify-center">
                <button id="theme-toggle" class="focus:outline-none">
                    <i id="theme-icon" class="fas fa-moon text-lg transition-transform duration-500"></i>
                </button>
            </div>


            {{-- Notifikasi --}}
            @if (Auth::user()->role === 'superadmin' || Auth::user()->role === 'admin_gudang')
                <div class="relative">
                    <!-- Tombol Bell -->
                    <button id="notifBtn"
                        class="relative p-2 rounded-full text-gray-800 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-200 focus:outline-none">
                        <i class="fas fa-bell text-lg"></i>
                        @php
                            $notifCount = 0;
                            if (Auth::user()->role === 'superadmin') {
                                $notifCount = \App\Models\ProductIn::where('status', 'menunggu')
                                    ->where('is_read', false)
                                    ->count();
                            } else {
                                $notifCount = \App\Models\ProductIn::where('requester_name', Auth::user()->name)
                                    ->whereIn('status', ['disetujui', 'ditolak'])
                                    ->where('is_read', false)
                                    ->count();
                            }
                        @endphp

                        @if ($notifCount > 0)
                            <span
                                class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-xs font-semibold text-white">
                                {{ $notifCount }}
                            </span>
                        @endif
                    </button>

                    <!-- Dropdown Notifikasi -->
                    <div id="notificationMenu"
                        class="absolute right-0 mt-2 hidden w-80 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 shadow-xl z-[60] overflow-hidden">

                        <div class="py-2 text-sm max-h-72 overflow-y-auto">
                            @php
                                if (Auth::user()->role === 'superadmin') {
                                    $notifs = \App\Models\ProductIn::where('status', 'menunggu')
                                        ->latest()
                                        ->take(3)
                                        ->get();
                                } else {
                                    $notifs = \App\Models\ProductIn::where('requester_name', Auth::user()->name)
                                        ->whereIn('status', ['disetujui', 'ditolak'])
                                        ->latest()
                                        ->take(3)
                                        ->get();
                                }
                            @endphp

                            @forelse ($notifs as $notif)
                                @if (Auth::user()->role === 'superadmin')
                                    <a href="{{ route('product.confirmation', $notif->id) }}"
                                        class="block border-b border-gray-100 dark:border-gray-800 px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-200">
                                        <p class="text-gray-800 dark:text-gray-100 font-medium">
                                            Permintaan: <strong>{{ $notif->requester_name }}</strong>
                                        </p>
                                        <p class="text-gray-600 dark:text-gray-300">
                                            Produk: <strong>{{ $notif->product->name ?? '-' }}</strong>
                                        </p>
                                        <small
                                            class="text-gray-400 dark:text-gray-500">{{ $notif->created_at->diffForHumans() }}</small>
                                    </a>
                                @else
                                    <a href="{{ route('notifications.admin_gudang.show', $notif->id) }}"
                                        class="block border-b border-gray-100 dark:border-gray-800 px-4 py-3 transition-colors duration-200
                                        {{ $notif->is_read ? 'bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-400' : 'bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100' }}
                                        hover:bg-gray-50 dark:hover:bg-gray-800">
                                        <p class="font-medium">Feedback:
                                            <strong>{{ $notif->product->name ?? '-' }}</strong>
                                        </p>
                                        <p>Status:
                                            <span
                                                class="{{ $notif->status === 'disetujui' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }} font-semibold">
                                                {{ ucfirst($notif->status) }}
                                            </span>
                                        </p>
                                        <small
                                            class="text-gray-400 dark:text-gray-500">{{ $notif->updated_at->diffForHumans() }}</small>
                                    </a>
                                @endif
                            @empty
                                <p class="px-4 py-3 text-gray-500 dark:text-gray-400">Tidak ada notifikasi.</p>
                            @endforelse

                            @if ($notifCount > 3)
                                <a href="{{ Auth::user()->role === 'superadmin' ? route('notifications.superadmin') : route('notifications.admin_gudang') }}"
                                    class="block text-center text-blue-600 dark:text-blue-400 font-semibold py-2 hover:underline transition-colors duration-200">
                                    Lihat semua notifikasi
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            {{-- User Menu --}}
            <div class="relative inline-block text-left">
                <button id="userMenuButton"
                    class="flex items-center text-sm focus:outline-none px-3 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                    <i class="fas fa-user-circle text-2xl text-gray-600 dark:text-gray-300"></i>
                    <span class="ml-2 text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</span>
                    <i class="fas fa-chevron-down ml-2 text-gray-500 dark:text-gray-400 text-xs"></i>
                </button>

                <div id="userMenu"
                    class="absolute right-0 mt-2 hidden w-52 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-lg z-50 overflow-hidden">
                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                        <i class="fas fa-cog mr-2 text-gray-500 dark:text-gray-400"></i>
                        Pengaturan Profil
                    </a>
                    <a href="{{ route('activity.log') }}"
                        class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                        <i class="fas fa-history mr-2 text-gray-500 dark:text-gray-400"></i>
                        Log Aktivitas
                    </a>
                    <a href="#" @click.prevent="$dispatch('open-logout-modal')"
                        class="flex items-center px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                        <i class="fas fa-power-off mr-2"></i>
                        Keluar
                    </a>
                </div>
            </div>

        </div>
    </nav>



    @include('layouts.module.sidebar')


    <div x-data="{ show: false }" @open-logout-modal.window="show = true" x-show="show" x-transition x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">

        <div @click.away="show = false"
            class="w-full max-w-md rounded-xl bg-white dark:bg-gray-800 p-6 shadow-lg transform transition-all duration-300">

            <h2 class="mb-3 text-xl font-semibold text-gray-900 dark:text-gray-100">Konfirmasi Logout</h2>
            <p class="mb-6 text-gray-700 dark:text-gray-300">Apakah Anda yakin ingin keluar dari akun?</p>

            <div class="flex justify-end space-x-4">
                <button @click="show = false"
                    class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200
                           hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                    Batal
                </button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700 transition">
                        Ya, Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>


    {{-- MAIN CONTENT --}}
    <main id="mainContent"
        class="min-h-[calc(100vh-4rem)] pt-24 px-4 pb-24 transition-all duration-300
           bg-white dark:bg-gray-900
           text-gray-900 dark:text-gray-100">
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

    <script>
        const toggleBtn = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');
        const html = document.documentElement;

        // fungsi untuk set icon sesuai tema
        function updateIcon() {
            if (html.classList.contains('dark')) {
                themeIcon.classList.remove('fa-moon');
                themeIcon.classList.add('fa-sun');
            } else {
                themeIcon.classList.remove('fa-sun');
                themeIcon.classList.add('fa-moon');
            }
        }

        // load preferensi dari localStorage
        if (localStorage.getItem('theme') === 'dark') {
            html.classList.add('dark');
        } else {
            html.classList.remove('dark');
        }
        updateIcon();

        toggleBtn.addEventListener('click', () => {
            // kasih animasi scale + rotate
            themeIcon.classList.add('rotate-180', 'scale-125');
            setTimeout(() => {
                themeIcon.classList.remove('rotate-180', 'scale-125');
            }, 500);

            // toggle dark mode
            html.classList.toggle('dark');
            localStorage.setItem('theme', html.classList.contains('dark') ? 'dark' : 'light');

            // update icon langsung sesuai kondisi terbaru
            updateIcon();
        });
    </script>
</body>

</html>
