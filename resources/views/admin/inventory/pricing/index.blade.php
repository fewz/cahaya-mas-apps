<!DOCTYPE html>
<html lang="en">
@include('header')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('admin.sidebar', ['activePage' => 'master_pricing'])
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h1 class="m-0">Master Pricing</h1>
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
                                    <h3 class="card-title">List Pricing</h3>
                                    <div class="ml-auto">
                                        <a href="{{ URL('admin/master_pricing/add') }}" class="btn btn-sm btn-primary">ADD <i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Inventory</th>
                                                <th>Unit</th>
                                                <th>Tier Customer</th>
                                                <th>Sell Price</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($list_pricing as $dt )
                                            <tr>
                                                <td>{{$dt->inventory}}</td>
                                                <td>{{$dt->unit}}</td>
                                                <td>{{$dt->tier_customer}}</td>
                                                <td>{{$dt->sell_price}}</td>
                                                <td>
                                                    <a href="{{ URL('admin/master_pricing/edit/'.$dt->id) }}" class="btn btn-sm btn-primary">
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
<form id="formDelete" action="{{URL('admin/master_pricing/delete')}}" method="POST">
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