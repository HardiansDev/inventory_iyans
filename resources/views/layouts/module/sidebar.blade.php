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

            @if (in_array(Auth::user()->role, ['superadmin', 'admin_gudang']))
                <li class="treeview {{ Request::is('product') || Request::is('product/create') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-product-hunt"></i> <span>Master Data</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('product') ? 'active' : '' }}">
                            <a href="{{ route('product.index') }}"><i class="fa fa-circle-o"></i> Data Produk</a>
                        </li>
                        <li class="{{ Request::is('product/create') ? 'active' : '' }}">
                            <a href="{{ route('product.create') }}"><i class="fa fa-circle-o"></i> Tambah Produk</a>
                        </li>
                    </ul>
                </li>
            @endif

            @if (Auth::user()->role === 'superadmin')
                <li class="{{ Request::is('user') ? 'active' : '' }}">
                    <a href="{{ route('user.index') }}">
                        <i class="fa fa-user"></i> <span>Pengguna</span>
                    </a>
                </li>
            @endif

            @if (in_array(Auth::user()->role, ['superadmin', 'admin_gudang']))
                <li class="{{ Request::is('category') ? 'active' : '' }}">
                    <a href="{{ route('category.index') }}">
                        <i class="fa fa-tags"></i> <span>Kategori</span>
                    </a>
                </li>

                <li class="{{ Request::is('supplier') ? 'active' : '' }}">
                    <a href="{{ route('supplier.index') }}">
                        <i class="fa fa-truck"></i> <span>Pemasok</span>
                    </a>
                </li>
            @endif

            @if (in_array(Auth::user()->role, ['admin_gudang', 'superadmin']))
                <li class="{{ Request::is('productin') ? 'active' : '' }}">
                    <a href="{{ route('productin.index') }}">
                        <i class="fa fa-sign-in"></i> <span>Produk Masuk</span>
                    </a>
                </li>
            @endif

            @if (in_array(Auth::user()->role, ['kasir', 'superadmin']))
                <li class="{{ Request::is('sales') ? 'active' : '' }}">
                    <a href="{{ route('sales.index') }}">
                        <i class="fas fa-store"></i> <span>Penjualan</span>
                    </a>
                </li>
                <li class="{{ Request::is('discount') ? 'active' : '' }}">
                    <a href="{{ route('discounts.index') }}" class="nav-link">
                        <i class="fas fa-tags"></i>
                        <span>Manajemen Diskon</span>
                    </a>
                </li>
            @endif

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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const logoutBtn = document.querySelector('.btn-logout');

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
    });
</script>
