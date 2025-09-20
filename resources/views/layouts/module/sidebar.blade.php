<aside id="sidebar"
    class="fixed top-0 left-0 z-40 w-60 h-full bg-white dark:bg-gray-900
    overflow-y-auto scroll-smooth transition-transform duration-300 transform
    translate-x-0 md:translate-x-0
    md:sidebar-collapsed:translate-x-[-15rem]
    sidebar-open-mobile:translate-x-0
    text-gray-800 dark:text-gray-100">
    <div class="flex-shrink-0 border-b border-gray-200 dark:border-gray-700 px-4 py-4">
        <!-- Branding Aplikasi -->
        <div class="flex items-center space-x-2 mb-4">
            <div class="flex h-10 w-10 items-center justify-center">
                <i class="fa fa-cash-register text-blue-600 text-3xl"></i>
            </div>
            <div class="sidebar-text">
                <h1 class="text-sm font-bold text-gray-800 dark:text-gray-100 leading-tight">KASIRIN.ID</h1>
            </div>
        </div>



        <hr class="border-gray-200 dark:border-gray-700 my-2 -mx-4">

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
                        'superadmin'
                            => 'bg-green-100 text-green-800 border border-green-300 dark:bg-green-800 dark:text-green-100 dark:border-green-700',
                        'admin_gudang'
                            => 'bg-blue-100 text-blue-800 border border-blue-300 dark:bg-blue-800 dark:text-blue-100 dark:border-blue-700',
                        'kasir'
                            => 'bg-yellow-100 text-yellow-800 border border-yellow-300 dark:bg-yellow-600 dark:text-yellow-100 dark:border-yellow-500',
                        'manager'
                            => 'bg-red-100 text-red-800 border border-red-300 dark:bg-red-800 dark:text-red-100 dark:border-red-700',
                        default
                            => 'bg-gray-100 text-gray-800 border border-gray-300 dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600',
                    };
                @endphp

                <span
                    class="mt-1 inline-block rounded-full px-3 py-0.5 text-xs font-medium shadow-sm {{ $roleBadgeClass }}">
                    {{ ucfirst($role) }}
                </span>

            </div>
        </div>
    </div>

    <ul class="space-y-2 p-2">
        {{-- Label --}}
        <li class="mt-4 px-2 text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
            Menu Utama
        </li>

        {{-- DASHBOARD --}}
        @if (in_array(Auth::user()->role, ['superadmin', 'manager']))
            <li>
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 rounded-xl p-2.5 text-sm font-medium transition-all duration-200
                {{ Request::is('dashboard')
                    ? 'bg-blue-50 dark:bg-gray-700 text-blue-600 dark:text-blue-400 shadow-sm'
                    : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 hover:dark:bg-gray-700 hover:text-gray-900 hover:dark:text-gray-100' }}">
                    <span class="flex items-center gap-2">
                        <i class="fa fa-dashboard text-base"></i>
                        <span>Dashboard</span>
                    </span>
                </a>
            </li>
        @endif

        {{-- INVENTORY --}}
        @if (in_array(Auth::user()->role, ['superadmin', 'admin_gudang']))
            <li
                class="{{ Request::is('inventory*') || Request::is('product') || Request::is('bahan_baku') || Request::is('category') || Request::is('supplier') || Request::is('productin') || Request::is('trackingtree') || Request::is('satuan') ? 'menu-open-tailwind' : '' }} group">

                {{-- Parent --}}
                <a href="#"
                    onclick="event.preventDefault(); this.closest('li').classList.toggle('menu-open-tailwind');"
                    class="flex items-center justify-between rounded-xl p-2.5 text-sm font-medium transition-all duration-200
                {{ Request::is('inventory*') ||
                Request::is('product') ||
                Request::is('bahan_baku') ||
                Request::is('category') ||
                Request::is('supplier') ||
                Request::is('productin') ||
                Request::is('trackingtree') ||
                Request::is('satuan')
                    ? 'bg-blue-50 dark:bg-gray-700 text-blue-600 dark:text-blue-400 shadow-sm'
                    : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 hover:dark:bg-gray-700 hover:text-gray-900 hover:dark:text-gray-100' }}">
                    <span class="flex items-center gap-2">
                        <i class="fa fa-archive text-base"></i>
                        <span>Inventory</span>
                    </span>
                    <i
                        class="fa fa-angle-left text-xs transition-transform duration-300 group-[.menu-open-tailwind]:rotate-90"></i>
                </a>

                {{-- Submenu --}}
                <ul
                    class="treeview-menu-tailwind mt-1 max-h-0 overflow-hidden pl-6
                space-y-1 transition-all duration-300 ease-in-out group-[.menu-open-tailwind]:max-h-96">

                    @if (Auth::user()->role === 'superadmin')
                        <li>
                            <a href="{{ route('product.index') }}"
                                class="flex items-center gap-2 rounded-lg p-2 text-sm transition-colors duration-200
                            {{ Request::is('product')
                                ? 'bg-blue-50 dark:bg-gray-700 text-blue-600 dark:text-blue-400 font-medium'
                                : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 hover:dark:bg-gray-700 hover:text-gray-900 hover:dark:text-gray-100' }}">
                                <i class="fa fa-circle text-[6px]"></i>
                                Data Produk
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('bahan_baku.index') }}"
                                class="flex items-center gap-2 rounded-lg p-2 text-sm transition-colors duration-200
                            {{ Request::is('bahan_baku*')
                                ? 'bg-blue-50 dark:bg-gray-700 text-blue-600 dark:text-blue-400 font-medium'
                                : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 hover:dark:bg-gray-700 hover:text-gray-900 hover:dark:text-gray-100' }}">
                                <i class="fa fa-circle text-[6px]"></i>
                                Data Bahan Baku
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('category.index') }}"
                                class="flex items-center gap-2 rounded-lg p-2 text-sm transition-colors duration-200
                            {{ Request::is('category')
                                ? 'bg-blue-50 dark:bg-gray-700 text-blue-600 dark:text-blue-400 font-medium'
                                : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 hover:dark:bg-gray-700 hover:text-gray-900 hover:dark:text-gray-100' }}">
                                <i class="fa fa-circle text-[6px]"></i>
                                Kategori Produk
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('supplier.index') }}"
                                class="flex items-center gap-2 rounded-lg p-2 text-sm transition-colors duration-200
                            {{ Request::is('supplier')
                                ? 'bg-blue-50 dark:bg-gray-700 text-blue-600 dark:text-blue-400 font-medium'
                                : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 hover:dark:bg-gray-700 hover:text-gray-900 hover:dark:text-gray-100' }}">
                                <i class="fa fa-circle text-[6px]"></i>
                                Supplier
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('satuan.index') }}"
                                class="flex items-center gap-2 rounded-lg p-2 text-sm transition-colors duration-200
                                {{ Request::is('satuan*')
                                    ? 'bg-blue-50 dark:bg-gray-700 text-blue-600 dark:text-blue-400 font-medium'
                                    : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 hover:dark:bg-gray-700 hover:text-gray-900 hover:dark:text-gray-100' }}">
                                <i class="fa fa-circle text-[6px]"></i>
                                Satuan
                            </a>
                        </li>
                    @endif

                    @if (Auth::user()->role === 'admin_gudang')
                        <li>
                            <a href="{{ route('productin.index') }}"
                                class="flex items-center gap-2 rounded-lg p-2 text-sm transition-colors duration-200
                            {{ Request::is('productin')
                                ? 'bg-blue-50 dark:bg-gray-700 text-blue-600 dark:text-blue-400 font-medium'
                                : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 hover:dark:bg-gray-700 hover:text-gray-900 hover:dark:text-gray-100' }}">
                                <i class="fa fa-circle text-[6px]"></i>
                                Produk Masuk
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('trackingtree.index') }}"
                                class="flex items-center gap-2 rounded-lg p-2 text-sm transition-colors duration-200
                            {{ Request::is('trackingtree')
                                ? 'bg-blue-50 dark:bg-gray-700 text-blue-600 dark:text-blue-400 font-medium'
                                : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 hover:dark:bg-gray-700 hover:text-gray-900 hover:dark:text-gray-100' }}">
                                <i class="fa fa-circle text-[6px]"></i>
                                Tracking Persetujuan
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
                    class="flex items-center justify-between rounded-xl p-2.5 text-sm font-medium transition-all duration-200
                {{ Request::is('sales') || Request::is('discounts')
                    ? 'bg-blue-50 dark:bg-gray-700 text-blue-600 dark:text-blue-400 shadow-sm'
                    : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 hover:dark:bg-gray-700 hover:text-gray-900 hover:dark:text-gray-100' }}">
                    <span class="flex items-center gap-2">
                        <i class="fas fa-store text-base"></i>
                        Point Of Sales
                    </span>
                    <i
                        class="fa fa-angle-left text-xs transition-transform duration-300 group-[.menu-open-tailwind]:rotate-90"></i>
                </a>
                <ul
                    class="treeview-menu-tailwind mt-1 max-h-0 overflow-hidden pl-6
                space-y-1 transition-all duration-300 ease-in-out group-[.menu-open-tailwind]:max-h-96">
                    <li>
                        <a href="{{ route('sales.index') }}"
                            class="flex items-center gap-2 rounded-lg p-2 text-sm transition-colors duration-200
                        {{ Request::is('sales')
                            ? 'bg-blue-50 dark:bg-gray-700 text-blue-600 dark:text-blue-400 font-medium'
                            : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 hover:dark:bg-gray-700 hover:text-gray-900 hover:dark:text-gray-100' }}">
                            <i class="fa fa-circle text-[6px]"></i>
                            Penjualan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('discounts.index') }}"
                            class="flex items-center gap-2 rounded-lg p-2 text-sm transition-colors duration-200
                        {{ Request::is('discounts')
                            ? 'bg-blue-50 dark:bg-gray-700 text-blue-600 dark:text-blue-400 font-medium'
                            : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 hover:dark:bg-gray-700 hover:text-gray-900 hover:dark:text-gray-100' }}">
                            <i class="fa fa-circle text-[6px]"></i>
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

                {{-- Parent --}}
                <a href="#"
                    onclick="event.preventDefault(); this.closest('li').classList.toggle('menu-open-tailwind');"
                    class="flex items-center justify-between rounded-xl p-2.5 text-sm font-medium transition-all duration-200
                {{ Request::is('employees*') ||
                Request::is('employee-attendance*') ||
                Request::is('employment_status*') ||
                Request::is('department*') ||
                Request::is('position*')
                    ? 'bg-blue-50 dark:bg-gray-700 text-blue-600 dark:text-blue-400 shadow-sm'
                    : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 hover:dark:bg-gray-700 hover:text-gray-900 hover:dark:text-gray-100' }}">
                    <span class="flex items-center gap-2">
                        <i class="fa fa-users text-base"></i>
                        <span>Manajemen Pegawai</span>
                    </span>
                    <i
                        class="fa fa-angle-left text-xs transition-transform duration-300 group-[.menu-open-tailwind]:rotate-90"></i>
                </a>

                {{-- Submenu --}}
                <ul
                    class="treeview-menu-tailwind mt-1 max-h-0 overflow-hidden pl-6
                space-y-1 transition-all duration-300 ease-in-out group-[.menu-open-tailwind]:max-h-96">
                    <li>
                        <a href="{{ route('employees.index') }}"
                            class="flex items-center gap-2 rounded-lg p-2 text-sm transition-colors duration-200
                        {{ Request::is('employees')
                            ? 'bg-blue-50 dark:bg-gray-700 text-blue-600 dark:text-blue-400 font-medium'
                            : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 hover:dark:bg-gray-700 hover:text-gray-900 hover:dark:text-gray-100' }}">
                            <i class="fa fa-circle text-[6px]"></i>
                            Data Pegawai
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('employee-attendance.index') }}"
                            class="flex items-center gap-2 rounded-lg p-2 text-sm transition-colors duration-200
                        {{ Request::is('employee-attendance')
                            ? 'bg-blue-50 dark:bg-gray-700 text-blue-600 dark:text-blue-400 font-medium'
                            : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 hover:dark:bg-gray-700 hover:text-gray-900 hover:dark:text-gray-100' }}">
                            <i class="fa fa-circle text-[6px]"></i>
                            Absensi Pegawai
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('employment_status.index') }}"
                            class="flex items-center gap-2 rounded-lg p-2 text-sm transition-colors duration-200
                        {{ Request::is('employment_status')
                            ? 'bg-blue-50 dark:bg-gray-700 text-blue-600 dark:text-blue-400 font-medium'
                            : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 hover:dark:bg-gray-700 hover:text-gray-900 hover:dark:text-gray-100' }}">
                            <i class="fa fa-circle text-[6px]"></i>
                            Status Pegawai
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('department.index') }}"
                            class="flex items-center gap-2 rounded-lg p-2 text-sm transition-colors duration-200
                        {{ Request::is('department')
                            ? 'bg-blue-50 dark:bg-gray-700 text-blue-600 dark:text-blue-400 font-medium'
                            : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 hover:dark:bg-gray-700 hover:text-gray-900 hover:dark:text-gray-100' }}">
                            <i class="fa fa-circle text-[6px]"></i>
                            Departemen
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('position.index') }}"
                            class="flex items-center gap-2 rounded-lg p-2 text-sm transition-colors duration-200
                        {{ Request::is('position')
                            ? 'bg-blue-50 dark:bg-gray-700 text-blue-600 dark:text-blue-400 font-medium'
                            : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 hover:dark:bg-gray-700 hover:text-gray-900 hover:dark:text-gray-100' }}">
                            <i class="fa fa-circle text-[6px]"></i>
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
                    class="flex items-center gap-3 rounded-xl p-2.5 text-sm font-medium transition-all duration-200
                {{ Request::is('user')
                    ? 'bg-blue-50 dark:bg-gray-700 text-blue-600 dark:text-blue-400 shadow-sm'
                    : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 hover:dark:bg-gray-700 hover:text-gray-900 hover:dark:text-gray-100' }}">
                    <i class="fa fa-user text-base"></i>
                    <span>Manajemen Pengguna</span>
                </a>
            </li>
        @endif

        @php
            $unreadTotal = \App\Models\Message::where('receiver_id', auth()->id())
                ->where('is_read', false)
                ->count();
        @endphp

        {{-- CHATS --}}
        @if (in_array(Auth::user()->role, ['superadmin', 'admin_gudang', 'kasir']))
            <li>
                <a href="{{ route('chat.index') }}"
                    class="flex items-center gap-3 rounded-xl p-2.5 text-sm font-medium transition-all duration-200
                {{ Request::is('chat*')
                    ? 'bg-blue-50 dark:bg-gray-700 text-blue-600 dark:text-blue-400 shadow-sm'
                    : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 hover:dark:bg-gray-700 hover:text-gray-900 hover:dark:text-gray-100' }}">
                    <i class="fa fa-comments text-base"></i>
                    <span>Obrolan</span>
                    {{-- Badge Notifikasi --}}
                    @if ($unreadTotal > 0)
                        <span
                            class="ml-auto rounded-full bg-red-600 px-2 py-0.5 text-xs font-semibold text-white shadow-sm">
                            {{ $unreadTotal }}
                        </span>
                    @endif
                </a>
            </li>
        @endif
    </ul>
</aside>
