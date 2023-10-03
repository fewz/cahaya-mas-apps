<!DOCTYPE html>
<html lang="en">
@include('header')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('admin.sidebar', ['activePage' => 'master_diskon'])
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h1 class="m-0">Master Diskon</h1>
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
                                    <h3 class="card-title">List Diskon</h3>
                                    <div class="ml-auto">
                                        <a href="{{ URL('admin/master_diskon/add') }}" class="btn btn-sm btn-primary">ADD <i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Minimal Beli</th>
                                                <th>Unit</th>
                                                <th>Diskon</th>
                                                <th>Tanggal Mulai Diskon</th>
                                                <th>Tanggal Berakhir Diskon</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data_diskon as $dt )
                                            <tr>
                                                <td>{{$dt->product_name}}</td>
                                                <td>{{$dt->minimal}}</td>
                                                <td>{{$dt->unit}}</td>
                                                <td>{{$dt->potongan}}</td>
                                                <td>{{$dt->start_date}}</td>
                                                <td>{{$dt->end_date}}</td>
                                                <td>
                                                    <a href="{{ URL('admin/master_diskon/edit/'.$dt->id) }}" class="btn btn-sm btn-primary">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <button class="btn btn-sm btn-danger" onclick="clickDelete('{{$dt->id}}')"><i class="fa fa-trash"></i></button>
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
<form id="formDelete" action="{{URL('admin/master_diskon/delete')}}" method="POST">
    @csrf
    <input type="hidden" name="id" id="id_delete">
</form>

@include('script_footer')
<script>
    function clickDelete(id) {
        // confirmation delete
        swal({
                title: "Are you sure want to delete?",
                text: "Once deleted, you will not be able to recover this data!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $('#id_delete').val(id);
                    $('#formDelete').submit();
                }
            });
    }
</script>

</html>