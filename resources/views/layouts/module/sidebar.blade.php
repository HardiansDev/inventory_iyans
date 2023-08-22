<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('temp/dist/img/user2-160x160.jpg') }} " class="img-circle" alt="User Image">
            </div>
            <p></p>
            <div class="pull-left info">
                <p>Hardians</p>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN MENU</li>
            <li>
                <a href="/">
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
                    <li><a href="/product"><i class="fa fa-circle-o"></i> List Data Product</a></li>
                    <li><a href="/product/tambah"><i class="fa fa-circle-o"></i> Tambah Product</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i> <span>Customer</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/customer"><i class="fa fa-circle-o"></i> List Data Customer</a></li>
                    <li><a href="/customer/add_customer"><i class="fa fa-circle-o"></i> Tambah Customer</a></li>
                </ul>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-sign-in"></i> <span>Product In</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-sign-out"></i> <span>Product Out</span>
                </a>
            </li>
            <li>
                <a href="/pic">
                    <i class="fa fa-crosshairs"></i> <span>PIC</span>
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
                <a href="/user">
                    <i class="fa fa-user"></i> <span> User</span>
                </a>
            </li>
            <li class="header">SETTING</li>
            <li>
                <a href="/user">
                    <i class="fa fa-power-off"></i> <span> Log Out</span>
                </a>
            </li>
    </section>
    <!-- /.sidebar -->
</aside>
