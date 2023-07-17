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
                    <li class="nav-item">
                        <a href="{{ URL('admin/master_inventory') }}" class="nav-link {{$activePage === 'master_inventory' ? 'active' : ''}}">
                            <i class="nav-icon fa fa-box"></i>
                            <p>
                                Inventory
                            </p>
                        </a>
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