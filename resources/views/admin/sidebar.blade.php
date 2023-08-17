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
                    <li class="nav-header">MASTER</li>
                    <li class="nav-item">
                        <a href="{{ URL('admin/master_user') }}" class="nav-link {{$activePage === 'master_user' ? 'active' : ''}}">
                            <i class="nav-icon fas fa-user"></i>
                            <p>
                                User
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ URL('admin/master_role') }}" class="nav-link {{$activePage === 'master_role' ? 'active' : ''}}">
                            <i class="nav-icon fas fa-check"></i>
                            <p>
                                Role
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ URL('admin/master_customer') }}" class="nav-link {{$activePage === 'master_customer' ? 'active' : ''}}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Customer
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ URL('admin/master_supplier') }}" class="nav-link {{$activePage === 'master_supplier' ? 'active' : ''}}">
                            <i class="nav-icon fas fa-truck"></i>
                            <p>
                                Supplier
                            </p>
                        </a>
                    </li>
                    <?php
                    $inventory_menu = ['master_inventory', 'master_category', 'master_unit', 'master_stock', 'master_pricing'];
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
                            <li class="nav-item">
                                <a href="{{ URL('admin/master_inventory') }}" class="nav-link {{$activePage === 'master_inventory' ? 'active' : ''}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Master Inventory</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ URL('admin/master_category') }}" class="nav-link {{$activePage === 'master_category' ? 'active' : ''}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Master Category</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a  href="{{ URL('admin/master_stock') }}" class="nav-link {{$activePage === 'master_stock' ? 'active' : ''}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Stock</p>
                                </a>
                            </li>
                        </ul>
                    </li>
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