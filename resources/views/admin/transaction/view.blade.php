<!DOCTYPE html>
<html lang="en">
@include('header')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('admin.sidebar', ['activePage' => 'transaction'])
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h1 class="m-0">
                                <a href="{{URL('admin/transaction')}}">Transaksi</a>
                                / View
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
                    <div id="container1" class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Transaksi</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="formadd" action="{{URL('admin/transaction/do_add')}}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Order Number</label>
                                    <input type="text" class="form-control" placeholder="Order Number" value="{{$data_order->order_number}}" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Order</label>
                                    <input type="text" class="form-control" name="created_date" placeholder="Tanggal Order" value="{{$data_order->created_date}}" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Payment Method</label>
                                    <input type="text" class="form-control" name="created_date" placeholder="Tanggal Order" value="{{$data_order->payment_method}}" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Tipe Transaksi</label>
                                    <input type="text" class="form-control" name="created_date" placeholder="Tanggal Order" value="{{$data_order->transaction_type}}" disabled>
                                </div>
                                <input type="hidden" id="list_produk" name="list_produk">
                                <input type="hidden" id="grand_total" name="grand_total">
                                <input type="hidden" id="id_customer" name="id_customer">
                            </div>
                        </form>
                    </div>

                    <div id="container2" class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Customer</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Customer</label>
                                <input type="text" class="form-control required" value="{{$data_customer->full_name}}" disabled>
                            </div>
                            <div class="form-group">
                                <label>Kode Customer</label>
                                <input type="text" class="form-control required" value="{{$data_customer->code}}" disabled>
                            </div>
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" class="form-control required" value="{{$data_customer->phone}}" disabled>
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <input type="text" class="form-control required" value="{{$data_customer->address}}" disabled>
                            </div>
                            <div class="form-group">
                                <label>Tier</label>
                                <input type="text" class="form-control required" name="order_number" placeholder="Order Number" value="{{$data_customer->tier_customer}}" disabled>
                            </div>
                        </div>
                    </div>

                    <div id="container3" class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Detail Belanja</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group mt-3">
                                <label>Keranjang Belanja</label>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Kode</th>
                                            <th>Nama</th>
                                            <th>Unit</th>
                                            <th>Qty</th>
                                            <th>Harga</th>
                                            <th>Diskon</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableBody">
                                        @foreach ($data_product as $data )
                                        <tr>
                                            <td>{{$data->product_code}}</td>
                                            <td>{{$data->product_name}}</td>
                                            <td>{{$data->unit_name}}</td>
                                            <td>{{$data->qty}}</td>
                                            <td>{{number_format($data->sell_price,0,"",".")}}</td>
                                            <td>{{number_format($data->diskon,0,"",".")}}</td>
                                            <td>{{number_format($data->sub_total,0,"",".")}}</td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="6" style="font-weight:bold; text-align:right;">Diskon Poin</td>
                                            <td>{{number_format($data_order->diskon_poin,0,"",".")}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" style="font-weight:bold; text-align:right;">Grand Total</td>
                                            <td>{{number_format($data_order->grand_total,0,"",".")}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- /.card-body -->
                    </div>

                    <div id="container3" class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Detail Retur</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group mt-3">
                                <label>Retur Barang</label>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Kode</th>
                                            <th>Nama</th>
                                            <th>Unit</th>
                                            <th>Qty</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableBody">
                                        <?php $status = ["Pending", "Selesai", "Ditolak"]; ?>
                                        @foreach ($data_retur as $data )
                                        <tr>
                                            <td>{{$data->product_code}}</td>
                                            <td>{{$data->product_name}}</td>
                                            <td>{{$data->unit_name}}</td>
                                            <td>{{$data->qty}}</td>
                                            <td>{{$status[$data->status]}}</td>
                                            <td>
                                                @if($data->status == 0)
                                                <button class="btn btn-sm btn-primary" onclick="clickOK('{{$data->id}}')"><i class="fa fa-check"></i></button>
                                                <button class="btn btn-sm btn-danger" onclick="clickNO('{{$data->id}}')"><i class="fa fa-close"></i></button>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="btn btn-primary" onclick="openModal()">Tambah Retur</div>
                            </div>
                        </div>

                        <!-- /.card-body -->
                    </div>
                </div>
            </section>
        </div>
    </div>
</body>
<div id="modal1" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Retur</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form" action="{{URL('admin/transaction/add_retur')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Barang</label>
                        <select class="form-control select2bs4" name="id_d_transaction" style="width: 100%;" onchange="d_transaction_change(this)">
                            @foreach ($data_product as $dt )
                            <option value="{{$dt->id}}">{{$dt->product_name}} - {{$dt->unit_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Qty</label>
                        <input type="number" class="form-control required" id="qty" name="qty" onkeyup="qtyChange()">
                    </div>
                    <input type="hidden" class="form-control required" value="{{$data_order->id}}" name="id_h">
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Tambah Retur" />
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<form id="form2" action="{{URL('admin/transaction/update_retur')}}" method="POST">
    @csrf
    <input type="hidden" name="id" id="idr">
    <input type="hidden" name="status" id="statusr">
    <input type="hidden" class="form-control required" value="{{$data_order->id}}" name="id_h">
</form>
@include('script_footer')
<script>
    data = <?php echo $data_product; ?>;

    function openModal() {
        $("#modal1").modal();
    }

    function d_transaction_change(comp) {
        const max = data.filter((v) => v.id == $(comp).val())[0];
        $("#qty").attr('max', max.qty);
        qtyChange();
    }

    function qtyChange() {

        const val = $("#qty").val();
        const max = $("#qty").attr('max');
        if (parseInt(val) > parseInt(max)) {
            $("#qty").val(max);
        }
    }

    function clickNO(id) {
        swal({
                title: "Apakah anda yakin ingin membatalkan refund?",
                text: "refund akan ditolak",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $('#idr').val(id);
                    $('#statusr').val(2);
                    $('#form2').submit();
                }
            });
    }

    function clickOK(id) {
        swal({
                title: "Apakah anda yakin ingin menyelesaikan refund ini?",
                text: "pastikan barang sudah dikembalikan ke customer",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $('#idr').val(id);
                    $('#statusr').val(1);
                    $('#form2').submit();
                }
            });
    }

    $(function() {
        $("#qty").attr('max', data[0].qty);
    });
</script>

</html>