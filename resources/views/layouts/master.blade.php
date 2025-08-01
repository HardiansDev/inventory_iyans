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
    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <style>
        html.collapsed .sidebar {
            width: 0 !important;
            padding: 0 !important;
        }

        html.collapsed main {
            margin-left: 0 !important;
        }

        html.collapsed #navbar {
            margin-left: 0 !important;
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-800" style="font-family: 'Poppins', sans-serif">
    {{-- SIDEBAR --}}
    @include('layouts.module.sidebar')

    <div id="navbar"
        class="sticky top-0 z-50 ml-60 flex items-center justify-between bg-white p-4 shadow-md transition-all duration-300">
        <button id="sidebar-toggle" class="p-2 text-gray-800 focus:outline-none">
            <i class="fas fa-bars text-lg"></i>
        </button>

        <!-- Notifikasi Super Admin -->
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

                <!-- Dropdown Notifikasi -->
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

        <!-- Right: User Dropdown -->
        <div class="relative ml-auto inline-block text-left">
            <button id="userMenuButton" onclick="toggleUserMenu()" class="flex items-center text-sm focus:outline-none">
                <i class="fas fa-user-circle text-2xl text-gray-600"></i>
                <span class="ml-2">{{ Auth::user()->name }}</span>
            </button>

            <!-- Dropdown -->
            <div id="userMenu" class="absolute right-0 z-50 mt-2 hidden w-48 rounded-md bg-white shadow-lg">
                <div class="py-1">
                    {{-- <a href="{{ route('log.aktivitas') }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-history mr-2"></i>
                        Log Aktivitas
                    </a>
                    <a href="{{ route('akun.pengaturan') }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-cog mr-2"></i>
                        Pengaturan Akun
                    </a> --}}
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                        <i class="fas fa-power-off mr-2"></i>
                        Keluar
                    </a>
                </div>
            </div>
        </div>
    </div>




    {{-- MAIN CONTENT --}}
    <main class="ml-60 p-4 transition-all duration-300">
        @yield('content')
    </main>
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


    <!-- Alpine Notifikasi dari JS -->
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

    {{-- Sidebar Toggle Script --}}
    {{-- <script src="//unpkg.com/alpinejs" defer></script> --}}

    {{-- <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script> --}}


    @stack('scripts')

    <script>
        function toggleUserMenu() {
            const menu = document.getElementById('userMenu')
            menu.classList.toggle('hidden')
        }

        // Optional: close dropdown jika klik di luar
        window.addEventListener('click', function(e) {
            const menu = document.getElementById('userMenu')
            const button = document.getElementById('userMenuButton')
            if (!menu.contains(e.target) && !button.contains(e.target)) {
                menu.classList.add('hidden')
            }
        })
    </script>
    <script>
        function toggleNotificationMenu() {
            document.getElementById('notificationMenu').classList.toggle('hidden');
        }
    </script>
</body>

</html>
