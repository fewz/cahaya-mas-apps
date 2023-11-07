<!DOCTYPE html>
<html lang="en">
@include('header')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('admin.sidebar', ['activePage' => 'pengiriman'])
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h1 class="m-0">
                                <a href="{{URL('admin/pengiriman')}}">Pengiriman</a>
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
                            <h3 class="card-title">Add New Pengiriman</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="formadd" action="{{URL('admin/pengiriman/do_add')}}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Delivery Date</label>
                                    <input type="date" class="form-control required" name="delivery_date">
                                </div>
                                <div class="form-group">
                                    <label>Sopir</label>
                                    <input type="text" class="form-control required" name="driver">
                                </div>
                            </div>
                            <input type="hidden" name="transaksi" id="input_transaksi" />
                            <input type="hidden" name="barang_muat" id="input_barang_muat" />
                            <!-- /.card-body -->
                        </form>
                    </div>

                    <div id="container3" class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Tambah Barang muatan</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Transaksi yg perlu dikirim</label>
                                <table class="table table-bordered table-striped" id="example1">
                                    <thead>
                                        <tr>
                                            <th>Order Number</th>
                                            <th>Customer</th>
                                            <th>Tanggal Transaksi</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($list_transaction as $dt )
                                        <tr>
                                            <td>{{$dt->order_number}}</td>
                                            <td>{{$dt->customer_name}}</td>
                                            <td>{{$dt->created_date}}</td>
                                            <td>
                                                <div class="btn btn-primary" onclick="getDetail(<?php echo $dt->id; ?>)">Detail</div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <!-- <select class="form-control select2bs4" id="id_transaction" name="id_transaction" style="width: 100%;" onchange="transaksiChange()">
                                    @foreach ($list_transaction as $dt )
                                    <option value="{{$dt->id}}">{{$dt->order_number}}</option>
                                    @endforeach
                                </select> -->
                            </div>
                            <hr>
                            <div id="detail_transaksi" class="d-none">
                                <label>DETAIL TRANSAKSI YANG AKAN DIMUAT</label>
                                <div class="row mt-3">
                                    <div class="col-6">
                                        <label>Created Date</label>
                                        <p id="label_created_date"></p>
                                    </div>
                                    <div class="col-6">
                                        <label>Customer</label>
                                        <p id="label_customer"></p>
                                    </div>
                                    <div class="col-6">
                                        <label>Alamat</label>
                                        <p id="label_alamat"></p>
                                    </div>
                                </div>
                                <div class="form-group mt-3">
                                    <label>List barang yg dibeli</label>
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Kode</th>
                                                <th>Nama</th>
                                                <th>Unit</th>
                                                <th>Qty</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tableBody">
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer">
                                    <div class="btn btn-primary" onclick="muat()">Tambah ke muat</div>
                                </div>
                            </div>
                        </div>

                        <!-- /.card-body -->
                    </div>

                    <div id="container3" class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Barang yang dimuat</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group mt-3">
                                <label>Transaksi yg akan dikirim</label>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Kode Transaksi</th>
                                            <th>Created Date</th>
                                            <th>Customer</th>
                                            <th>Alamat</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableBody2">
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group mt-3">
                                <label>List barang yg dimuat</label>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Kode Transaksi</th>
                                            <th>Kode Barang</th>
                                            <th>Nama</th>
                                            <th>Unit</th>
                                            <th>Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableBody3">
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- /.card-body -->
                        <div class="card-footer">
                            <div class="btn btn-primary" onclick="submit()">Buat Surat Jalan</div>
                        </div>
                    </div>
                </div>


            </section>
        </div>
    </div>
</body>

@include('script_footer')
<script>
    $(function() {
        // transaksiChange();
    });

    function transaksiChange() {
        const id = $("#id_transaction").val();
        getDetail(id);
    }
    let header, detail;
    let transaksi = [];
    let barang_muat = [];

    function getDetail(id) {
        $("#detail_transaksi").removeClass('d-none');
        console.log('daf', id);

        $.get(`/api/get_detail_transaction/${id}`, function(data) {

            header = data.payload.header;
            detail = data.payload.detail;
            console.log('da', detail);
            $("#label_created_date").html(header.created_date);
            $("#label_customer").html(header.customer);
            $("#label_alamat").html(header.address);


            // Clear the table body
            $('#tableBody').empty();
            // Populate the table with selected items and their stored values
            detail.forEach((item) => {
                const row = `<tr>
                            <td>${item.product_code}</td>
                            <td>${item.product_name}</td>
                            <td>${item.unit}</td>
                            <td>${item.qty}</td>
                        </tr>`;
                $('#tableBody').append(row);
            });
        }).fail(function(error) {
            console.error('Error fetching API data', error);
        });
    }

    function muat() {
        console.log('t', transaksi);

        let exist = false;
        transaksi.forEach((val) => {
            if (val.id === header.id) {
                exist = true;
                return;
            }
        });

        if (exist) {
            swal('Transaksi sudah ditambahkan');
            return;
        }

        header.detail = detail;
        transaksi.push(header);
        tambah_muatan(header, detail);
        updateTable();
    }

    function delete_transaksi(id) {
        const deletedTransaksi = transaksi.filter((val) => val.id === id);
        console.log('t', deletedTransaksi);
        console.log('t', id);


        barang_muat.forEach((brg, index, object) => {
            console.log('as', brg);

            if (brg.id_h_transaction === id) {
                object.splice(index, 1);
            }
        });
        transaksi = transaksi.filter((val) => val.id !== id);

        updateTable();
    }

    function tambah_muatan(header, detail) {
        detail.forEach((val) => {
            barang_muat.push({
                ...val,
                order_number: header.order_number
            });
        });
    }

    function updateTable() {
        console.log('transaksi', transaksi);
        console.log('brg', barang_muat);


        $("#tableBody2").empty();
        transaksi.forEach((val) => {
            const row = `<tr>
                            <td>${val.order_number}</td>
                            <td>${val.created_date}</td>
                            <td>${val.customer}</td>
                            <td>${val.address}</td>
                            <td>
                                <a href="{{ URL('admin/transaction/view') }}/${val.id}" class="btn btn-primary" target="_blank"><i class="fa fa-eye"></i></a>
                                <div class="btn btn-danger" onclick="delete_transaksi(${val.id})"><i class="fa fa-trash"></i></div>
                            </td>
                        </tr>`;
            $('#tableBody2').append(row);
        })

        $("#tableBody3").empty();
        barang_muat.forEach((val) => {
            const row = `<tr>
                            <td>${val.order_number}</td>
                            <td>${val.product_code}</td>
                            <td>${val.product_name}</td>
                            <td>${val.unit}</td>
                            <td>${val.qty}</td>
                        </tr>`;
            $('#tableBody3').append(row);
        })
    }

    function submit() {
        console.log('brg', barang_muat);
        console.log('tra', transaksi);
        // submit form
        if (!validateForm()) {
            // validate form required
            return;
        }
        $("#input_barang_muat").val(JSON.stringify(barang_muat));
        $("#input_transaksi").val(JSON.stringify(transaksi));
        $('#formadd').submit();
    }
</script>

</html>