<aside class="main-sidebar">
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('temp/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->name }}</p>
                <label
                    class="badge
                    @if (Auth::user()->role === 'superadmin') bg-success
                    @elseif(Auth::user()->role === 'admin_gudang') bg-primary
                    @elseif(Auth::user()->role === 'kasir') bg-warning
                    @elseif(Auth::user()->role === 'manager') bg-info
                    @else bg-secondary @endif
                    text-white px-2 py-1 rounded">
                    {{ ucfirst(Auth::user()->role) }}
                </label>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN MENU</li>

            <li>
                <a href="{{ route('dashboard') }}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-product-hunt"></i> <span>Product</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('product.index') }}"><i class="fa fa-circle-o"></i> List Data Product</a></li>
                    <li><a href="{{ route('product.create') }}"><i class="fa fa-circle-o"></i> Tambah Product</a></li>
                </ul>
            </li>

            <li>
                <a href="{{ route('user.index') }}">
                    <i class="fa fa-user"></i> <span>User</span>
                </a>
            </li>

            <li>
                <a href="{{ route('category.index') }}">
                    <i class="fa fa-tags"></i> <span>Category</span>
                </a>
            </li>

            <li>
                <a href="{{ route('supplier.index') }}">
                    <i class="fa fa-truck"></i> <span>Supplier</span>
                </a>
            </li>

            <li>
                <a href="{{ route('pic.index') }}">
                    <i class="fa fa-crosshairs"></i> <span>PIC</span>
                </a>
            </li>

            <li>
                <a href="{{ route('product-in.index') }}">
                    <i class="fa fa-sign-in"></i> <span>Product In</span>
                </a>
            </li>

            <li>
                <a href="{{ route('product-out.index') }}">
                    <i class="fa fa-sign-out"></i> <span>Product Out</span>
                </a>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i> <span>Customer</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('customer.index') }}"><i class="fa fa-circle-o"></i> List Data Customer</a>
                    </li>
                    <li><a href="{{ route('customer.create') }}"><i class="fa fa-circle-o"></i> Tambah Customer</a>
                    </li>
                </ul>
            </li>

            <li class="header">SETTING</li>
            <li>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-power-off"></i> <span> Log Out</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </section>
</aside>
