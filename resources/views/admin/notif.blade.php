<!DOCTYPE html>
<html lang="en">
@include('header')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('admin.sidebar', ['activePage' => 'dashboard'])
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h1 class="m-0">Notifikasi</h1>
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
                                    <h3 class="card-title">List Notif</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="d-flex mb-3">
                                        <div class="btn btn-info mx-2 filter-btn active" onclick="filter('',this)">All</div>
                                        <div id="piutang" class="btn btn-info mx-2 filter-btn" onclick="filter('Piutang',this)">Piutang</div>
                                        <div id="hutang" class="btn btn-info mx-2 filter-btn" onclick="filter('Hutang',this)">Hutang</div>
                                    </div>
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Tanggal Order</th>
                                                <th>Type</th>
                                                <th>Due Date</th>
                                                <th>Order Number</th>
                                                <th>Customer/Supplier</th>
                                                <th>Phone</th>
                                                <th>Address</th>
                                                <th>Grand Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($notif as $dt )
                                            <tr>
                                                <td>{{$dt->created_date}}</td>
                                                <td>{{$dt->type}}</td>
                                                <td>{{$dt->due_date}}</td>
                                                <td>{{$dt->order_number}}</td>
                                                <td>{{$dt->name}}</td>
                                                <td>{{$dt->phone}}</td>
                                                <td>{{$dt->address}}</td>
                                                <td>{{number_format($dt->grand_total,0,',','.')}}</td>
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
<div id="modalUploadBukti" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Upload Bukti Transfer</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formedit" action="{{URL('admin/purchase_order/upload_bukti_transfer')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Order Number</label>
                        <input disabled type="text" class="form-control required" id="upload-order-number">
                    </div>
                    <div class="form-group">
                        <label>Total yang harus dibayar</label>
                        <input disabled type="text" class="form-control required" id="upload-grand-total">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Bayar</label><br>
                        <input class="form-control required" type="date" name="tanggal_bayar">
                    </div>
                    <div class="form-group">
                        <label>Bukti Transfer</label><br>
                        <input class="required" type="file" name="file" accept="image/png, image/jpeg">
                    </div>
                    <input type="hidden" class="form-control required" id="upload-id" name="id">
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Upload Bukti Transfer" />
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<form id="formDelete" action="{{URL('admin/purchase_order/delete')}}" method="POST">
    @csrf
    <input type="hidden" name="id" id="id_delete">
</form>

@include('script_footer')

<script>
    var table1 = $("#example1").DataTable();
    table1.order([0, 'desc']).draw();

    function filter(filterby, comp) {

        $('.filter-btn').removeClass('active');
        $(comp).addClass('active');

        table1.column(1).search(filterby).draw();

    }
    $(function() {
        var filter = '<?php echo $filter; ?>';
        console.log('f', filter);

        if (filter === 'piutang') {
            $('.filter-btn').removeClass('active');
            $("#piutang").addClass('active');
            table1.column(1).search('piutang').draw();
        } else if (filter === 'hutang') {
            $('.filter-btn').removeClass('active');
            $("#hutang").addClass('active');
            table1.column(1).search('hutang').draw();
        }
    });
</script>

</html>