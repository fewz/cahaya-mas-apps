<!DOCTYPE html>
<html lang="en">
@include('header')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('admin.sidebar', ['activePage' => 'master_retur_po'])
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h1 class="m-0">
                                <a href="{{URL('admin/master_supplier')}}">Retur PO</a>
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
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Header Purchase Order</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <div class="card-body">
                            <div class="form-group">
                                <label>Purchase Order</label>
                                <input type='text' disabled value="{{$data[0]->order_number}}" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label>Transaction Date</label>
                                <input type='text' disabled value="{{$data[0]->transaction_date}}" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label>Supplier Name</label>
                                <input type='text' disabled value="{{$data[0]->supplier}}" class="form-control" />
                            </div>
                        </div>
                    </div>


                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Barang yg diretur</h3>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th>Unit</th>
                                        <th>Qty</th>
                                        <th>Alasan</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                    <?php $status = ["Pending", "Selesai", "Ditolak"]; ?>
                                    @foreach($data as $dt)
                                    <tr>
                                        <td>{{$dt->inventory}}</td>
                                        <td>{{$dt->unit}}</td>
                                        <td>{{$dt->qty}}</td>
                                        <td>{{$dt->note}}</td>
                                        <td>{{$status[$dt->status]}}</td>
                                        <td>
                                            @if($dt->status == 0)
                                            <button class="btn btn-sm btn-primary" onclick="clickOK('{{$dt->id}}')"><i class="fa fa-check"></i></button>
                                            <button class="btn btn-sm btn-danger" onclick="clickNO('{{$dt->id}}')"><i class="fa fa-close"></i></button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </section>
        </div>
    </div>
</body>
<form id="form2" action="{{URL('admin/purchase_order/update_retur')}}" method="POST">
    @csrf
    <input type="hidden" name="id" id="idr">
    <input type="hidden" name="status" id="statusr">
    <input type="hidden" class="form-control required" value="{{$dt->id_h_purchase_order}}" name="id_h">
</form>

@include('script_footer')
<script>
    let listProduk = [];


    function pochange() {
        let idpo = $("#purchaseorder").val();
        console.log('id', idpo);

        $.get(`/api/get_detail_po/${idpo}`, function(data) {
            console.log('dat', data);

            $("#transaction_date").val(data.payload.header.created_date);
            $("#supplier_name").val(data.payload.header.supplier);

            $("#select2").empty();
            const detail = data.payload.detail;
            detail.forEach((val) => {
                optionText = val.product_name + ' - ' + val.unit;
                optionValue = {
                    id: val.id,
                    max: val.qty,
                    name: val.product_name,
                    unit: val.unit,
                };
                $('#select2').append(new Option(optionText, JSON.stringify(optionValue)));
            });
        }).fail(function(error) {
            console.error('Error fetching API data', error);
        });
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

    function submit() {
        console.log('l', listProduk);
        const a = JSON.stringify(listProduk);

        $("#list_produk").val(a);
        $("#id_h_po").val($("#purchaseorder").val());

        // const list_produk = listProduk.map(val => val.split('-', 1)[0]);
        // $("#list_produk").val(list_produk);

        $('#formadd').submit();
    }

    function tambah() {
        const produkBaru = JSON.parse($("#select2").val());

        if (listProduk.filter(val => val.id === produkBaru.id).length > 0) {
            swal("Produk sudah ada", "", "warning");
            return;
        }
        if ($("#qty").val() > parseInt(produkBaru.max)) {
            swal("Qty melebihi batas", "", "warning");
            return;
        }
        if ($("#alasan").val() === '') {
            swal("alasan kosong", "", "warning");
            return;
        }
        const tmp = {
            id: produkBaru.id,
            name: produkBaru.name,
            unit: produkBaru.unit,
            qty: $("#qty").val(),
            note: $("#alasan").val()
        }
        listProduk.push(tmp);
        console.log('listpr', listProduk);
        updateTable();
    }

    function updateTable() {

        // Clear the table body
        $('#tableBody').empty();
        // Populate the table with selected items and their stored values
        listProduk.forEach((item, i) => {
            const row = `<tr>
                            <td>${item.name}</td>
                            <td>${item.unit}</td>
                            <td>${item.qty}</td>
                            <td>${item.note}</td>
                            <td><button class="btn btn-sm btn-danger" onclick="clickDelete(${i})"><i class="fa fa-trash"></i></button></td>
                        </tr>`;
            $('#tableBody').append(row);
        });
    }

    function clickDelete(index) {
        listProduk.splice(index, 1);
        updateTable();
    }

    $(function() {
        pochange();

    });
</script>

</html>