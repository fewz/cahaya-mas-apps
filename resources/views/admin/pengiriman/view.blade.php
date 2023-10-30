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
                            <h3 class="card-title">Detail Pengiriman</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <div class="card-body">
                            <div class="form-group">
                                <label>Kode Delivery</label>
                                <input type="text" class="form-control required" name="delivery_date" disabled value="{{$h_pengiriman->code}}">
                            </div>
                            <div class="form-group">
                                <label>Delivery Date</label>
                                <input type="date" class="form-control required" name="delivery_date" disabled value="{{$h_pengiriman->delivery_date}}">
                            </div>
                            <div class="form-group">
                                <label>Sopir</label>
                                <input type="text" class="form-control required" name="delivery_date" disabled value="{{$h_pengiriman->driver}}">
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <?php $status = ["Siap Jalan", "Dikirim", "Selesai"]; ?>
                                <input type="text" class="form-control required" name="delivery_date" disabled value="{{$status[$h_pengiriman->status]}}">
                            </div>
                        </div>
                    </div>

                    <div id="container3" class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">List transaksi yg dikirim</h3>
                        </div>
                        <div class="card-body">

                            <div class="form-group mt-3">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Order Number</th>
                                            <th>Customer</th>
                                            <th>Created Date</th>
                                            <th>Alamat</th>
                                            <th class="no-print">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableBody">
                                        @foreach ($list_transaksi as $transaksi)
                                        <tr>
                                            <td>{{$transaksi->order_number}}</td>
                                            <td>{{$transaksi->customer_name}}</td>
                                            <td>{{$transaksi->created_date}}</td>
                                            <td>{{$transaksi->alamat}}</td>
                                            <td class="no-print">
                                                <a href="{{ URL('admin/transaction/view/'.$transaksi->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ URL('admin/pengiriman/surat_jalan/'.$transaksi->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="fa fa-envelope"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div id="container3" class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Barang yang dimuat</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group mt-3">
                                <label>List barang yg dimuat</label>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Order Number</th>
                                            <th>Kode Barang</th>
                                            <th>Nama</th>
                                            <th>Unit</th>
                                            <th>Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableBody3">
                                        @foreach ($barang_muat as $b)
                                        <tr>
                                            <td>{{$b->order_number}}</td>
                                            <td>{{$b->code_inventory}}</td>
                                            <td>{{$b->inventory}}</td>
                                            <td>{{$b->unit}}</td>
                                            <td>{{$b->qty}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- /.card-body -->
                        <div class="card-footer no-print">
                            <div class="row">
                                <div class="col-6">
                                    <div class="btn btn-default" onclick="window.print();"><i class="fas fa-print"></i> Cetak Rincian Pengiriman</div>
                                </div>
                                <div class="col-6 float-right text-right">
                                    @if($h_pengiriman->status === 0)
                                    <form action="{{URL('admin/pengiriman/do_kirim')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$h_pengiriman->id}}">
                                        <button class="btn btn-primary" onclick="kirim()">Mulai Pengiriman</button>
                                    </form>
                                    @elseif($h_pengiriman->status === 1)
                                    <form action="{{URL('admin/pengiriman/do_finish')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$h_pengiriman->id}}">
                                        <button class="btn btn-primary" onclick="kirim()">Pengiriman Selesai</button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hidden-but-printable">
                    <div class="row" style="margin-top:100px;">
                        <div class="col-4 text-center font-weight-bold">
                            Kepala Gudang
                        </div>
                        <div class="col-4">
                        </div>
                        <div class="col-4 text-center font-weight-bold">
                            Sopir
                        </div>
                    </div>
                    <div class="row" style="margin-top:70px;">
                        <div class="col-4 text-center">
                            _______________________
                        </div>
                        <div class="col-4">
                        </div>
                        <div class="col-4 text-center">
                            _______________________
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
        transaksiChange();
    });

    function transaksiChange() {
        const id = $("#id_transaction").val();
        getDetail(id);
    }
    let header, detail;
    let transaksi = [];
    let barang_muat = [];

    function getDetail(id) {
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
        tambah_muatan(detail);
        updateTable();
    }

    function delete_transaksi(id) {
        const deletedTransaksi = transaksi.filter((val) => val.id === id);
        console.log('t', deletedTransaksi);


        deletedTransaksi[0].detail.forEach((val) => {
            barang_muat.forEach((brg, index, object) => {
                if (brg.id_inventory === val.id_inventory) {
                    brg.qty -= val.qty;
                    if (brg.qty <= 0) {
                        object.splice(index, 1);
                    }
                }
            });
        });
        transaksi = transaksi.filter((val) => val.id !== id);

        updateTable();
    }

    function tambah_muatan(detail) {
        detail.forEach((val) => {
            barang_muat.push({
                ...val,
                order_number: header.order_number
            });
        });
        // detail.forEach((val) => {
        //     let ada = false;
        //     barang_muat.forEach((brg) => {
        //         if (val.id_inventory === brg.id_inventory) {
        //             brg.qty += val.qty;
        //             ada = true;
        //         }
        //     });
        //     if (!ada) {
        //         barang_muat.push({
        //             ...val
        //         });
        //     }
        // });
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