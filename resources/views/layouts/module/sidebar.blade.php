<style>
    .main-sidebar {
        height: 100vh;
        overflow-y: auto;
        position: fixed;
        top: 0;
        left: 0;
        width: 230px;
        /* Sesuaikan jika pakai AdminLTE atau lainnya */
        background-color: #222d32;
        /* Sesuaikan warna */
        z-index: 1000;
    }

    .content-wrapper {
        margin-left: 230px;
        /* Harus sesuai lebar sidebar */
        padding: 15px;
    }

    /* Optional: Supaya sidebar scroll-nya halus dan tersembunyi scrollbar */
    .main-sidebar::-webkit-scrollbar {
        width: 5px;
    }

    .main-sidebar::-webkit-scrollbar-thumb {
        background-color: rgba(255, 255, 255, 0.2);
        border-radius: 5px;
    }
</style>


<aside class="main-sidebar">
    <section class="sidebar">
        <!-- Panel pengguna -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('temp/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="Gambar Pengguna">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->name }}</p>
                <label
                    class="badge
                    @if (Auth::user()->role === 'superadmin') bg-success
                    @elseif(Auth::user()->role === 'admin_gudang') bg-primary
                    @elseif(Auth::user()->role === 'kasir') bg-warning
                    @elseif(Auth::user()->role === 'manager') bg-danger
                    @else bg-secondary @endif
                    text-white px-2 py-1 rounded">
                    {{ ucfirst(Auth::user()->role) }}
                </label>
            </div>
        </div>

        <!-- Menu Sidebar -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MENU UTAMA</li>

            @if (in_array(Auth::user()->role, ['superadmin', 'manager']))
                <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>
            @endif

            {{-- MODUL INVENTORY --}}
            @if (in_array(Auth::user()->role, ['superadmin', 'admin_gudang']))
                <li class="treeview {{ Request::is('inventory*') ? 'active menu-open' : '' }}">
                    <a href="#">
                        <i class="fa fa-archive"></i> <span>Management Inventory</span>
                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('inventory/dashboard') ? 'active' : '' }}">
                            <a href="#"><i class="fa fa-circle-o"></i> Dashboard Inventory</a>
                        </li>
                        <li class="{{ Request::is('product') ? 'active' : '' }}">
                            <a href="{{ route('product.index') }}"><i class="fa fa-circle-o"></i> Data Produk</a>
                        </li>
                        <li class="{{ Request::is('category') ? 'active' : '' }}">
                            <a href="{{ route('category.index') }}"><i class="fa fa-circle-o"></i> Kategori Produk</a>
                        </li>
                        <li class="{{ Request::is('supplier') ? 'active' : '' }}">
                            <a href="{{ route('supplier.index') }}"><i class="fa fa-circle-o"></i> Supplier</a>
                        </li>
                        <li class="{{ Request::is('productin') ? 'active' : '' }}">
                            <a href="{{ route('productin.index') }}"><i class="fa fa-circle-o"></i> Produk Masuk</a>
                        </li>
                    </ul>
                </li>
            @endif


            {{-- MODUL POS --}}
            @if (in_array(Auth::user()->role, ['superadmin', 'kasir']))
                <li class="treeview">
                    <a href="#"><i class="fas fa-store"></i> <span>Point Of Sales </span>
                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('sales') ? 'active' : '' }}">
                            <a href="{{ route('sales.index') }}">
                                <i class="fa fa-circle-o"></i> <span>Penjualan</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('discount') ? 'active' : '' }}">
                            <a href="{{ route('discounts.index') }}" class="nav-link">
                                <i class="fa fa-circle-o"></i> <span>Manajemen Diskon</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

            {{-- MODUL MANAJEMEN PEGAWAI --}}
            @if (in_array(Auth::user()->role, ['superadmin', 'manager']))
                <li class="treeview">
                    <a href="#">
                        <i class="fas fa-users"></i> <span>Manajemen Pegawai</span>
                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="{{ route('employees.index') }}">
                                <i class="fa fa-circle-o"></i> Data Pegawai
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('employee-attendance.index') }}">
                                <i class="fa fa-circle-o"></i> Absensi Pegawai
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('work-schedules.index') }}">
                                <i class="fa fa-circle-o"></i> Jadwal Kerja
                            </a>
                        </li>
                    </ul>
                </li>
            @endif


            {{-- MODUL PAYROLL --}}
            @if (in_array(Auth::user()->role, ['superadmin', 'manager']))
                <li class="treeview">
                    <a href="#">
                        <i class="fas fa-money-check-alt"></i> <span>Manajemen Payroll</span>
                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="#"><i class="fa fa-circle-o"></i> Slip Gaji</a></li>
                        <li><a href="#"><i class="fa fa-circle-o"></i> Komponen Gaji</a></li>
                        <li><a href="#"><i class="fa fa-circle-o"></i> Rekapitulasi Payroll</a></li>
                    </ul>
                </li>
            @endif

            {{-- PENGGUNA --}}
            @if (Auth::user()->role === 'superadmin')
                <li class="{{ Request::is('user') ? 'active' : '' }}">
                    <a href="{{ route('user.index') }}">
                        <i class="fa fa-user"></i> <span>Manajemen Pengguna</span>
                    </a>
                </li>
            @endif

            {{-- PENGATURAN --}}
            <li class="header">PENGATURAN</li>
            <li>
                <a href="#" class="btn-logout">
                    <i class="fa fa-power-off"></i> <span>Keluar</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </section>
</aside>

{{-- Logout Confirm --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const logoutBtn = document.querySelector('.btn-logout');
        if (logoutBtn) {
            logoutBtn.addEventListener('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Konfirmasi Logout',
                    text: 'Apakah Anda yakin ingin keluar?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, keluar',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('logout-form').submit();
                    }
                });
            });
        }
    });
</script>
