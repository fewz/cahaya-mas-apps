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
                    <li class="nav-header">MENU</li>
                    <li class="nav-item">
                        <a href="{{ URL('customer/pesanan_saya') }}" class="nav-link {{$activePage === 'pesanan_saya' ? 'active' : ''}}">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>
                                Pesanan Saya
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ URL('customer/profile') }}" class="nav-link {{$activePage === 'profile' ? 'active' : ''}}">
                            <i class="nav-icon fas fa-user"></i>
                            <p>
                                Profile
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
                        <a href="#" class="d-block">{{$user->full_name}}</a>
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