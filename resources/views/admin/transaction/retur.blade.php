<!DOCTYPE html>
<html lang="en">
@include('header')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('admin.sidebar', ['activePage' => 'master_retur_transaksi'])
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h1 class="m-0">Retur Transaction</h1>
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
                                    <h3 class="card-title">List Retur Transaction</h3>
                                    <div class="ml-auto">
                                        <a href="{{ URL('admin/master_retur_transaksi/retur_add') }}" class="btn btn-sm btn-primary">ADD <i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <td class="d-none"></td>
                                                <th>Order Number</th>
                                                <th>Transaction Date</th>
                                                <th>Retur Date</th>
                                                <th>Total Retur</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($list_retur as $dt )
                                            <tr>
                                                <td class="d-none">{{$dt->id}}</td>
                                                <td>{{$dt->order_number}}</td>
                                                <td>{{$dt->transaction_date}}</td>
                                                <td>{{$dt->created_date}}</td>
                                                <td>{{$dt->total}}</td>
                                                <td>
                                                    <a href="{{ URL('admin/master_retur_transaksi/view/'.$dt->id_h_transaction) }}" class="btn btn-sm btn-primary">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <!-- <button class="btn btn-sm btn-danger" onclick="clickDelete('{{$dt->id}}')"><i class="fa fa-trash"></i></button> -->
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

@include('script_footer')

<script>
    var table1 = $("#example1").DataTable();
    table1.order([0, 'desc']).draw();

    function filter(filterby, comp) {
        $('.filter-btn').removeClass('active');
        $(comp).addClass('active');

        table1.column(4).search(filterby).draw();

    }

    function openModalUpload(id, grand_total, order_number) {
        $("#upload-order-number").val(order_number);
        $("#upload-grand-total").val(grand_total);
        $("#upload-id").val(id);
        $("#modalUploadBukti").modal();
    }

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