<!DOCTYPE html>
<html lang="en">
@include('header')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('admin.sidebar', ['activePage' => 'purchase_order'])
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h1 class="m-0">Purchase Order</h1>
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
                                    <h3 class="card-title">List Purchase Order</h3>
                                    <div class="ml-auto">
                                        <a href="{{ URL('admin/purchase_order/add') }}" class="btn btn-sm btn-primary">ADD <i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Order Number</th>
                                                <th>Supplier</th>
                                                <th>Created Date</th>
                                                <th>Status</th>
                                                <th>Lunas</th>
                                                <th>Payment Method</th>
                                                <th>Grand Total</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $status = ["Draft", "Diproses Supplier", "Selesai"]; ?>
                                            <?php $lunas = ["Belum Lunas", "Lunas"]; ?>
                                            @foreach ($list_purchase as $dt )
                                            <tr>
                                                <td>{{$dt->order_number}}</td>
                                                <td>{{$dt->supplier_name}}</td>
                                                <td>{{$dt->created_date}}</td>
                                                <td>{{$status[$dt->status]}}</td>
                                                <td>{{$lunas[$dt->lunas]}}</td>
                                                <td>
                                                    @if($dt->status === 2)
                                                    {{$dt->payment_method}}
                                                    @else
                                                    -
                                                    @endif
                                                </td>
                                                <td>
                                                    {{$dt->grand_total > 0 ? number_format($dt->grand_total,0,',','.') : "-"}}
                                                </td>
                                                <td>
                                                    @if($dt->status == 0)
                                                    <a href="{{ URL('admin/purchase_order/edit/'.$dt->id) }}" class="btn btn-sm btn-primary" title="sent to supplier">
                                                        <i class="fa fa-truck"></i>
                                                    </a>
                                                    <button class="btn btn-sm btn-danger" onclick="clickDelete('{{$dt->id}}')" title="delete order"><i class="fa fa-trash"></i></button>
                                                    @elseif ($dt->status == 1)
                                                    <a href="{{ URL('admin/purchase_order/finish/'.$dt->id) }}" class="btn btn-sm btn-primary">
                                                        <i class="fa fa-check" title="terima pesanan"></i>
                                                    </a>
                                                    <a href="{{ URL('admin/purchase_order/view/'.$dt->id) }}" class="btn btn-sm btn-primary">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    @elseif ($dt->status == 2)
                                                    <a href="{{ URL('admin/purchase_order/view/'.$dt->id) }}" class="btn btn-sm btn-primary">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    @if($dt->lunas === 0)
                                                    <div class="btn btn-sm btn-primary" onclick="openModalUpload('{{$dt->id}}', '{{$dt->grand_total}}', '{{$dt->order_number}}')">
                                                        <i class="fa fa-book"></i>
                                                    </div>
                                                    @endif
                                                    @if($dt->lunas === 1 && $dt->payment_method === 'CREDIT')
                                                    <a class="btn btn-sm btn-primary" href="{{URL('bukti_transfer_purchase_order/'.$dt->id)}}" target="_blank">
                                                        <i class="fa fa-book"></i>
                                                    </a>
                                                    @endif
                                                    @endif
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