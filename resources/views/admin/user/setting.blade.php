<!DOCTYPE html>
<html lang="en">
@include('header')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('admin.sidebar', ['activePage' => 'master_setting'])
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h1 class="m-0">Master Setting</h1>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <!-- /.card -->

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex">
                                    <h3 class="card-title">LIST SETTING</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nama Setting</th>
                                                <th>Value</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($list_setting as $dt )
                                            <tr>
                                                <td>{{$dt->name}}</td>
                                                <td>{{$dt->value}}</td>
                                                <td>
                                                    <div class="btn btn-sm btn-primary" onclick="openModal('{{$dt->id}}', '{{$dt->name}}', '{{$dt->value}}')">
                                                        <i class="fa fa-edit"></i>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</body>
<div id="modalEdit" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Setting</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formedit" action="{{URL('admin/master_setting/edit')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Setting</label>
                        <input disabled type="text" class="form-control required" id="edit-name">
                    </div>
                    <div class="form-group">
                        <label>Value</label>
                        <input type="number" class="form-control required" id="edit-value" name="value">
                    </div>
                    <input type="hidden" class="form-control required" id="edit-id" name="id">
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Edit" />
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<form id="formDelete" action="{{URL('admin/master_user/delete')}}" method="POST">
    @csrf
    <input type="hidden" name="id" id="id_delete">
</form>

@include('script_footer')
<script>
    function openModal(id, name, value) {
        $("#edit-name").val(name);
        $("#edit-value").val(value);
        $("#edit-id").val(id);
        $("#modalEdit").modal();
    }
</script>

</html>