<!DOCTYPE html>
<html lang="en">
@include('header')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('customer.sidebar', ['activePage' => 'profile'])
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h1 class="m-0">Profile</h1>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Profile Image -->
                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
                                    <h3 class="profile-username text-center">{{$user->full_name}}</h3>

                                    <p class="text-muted text-center">{{$user->email}}</p>

                                    <ul class="list-group list-group-unbordered mb-3">
                                        <li class="list-group-item">
                                            <b>Kode Customer</b> <a class="float-right">{{$user->code}}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Tier</b> <a class="float-right">{{$user->tier_customer}}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Poin</b> <a class="float-right">{{$user->poin}}</a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="tab-content">
                                        <form id="formadd" action="{{URL('customer/edit_profile')}}" method="POST">
                                            @csrf
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label>Alamat</label>
                                                    <input type="text" class="form-control" placeholder="Address" value="{{$user->address}}" name="address">
                                                </div>
                                                <div class="form-group">
                                                    <label>Telp</label>
                                                    <input type="text" class="form-control" placeholder="Phone" value="{{$user->phone}}" name="phone">
                                                </div>
                                            </div>
                                            <button class="btn btn-primary">Ubah alamat & Telp</button>
                                        </form>
                                    </div>
                                    <!-- /.tab-content -->
                                </div><!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="tab-content">
                                        <form id="form2" action="{{URL('customer/change_pass')}}" method="POST">
                                            @csrf
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label>Password Lama</label>
                                                    <input type="password" class="form-control" name="old_pass" placeholder="Password Lama">
                                                </div>
                                                <div class="form-group">
                                                    <label>Password Baru</label>
                                                    <input id="pass" type="password" class="form-control" name="password" placeholder="Password Baru">
                                                </div>
                                                <div class="form-group">
                                                    <label>Konfirmasi Password</label>
                                                    <input id="cpass" type="password" class="form-control" name="cpass" placeholder="Konfirmasi Password">
                                                </div>
                                            </div>
                                            <div class="btn btn-primary" onclick="ubahpass()">Ubah Password</div>
                                        </form>
                                    </div>
                                    <!-- /.tab-content -->
                                </div><!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
        </div>
    </div>
</body>
@include('script_footer')
<script>
    function ubahpass() {
        if ($("#cpass").val() !== $("#pass").val()) {
            swal("Konfirmasi password salah");
            return;
        }

        $("#form2").submit();
    }
</script>

</html>