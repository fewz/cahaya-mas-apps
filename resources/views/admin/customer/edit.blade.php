<!DOCTYPE html>
<html lang="en">
@include('header')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('admin.sidebar', ['activePage' => 'master_customer'])
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h1 class="m-0">
                                <a href="{{URL('admin/master_customer')}}">Master Customer</a>
                                / Edit
                            </h1>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <!-- /.card -->

                <div class="container-fluid">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Edit Customer</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="formadd" action="{{URL('admin/master_customer/do_edit').'/'.$data_customer->id}}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Code Customer</label>
                                    <input type="text" class="form-control required" name="code" placeholder="Code" value="{{$data_customer->code}}">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control required" name="email" placeholder="Email" value="{{$data_customer->email}}">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input id="password" type="password" class="form-control" name="password" placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input id="cpassword" type="password" class="form-control" name="cpassword" placeholder="Confirm Password">
                                </div>
                                <div class="form-group">
                                    <label>Full Name</label>
                                    <input type="text" class="form-control required" name="full_name" placeholder="Full Name" value="{{$data_customer->full_name}}">
                                </div>
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="text" class="form-control required" name="phone" placeholder="Phone" value="{{$data_customer->phone}}">
                                </div>
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" class="form-control required" name="address" placeholder="Address" value="{{$data_customer->address}}">
                                </div>
                                <div class="form-group">
                                    <label>Tier</label>
                                    <select class="form-control select2bs4" name="tier_customer" style="width: 100%;">
                                        <option value="general" <?php echo $data_customer->tier_customer === 'general' ? 'selected' : ''; ?>>General</option>
                                        <option value="bronze" <?php echo $data_customer->tier_customer === 'bronze' ? 'selected' : ''; ?>>Bronze</option>
                                        <option value="silver" <?php echo $data_customer->tier_customer === 'silver' ? 'selected' : ''; ?>>Silver</option>
                                        <option value="gold" <?php echo $data_customer->tier_customer === 'gold' ? 'selected' : ''; ?>>Gold</option>
                                    </select>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <div class="btn btn-primary" onclick="submit()">Submit</div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
</body>

@include('script_footer')
<script>
    function submit() {
        // submit form
        if (!validateForm()) {
            // validate form required
            return;
        }

        if ($("#password").val() !== $("#cpassword").val()) {
            swal("confirm password tidak sama");
            return;
        }
        $('#formadd').submit();
    }
</script>

</html>