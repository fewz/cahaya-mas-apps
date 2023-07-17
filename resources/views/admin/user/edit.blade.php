<!DOCTYPE html>
<html lang="en">
@include('header')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('admin.sidebar', ['activePage' => 'master_user'])
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h1 class="m-0">
                                <a href="{{URL('admin/master_user')}}">Master User</a>
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
                            <h3 class="card-title">Edit User</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="formedit" action="{{URL('admin/master_user/do_edit').'/'.$data_user->id}}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" class="form-control required" name="username" placeholder="Username" value="{{$data_user->username}}">
                                </div>
                                <div class="form-group">
                                    <label>Role</label>
                                    <select class="form-control select2bs4 required" name="id_role" style="width: 100%;">
                                        @foreach ($list_role as $dt )
                                        <option value="{{$dt->id}}">{{$dt->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input id="password" type="password" name="password" class="form-control required" placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input id="cpassword" name="confirmPassword" type="password" class="form-control required" placeholder="Confirm password">
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
    function validateRequiredField() {
        let error = [];
        $('.required').each(function(i, obj) {
            if ($(obj).val() === '') {
                error.push('Field ' + $(obj).attr('name') + ' can\'t be empty');
            }
        });
        if (error.length > 0) {
            swal("Validation Error", error.join('\n'), "warning");
        }
    }

    function submit() {
        validateRequiredField();
        if ($('#cpassword').val() !== $('#password').val()) {
            swal("Failed", "Confirm password wrong", "error");
        } else {
            $('#formedit').submit();
        }
    }
</script>

</html>