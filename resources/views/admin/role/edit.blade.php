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
                                <a href="{{URL('admin/master_role')}}">Master Role</a>
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
                            <h3 class="card-title">Edit Role</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="formedit" action="{{URL('admin/master_role/do_edit').'/'.$data_role->id}}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Role Name</label>
                                    <input required type="text" class="form-control" name="name" placeholder="Role Name" value="{{$data_role->name}}">
                                </div>
                                <h5 class="mt-4 mb-2">Permission</h5>
                                <div class="row p-2">
                                    @foreach ($list_permission as $permission )
                                    <div class="custom-control custom-checkbox col-4">
                                        <input class="custom-control-input" type="checkbox" id="{{$permission->id}}" name="permission[]" value="{{$permission->id}}">
                                        <label for="{{$permission->id}}" class="custom-control-label">{{$permission->description}}</label>
                                    </div>
                                    @endforeach
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
        $('#formedit').submit();
    }

    function initializeCheckBox() {
        // initialize data to checkbox
        const data_permission = <?php echo $data_permission ?>;
        console.log(data_permission);
        const $field = $("input:checkbox");
        $field.each((_, element) => {
            const $element = $(element);

            const isExist = data_permission.includes(parseInt($element.attr('id')));
            if (isExist) {
            // check checkbox if exist
                $element.attr("checked", true);
            }
        });
    }

    $(function() {
        initializeCheckBox();
    });
</script>

</html>