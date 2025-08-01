<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('title')

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />

    <style>
        [x-cloak] {
            display: none !important;
        }

        /* ==== Layout Global ==== */
        body {
            transition: padding-left 0.3s ease-in-out;
            padding-top: 4rem;
            /* Sesuaikan dengan tinggi navbar */
            padding-bottom: 4rem;
            /* Sesuaikan dengan tinggi footer */
        }

        #sidebar {
            transition: transform 0.3s ease-in-out;
        }

        #navbar {
            height: 4rem;
        }

        #mainFooter {
            height: 4rem;
        }

        /* ==== Desktop & Tablet View (>= 768px) ==== */
        @media (min-width: 768px) {
            body {
                padding-left: 15rem;
                /* Ruang untuk sidebar saat terbuka */
            }

            html.sidebar-collapsed body {
                padding-left: 0;
            }

            #sidebar {
                transform: translateX(0);
            }

            html.sidebar-collapsed #sidebar {
                transform: translateX(-15rem);
            }
        }

        /* ==== Mobile View (< 768px) ==== */
        @media (max-width: 767px) {
            body {
                padding-left: 0;
            }

            #sidebar {
                transform: translateX(-15rem);
                /* Sidebar tersembunyi secara default */
                z-index: 50;
            }

            html.sidebar-open-mobile #sidebar {
                transform: translateX(0);
            }

            /* Overlay untuk mode mobile saat sidebar terbuka */
            html.sidebar-open-mobile::before {
                content: '';
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 40;
            }
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-800" style="font-family: 'Poppins', sans-serif;">
    {{-- SIDEBAR --}}
    @include('layouts.module.sidebar')


    <div id="navbar" class="fixed top-0 z-30 w-full flex items-center justify-between bg-white px-4 shadow-md">
        <button id="sidebar-toggle" class="p-2 text-gray-800 focus:outline-none">
            <i class="fas fa-bars text-lg"></i>
        </button>

        @if (Auth::user()->role === 'superadmin')
            <div class="relative ml-4">
                <button onclick="toggleNotificationMenu()" class="relative p-2 text-gray-800 focus:outline-none">
                    <i class="fas fa-bell text-lg"></i>
                    @php
                        $pendingRequests = \App\Models\ProductIn::where('status', 'menunggu')->count();
                    @endphp
                    @if ($pendingRequests > 0)
                        <span
                            class="absolute -right-1 -top-1 inline-flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-xs text-white">
                            {{ $pendingRequests }}
                        </span>
                    @endif
                </button>

                <div id="notificationMenu" class="absolute right-0 z-50 mt-2 hidden w-64 rounded-md bg-white shadow-lg">
                    <div class="py-2 text-sm text-gray-700">
                        @if ($pendingRequests > 0)
                            @foreach (\App\Models\ProductIn::where('status', 'menunggu')->latest()->take(5)->get() as $notif)
                                <a href="{{ route('product.confirmation', $notif->id) }}"
                                    class="block border-b px-4 py-2 hover:bg-gray-100">
                                    Permintaan masuk: <strong>{{ $notif->requester_name }}</strong><br>
                                    Produk: <strong>{{ $notif->product->name ?? '-' }}</strong><br>
                                    <small class="text-gray-500">{{ $notif->created_at->diffForHumans() }}</small>
                                </a>
                            @endforeach
                        @else
                            <p class="px-4 py-2 text-gray-500">Tidak ada notifikasi.</p>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <div class="relative ml-auto inline-block text-left">
            <button id="userMenuButton" onclick="toggleUserMenu()" class="flex items-center text-sm focus:outline-none">
                <i class="fas fa-user-circle text-2xl text-gray-600"></i>
                <span class="ml-2">{{ Auth::user()->name }}</span>
            </button>

            <div id="userMenu" class="absolute right-0 z-50 mt-2 hidden w-48 rounded-md bg-white shadow-lg">
                <div class="py-1">
                    <div x-data="{ openLogout: false }">
                        <a href="#" @click.prevent="openLogout = true"
                            class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                            <i class="fas fa-power-off mr-2"></i>
                            Keluar
                        </a>

                        <div x-show="openLogout"
                            class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50" x-cloak>
                            <div class="bg-white rounded-lg shadow-lg w-96 p-6">
                                <h2 class="text-lg font-semibold text-gray-800 mb-4">Konfirmasi Logout</h2>
                                <p class="text-gray-600 mb-6">Apakah Anda yakin ingin keluar dari akun?</p>
                                <div class="flex justify-end space-x-4">
                                    <button @click="openLogout = false"
                                        class="px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300">
                                        Batal
                                    </button>
                                    <button @click="document.getElementById('logout-form').submit();"
                                        class="px-4 py-2 text-sm text-white bg-red-600 rounded hover:bg-red-700">
                                        Ya, Keluar
                                    </button>
                                </div>
                            </div>
                        </div>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>




    {{-- MAIN CONTENT --}}
    <main id="mainContent" class="min-h-[calc(100vh-4rem)] px-4 pb-24">
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



    {{-- LOGOUT FORM (Globally Accessible) --}}
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>


    @stack('scripts')

    {{-- master.blade.php --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const html = document.documentElement;

            sidebarToggle?.addEventListener('click', () => {
                if (window.innerWidth >= 768) {
                    html.classList.toggle('sidebar-collapsed');
                } else {
                    html.classList.toggle('sidebar-open-mobile');
                }
            });

            // Tutup sidebar saat klik di luar area sidebar pada mobile
            window.addEventListener('click', function(e) {
                if (window.innerWidth < 768 && html.classList.contains('sidebar-open-mobile')) {
                    const sidebar = document.getElementById('sidebar');
                    const toggleBtn = document.getElementById('sidebar-toggle');
                    if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
                        html.classList.remove('sidebar-open-mobile');
                    }
                }
            });

            // Handle window resize
            window.addEventListener('resize', () => {
                if (window.innerWidth >= 768) {
                    html.classList.remove('sidebar-open-mobile');
                } else {
                    html.classList.remove('sidebar-collapsed');
                }
            });

            function toggleUserMenu() {
                const menu = document.getElementById('userMenu')
                menu.classList.toggle('hidden')
            }

            function toggleNotificationMenu() {
                const notif = document.getElementById('notificationMenu')
                notif.classList.toggle('hidden')
            }

            window.toggleUserMenu = toggleUserMenu;
            window.toggleNotificationMenu = toggleNotificationMenu;
        });
    </script>
</body>

</html>
