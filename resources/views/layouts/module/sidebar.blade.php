<aside id="sidebar"
    class="fixed top-0 left-0 z-40 w-60 h-full bg-white dark:bg-gray-900 overflow-y-auto scroll-smooth transition-transform duration-300 transform
    translate-x-0 md:translate-x-0
    md:sidebar-collapsed:translate-x-[-15rem]
    sidebar-open-mobile:translate-x-0
    text-gray-800 dark:text-gray-100">
    <div class="flex-shrink-0 border-b border-gray-200 dark:border-gray-700 px-4 py-4">
        <!-- Branding Aplikasi -->
        <div class="flex items-center space-x-2 mb-4">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-600 shadow">
                <i class="fas fa-box text-white text-xl"></i>
            </div>
            <div>
                <h1 class="text-sm font-bold text-gray-800 dark:text-gray-100 leading-tight">Inventory ERP</h1>
                <p class="text-xs text-gray-500 dark:text-gray-400">Sistem Manajemen</p>
            </div>
        </div>

        <hr class="border-gray-200 dark:border-gray-700 my-2">

        <!-- Info Pengguna -->
        <div class="flex items-center space-x-3 pt-2">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-200 dark:bg-gray-700">
                <i class="fas fa-user text-xl text-gray-600 dark:text-gray-300"></i>
            </div>
            <div class="flex-1 overflow-hidden">
                <p class="truncate text-sm text-gray-800 dark:text-gray-100">{{ Auth::user()->name }}</p>

                @php
                    $role = Auth::user()->role;
                    $roleBadgeClass = match ($role) {
                        'superadmin' => 'bg-green-500 text-white',
                        'admin_gudang' => 'bg-blue-500 text-white',
                        'kasir' => 'bg-yellow-400 text-gray-900',
                        'manager' => 'bg-red-500 text-white',
                        default => 'bg-gray-500 text-white',
                    };
                @endphp

                <span class="mt-1 inline-block rounded px-2 py-0.5 text-xs {{ $roleBadgeClass }}">
                    {{ ucfirst($role) }}
                </span>
            </div>
        </div>
    </div>

    <ul class="space-y-1 p-2">
        <li class="mt-4 px-2 py-2 text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">Menu Utama</li>

        {{-- DASHBOARD --}}
        @if (in_array(Auth::user()->role, ['superadmin', 'manager']))
            <li>
                <a href="{{ route('dashboard') }}"
                    class="{{ Request::is('dashboard') ? 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100' : 'text-gray-700 dark:text-gray-300' }} flex items-center rounded-lg p-2 text-sm hover:bg-gray-100 hover:dark:bg-gray-800 hover:text-gray-900 hover:dark:text-gray-100">
                    <i class="fas fa-dashboard mr-3 text-lg"></i>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>
        @endif

        {{-- INVENTORY --}}
        @if (in_array(Auth::user()->role, ['superadmin', 'admin_gudang']))
            <li
                class="{{ Request::is('inventory*') || Request::is('product') || Request::is('bahan_baku') || Request::is('category') || Request::is('supplier') || Request::is('productin') ? 'menu-open-tailwind' : '' }} group">
                <a href="#"
                    onclick="event.preventDefault(); this.closest('li').classList.toggle('menu-open-tailwind');"
                    class="{{ Request::is('inventory*') || Request::is('product') || Request::is('bahan_baku') || Request::is('category') || Request::is('supplier') || Request::is('productin') ? 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100' : 'text-gray-700 dark:text-gray-300' }} flex items-center justify-between rounded-lg p-2 text-sm hover:bg-gray-100 hover:dark:bg-gray-800 hover:text-gray-900 hover:dark:text-gray-100">
                    <span class="flex items-center">
                        <i class="fa fa-archive mr-3 text-lg"></i>
                        Inventory
                    </span>
                    <i
                        class="fa fa-angle-left transition-transform duration-200 group-[.menu-open-tailwind]:rotate-90"></i>
                </a>

                <ul
                    class="treeview-menu-tailwind mt-1 max-h-0 space-y-1 overflow-hidden pl-4 transition-all duration-300 group-[.menu-open-tailwind]:max-h-96">
                    @if (Auth::user()->role === 'superadmin')
                        <li>
                            <a href="{{ route('product.index') }}"
                                class="{{ Request::is('product') ? 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100' : 'text-gray-600 dark:text-gray-400' }} flex items-center rounded-lg p-2 text-sm hover:bg-gray-100 hover:dark:bg-gray-800 hover:text-gray-900 hover:dark:text-gray-100">
                                <i class="fa fa-circle-o mr-2 text-xs"></i>
                                Data Produk
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('bahan_baku.index') }}"
                                class="{{ Request::is('bahan_baku*') ? 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100' : 'text-gray-600 dark:text-gray-400' }} flex items-center rounded-lg p-2 text-sm hover:bg-gray-100 hover:dark:bg-gray-800 hover:text-gray-900 hover:dark:text-gray-100">
                                <i class="fa fa-circle-o mr-2 text-xs"></i>
                                Data Bahan Baku
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('category.index') }}"
                                class="{{ Request::is('category') ? 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100' : 'text-gray-600 dark:text-gray-400' }} flex items-center rounded-lg p-2 text-sm hover:bg-gray-100 hover:dark:bg-gray-800 hover:text-gray-900 hover:dark:text-gray-100">
                                <i class="fa fa-circle-o mr-2 text-xs"></i>
                                Kategori Produk
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('supplier.index') }}"
                                class="{{ Request::is('supplier') ? 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100' : 'text-gray-600 dark:text-gray-400' }} flex items-center rounded-lg p-2 text-sm hover:bg-gray-100 hover:dark:bg-gray-800 hover:text-gray-900 hover:dark:text-gray-100">
                                <i class="fa fa-circle-o mr-2 text-xs"></i>
                                Supplier
                            </a>
                        </li>
                    @endif

                    @if (Auth::user()->role === 'admin_gudang')
                        <li>
                            <a href="{{ route('productin.index') }}"
                                class="{{ Request::is('productin') ? 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100' : 'text-gray-600 dark:text-gray-400' }} flex items-center rounded-lg p-2 text-sm hover:bg-gray-100 hover:dark:bg-gray-800 hover:text-gray-900 hover:dark:text-gray-100">
                                <i class="fa fa-circle-o mr-2 text-xs"></i>
                                Produk Masuk
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        {{-- POS --}}
        @if (in_array(Auth::user()->role, ['superadmin', 'kasir']))
            <li class="{{ Request::is('sales') || Request::is('discounts') ? 'menu-open-tailwind' : '' }} group">
                <a href="#"
                    onclick="event.preventDefault(); this.closest('li').classList.toggle('menu-open-tailwind');"
                    class="{{ Request::is('sales') || Request::is('discounts') ? 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100' : 'text-gray-700 dark:text-gray-300' }} flex items-center justify-between rounded-lg p-2 text-sm hover:bg-gray-100 hover:dark:bg-gray-800 hover:text-gray-900 hover:dark:text-gray-100">
                    <span class="flex items-center">
                        <i class="fas fa-store mr-3 text-lg"></i>
                        Point Of Sales
                    </span>
                    <i
                        class="fa fa-angle-left transition-transform duration-200 group-[.menu-open-tailwind]:rotate-90"></i>
                </a>
                <ul
                    class="treeview-menu-tailwind mt-1 max-h-0 space-y-1 overflow-hidden pl-4 transition-all duration-300 group-[.menu-open-tailwind]:max-h-96">
                    <li>
                        <a href="{{ route('sales.index') }}"
                            class="{{ Request::is('sales') ? 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100' : 'text-gray-600 dark:text-gray-400' }} flex items-center rounded-lg p-2 text-sm hover:bg-gray-100 hover:dark:bg-gray-800 hover:text-gray-900 hover:dark:text-gray-100">
                            <i class="fa fa-circle-o mr-2 text-xs"></i>
                            Penjualan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('discounts.index') }}"
                            class="{{ Request::is('discounts') ? 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100' : 'text-gray-600 dark:text-gray-400' }} flex items-center rounded-lg p-2 text-sm hover:bg-gray-100 hover:dark:bg-gray-800 hover:text-gray-900 hover:dark:text-gray-100">
                            <i class="fa fa-circle-o mr-2 text-xs"></i>
                            Manajemen Diskon
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        {{-- PEGAWAI --}}
        @if (in_array(Auth::user()->role, ['superadmin', 'manager']))
            <li
                class="{{ Request::is('employees*') || Request::is('employee-attendance*') || Request::is('employment_status*') || Request::is('department*') || Request::is('position*') ? 'menu-open-tailwind' : '' }} group">
                <a href="#"
                    onclick="event.preventDefault(); this.closest('li').classList.toggle('menu-open-tailwind');"
                    class="{{ Request::is('employees*') || Request::is('employee-attendance*') || Request::is('employment_status*') || Request::is('department*') || Request::is('position*') ? 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100' : 'text-gray-700 dark:text-gray-300' }} flex items-center justify-between rounded-lg p-2 text-sm hover:bg-gray-100 hover:dark:bg-gray-800 hover:text-gray-900 hover:dark:text-gray-100">
                    <span class="flex items-center">
                        <i class="fas fa-users mr-3 text-lg"></i>
                        Manajemen Pegawai
                    </span>
                    <i
                        class="fa fa-angle-left transition-transform duration-200 group-[.menu-open-tailwind]:rotate-90"></i>
                </a>
                <ul
                    class="treeview-menu-tailwind mt-1 max-h-0 space-y-1 overflow-hidden pl-4 transition-all duration-300 group-[.menu-open-tailwind]:max-h-96">
                    <li>
                        <a href="{{ route('employees.index') }}"
                            class="{{ Request::is('employees') ? 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100' : 'text-gray-600 dark:text-gray-400' }} flex items-center rounded-lg p-2 text-sm hover:bg-gray-100 hover:dark:bg-gray-800 hover:text-gray-900 hover:dark:text-gray-100">
                            <i class="fa fa-circle-o mr-2 text-xs"></i>
                            Data Pegawai
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('employee-attendance.index') }}"
                            class="{{ Request::is('employee-attendance') ? 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100' : 'text-gray-600 dark:text-gray-400' }} flex items-center rounded-lg p-2 text-sm hover:bg-gray-100 hover:dark:bg-gray-800 hover:text-gray-900 hover:dark:text-gray-100">
                            <i class="fa fa-circle-o mr-2 text-xs"></i>
                            Absensi Pegawai
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('employment_status.index') }}"
                            class="{{ Request::is('employment_status') ? 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100' : 'text-gray-600 dark:text-gray-400' }} flex items-center rounded-lg p-2 text-sm hover:bg-gray-100 hover:dark:bg-gray-800 hover:text-gray-900 hover:dark:text-gray-100">
                            <i class="fa fa-circle-o mr-2 text-xs"></i>
                            Status Pegawai
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('department.index') }}"
                            class="{{ Request::is('department') ? 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100' : 'text-gray-600 dark:text-gray-400' }} flex items-center rounded-lg p-2 text-sm hover:bg-gray-100 hover:dark:bg-gray-800 hover:text-gray-900 hover:dark:text-gray-100">
                            <i class="fa fa-circle-o mr-2 text-xs"></i>
                            Departemen
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('position.index') }}"
                            class="{{ Request::is('position') ? 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100' : 'text-gray-600 dark:text-gray-400' }} flex items-center rounded-lg p-2 text-sm hover:bg-gray-100 hover:dark:bg-gray-800 hover:text-gray-900 hover:dark:text-gray-100">
                            <i class="fa fa-circle-o mr-2 text-xs"></i>
                            Posisi Pegawai
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        {{-- PENGGUNA --}}
        @if (Auth::user()->role === 'superadmin')
            <li>
                <a href="{{ route('user.index') }}"
                    class="{{ Request::is('user') ? 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100' : 'text-gray-700 dark:text-gray-300' }} flex items-center rounded-lg p-2 text-sm hover:bg-gray-100 hover:dark:bg-gray-800 hover:text-gray-900 hover:dark:text-gray-100">
                    <i class="fa fa-user mr-3 text-lg"></i>
                    Manajemen Pengguna
                </a>
            </li>
        @endif
    </ul>

    <!-- Tombol Dark Mode -->
    <div class="p-4 border-t border-gray-200 dark:border-gray-700">
        <button id="theme-toggle" type="button"
            class="w-full px-4 py-2 text-sm rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
            🌙 Mode Malam
        </button>
    </div>
</aside>

@push('scripts')
    <script>
        const themeToggleBtn = document.getElementById('theme-toggle');
        const html = document.documentElement;

        // cek localStorage
        if (localStorage.getItem('color-theme') === 'dark' ||
            (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            html.classList.add('dark');
        } else {
            html.classList.remove('dark');
        }

        themeToggleBtn.addEventListener('click', () => {
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            } else {
                html.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            }
        });
    </script>
@endpush
