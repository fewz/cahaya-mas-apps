<!DOCTYPE html>
<html lang="en">
@include('header')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('admin.sidebar', ['activePage' => 'master_unit'])
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h1 class="m-0">
                                <a href="{{URL('admin/master_unit')}}">Master Unit</a>
                                / Add
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
                            <h3 class="card-title">Add New Unit</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="formadd" action="{{URL('admin/master_unit/do_add')}}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control required" name="name" placeholder="Name">
                                </div>
                                <div class="custom-control custom-checkbox col-4">
                                    <input class="custom-control-input" type="checkbox" id="isReference" onchange="isReferenceToggle()">
                                    <label for="isReference" class="custom-control-label">Using Reference</label>
                                </div>
                                <div id="referencePanel">
                                    <hr>
                                    <div class="form-group">
                                        <label>Unit Reference</label>
                                        <select id="id_reference" class="form-control select2bs4" name="id_reference" style="width: 100%;">
                                            @foreach ($list_unit as $dt )
                                            <option value="{{$dt->id}}">{{$dt->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Qty Reference</label>
                                        <input id="qty_reference" type="number" class="form-control" name="qty_reference" placeholder="Qty Reference">
                                    </div>
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
        if (!$("#isReference").prop('checked')) {
            $("#id_reference").val(null);
            $("#qty_reference").val(null);
        }
        $('#formadd').submit();
    }

    function isReferenceToggle() {

        if ($("#isReference").prop('checked')) {
            $("#referencePanel").addClass('d-block');
            $("#referencePanel").removeClass('d-none');
        } else {
            $("#referencePanel").addClass('d-none');
            $("#referencePanel").removeClass('d-block');
        }
    }


    $(function() {
        isReferenceToggle();
    });
</script>

</html>