<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ URL::asset('assets/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Cahaya Mas</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <div class="d-flex flex-column h-100">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column">
                    <li class="nav-header">DASHBOARD</li>
                    <li class="nav-item">
                        <a href="{{ URL('admin/dashboard') }}" class="nav-link {{$activePage === 'dashboard' ? 'active' : ''}}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                    <li class="nav-header">TRANSAKSI</li>
                    @if(Session::get('TRANSACTION'))
                    <li class="nav-item">
                        <a href="{{ URL('admin/transaction') }}" class="nav-link {{$activePage === 'transaction' ? 'active' : ''}}">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>
                                Transaksi
                            </p>
                        </a>
                    </li>
                    @endif
                    @if(Session::get('PENGIRIMAN'))
                    <li class="nav-item">
                        <a href="{{ URL('admin/pengiriman') }}" class="nav-link {{$activePage === 'pengiriman' ? 'active' : ''}}">
                            <i class="nav-icon fas fa-truck"></i>
                            <p>
                                Pengiriman
                            </p>
                        </a>
                    </li>
                    @endif
                    <li class="nav-header">MASTER</li>
                    @if(Session::get('MASTER_USER'))
                    <li class="nav-item">
                        <a href="{{ URL('admin/master_user') }}" class="nav-link {{$activePage === 'master_user' ? 'active' : ''}}">
                            <i class="nav-icon fas fa-user"></i>
                            <p>
                                User
                            </p>
                        </a>
                    </li>
                    @endif
                    @if(Session::get('MASTER_ROLE'))
                    <li class="nav-item">
                        <a href="{{ URL('admin/master_role') }}" class="nav-link {{$activePage === 'master_role' ? 'active' : ''}}">
                            <i class="nav-icon fas fa-check"></i>
                            <p>
                                Role
                            </p>
                        </a>
                    </li>
                    @endif
                    @if(Session::get('MASTER_CUSTOMER'))
                    <li class="nav-item">
                        <a href="{{ URL('admin/master_customer') }}" class="nav-link {{$activePage === 'master_customer' ? 'active' : ''}}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Customer
                            </p>
                        </a>
                    </li>
                    @if(Session::get('PURCHASE_ORDER'))
                    <li class="nav-item">
                        <a href="{{ URL('admin/purchase_order') }}" class="nav-link {{$activePage === 'purchase_order' ? 'active' : ''}}">
                            <i class="fa fa-truck nav-icon"></i>
                            <p>Purchase Order</p>
                        </a>
                    </li>
                    @endif
                    @endif

                    @if(Session::get('MASTER_SUPPLIER'))
                    <li class="nav-item">
                        <a href="{{ URL('admin/master_supplier') }}" class="nav-link {{$activePage === 'master_supplier' ? 'active' : ''}}">
                            <i class="fa fa-industry nav-icon"></i>
                            <p>Master Supplier</p>
                        </a>
                    </li>
                    @endif
                    @if(Session::get('MASTER_DISKON'))
                    <li class="nav-item">
                        <a href="{{ URL('admin/master_diskon') }}" class="nav-link {{$activePage === 'master_diskon' ? 'active' : ''}}">
                            <i class="fa fa-percentage nav-icon"></i>
                            <p>Master Diskon</p>
                        </a>
                    </li>
                    @endif
                    <?php
                    $inventory_menu = ['master_inventory', 'master_category', 'penyesuaian_stok', 'stok_opname'];
                    ?>
                    <li class="nav-item expandable {{in_array($activePage, $inventory_menu)  ? 'menu-is-opening menu-open' : ''}}">
                        <a href="#" class="nav-link {{in_array($activePage, $inventory_menu) ? 'active' : ''}}">
                            <i class="nav-icon fa fa-box"></i>
                            <p>
                                Inventory
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if(Session::get('MASTER_INVENTORY'))
                            <li class="nav-item">
                                <a href="{{ URL('admin/master_inventory') }}" class="nav-link {{$activePage === 'master_inventory' ? 'active' : ''}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Master Inventory</p>
                                </a>
                            </li>
                            @endif
                            @if(Session::get('MASTER_CATEGORY'))
                            <li class="nav-item">
                                <a href="{{ URL('admin/master_category') }}" class="nav-link {{$activePage === 'master_category' ? 'active' : ''}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Master Category</p>
                                </a>
                            </li>
                            @endif
                            @if(Session::get('STOK_OPNAME'))
                            <li class="nav-item">
                                <a href="{{ URL('admin/stok_opname') }}" class="nav-link {{$activePage === 'stok_opname' ? 'active' : ''}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Stok Opname</p>
                                </a>
                            </li>
                            @endif
                            @if(Session::get('PENYESUAIAN_STOK'))
                            <li class="nav-item">
                                <a href="{{ URL('admin/penyesuaian_stok') }}" class="nav-link {{$activePage === 'penyesuaian_stok' ? 'active' : ''}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Penyesuaian Stok</p>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </li>

                    <?php
                    $laporan_menu = ['laporan_barang', 'laporan_penjualan', 'laporan_pembelian'];
                    ?>
                    <li class="nav-item expandable {{in_array($activePage, $laporan_menu)  ? 'menu-is-opening menu-open' : ''}}">
                        <a href="#" class="nav-link {{in_array($activePage, $laporan_menu) ? 'active' : ''}}">
                            <i class="nav-icon fa fa-book"></i>
                            <p>
                                Laporan
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if(Session::get('LAPORAN_BARANG'))
                            <li class="nav-item">
                                <a href="{{ URL('admin/laporan_barang') }}" class="nav-link {{$activePage === 'laporan_barang' ? 'active' : ''}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Laporan Barang</p>
                                </a>
                            </li>
                            @endif
                            @if(Session::get('LAPORAN_PENJUALAN'))
                            <li class="nav-item">
                                <a href="{{ URL('admin/laporan_penjualan') }}" class="nav-link {{$activePage === 'laporan_penjualan' ? 'active' : ''}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Laporan Penjualan</p>
                                </a>
                            </li>
                            @endif
                            @if(Session::get('LAPORAN_PEMBELIAN'))
                            <li class="nav-item">
                                <a href="{{ URL('admin/laporan_pembelian') }}" class="nav-link {{$activePage === 'laporan_pembelian' ? 'active' : ''}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Laporan Pembelian</p>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </li>
                    @if(Session::get('MASTER_SETTING'))
                    <li class="nav-item">
                        <a href="{{ URL('admin/master_setting') }}" class="nav-link {{$activePage === 'master_setting' ? 'active' : ''}}">
                            <i class="fa fa-wrench nav-icon"></i>
                            <p>Master Setting</p>
                        </a>
                    </li>
                    @endif
                </ul>
            </nav>
            <div class="mt-auto">
                <div class="user-panel pb-3 d-flex border-none">
                    <div class="image" style="padding-left:0">
                        <img src="{{URL::asset('assets/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{$user->username}}</a>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="ml-auto">
                        @csrf
                        <button class="btn btn-sm btn-danger"><i class="fa fa-power-off"></i></button>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<script>
    //event expand menu
    function initializeExpandableMenu() {
        const $field = $(".expandable");
        $field.each((_, element) => {
            element.addEventListener('click', (evt) => {
                const $element = $(element);
                console.log('asd ', $element.find('nav-treeview'));

                if ($element.hasClass('menu-open')) {
                    $element.removeClass('menu-is-opening menu-open');
                } else {
                    $element.addClass('menu-is-opening menu-open');
                }
            });
        });
    }
    $(function() {
        initializeExpandableMenu();
    });
</script>