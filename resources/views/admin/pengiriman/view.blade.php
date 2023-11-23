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
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">

                            <!-- Main content -->
                            <div class="invoice p-3 mb-3">
                                <!-- title row -->
                                <div class="row">
                                    <div class="col-12">
                                        <h4>
                                            <i class="fas fa-globe"></i> Cahaya Mas. ({{$h_pengiriman->code}})
                                            <small class="float-right">Tanggal Cetak: {{now()}}</small>
                                        </h4>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- info row -->
                                <div class="row invoice-info">
                                    <div class="col-sm-6 invoice-col">
                                        Dari
                                        <address>
                                            <strong>Cahaya Mas.</strong><br>
                                            Jl. Bandang No.205<br>
                                            Makasar, Indonesia<br>
                                            Phone: 085212353958<br>
                                        </address>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-6 invoice-col" style="text-align: right">
                                        <b>Rincian Pengiriman</b><br>
                                        <b>Tanggal Pengiriman :</b> {{$h_pengiriman->delivery_date}}<br>
                                        <br>
                                        <b>Sopir: </b> {{$h_pengiriman->driver}}
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->

                                <!-- Table row -->
                                <div class="row">
                                    <h5 class="pl-2" style="font-weight:bold;">Pesanan yang akan dikirim</h5>
                                    <div class="col-12 table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Kode Pesanan</th>
                                                    <th>Nama</th>
                                                    <th>Alamat</th>
                                                    <th>Telp</th>
                                                    <th>Kasir</th>
                                                    <th class="no-print">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($list_transaksi as $d )
                                                <tr>
                                                    <td>{{$d->order_number}}</td>
                                                    <td>{{$d->customer_name}}</td>
                                                    <td>{{$d->alamat}}</td>
                                                    <td>{{$d->telp}}</td>
                                                    <td>{{$d->cashier}}</td>
                                                    <td class="no-print">
                                                        <a href="{{ URL('admin/pengiriman/surat_jalan/'.$d->id) }}" class="btn btn-sm btn-primary">
                                                            <i class="fa fa-envelope"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <hr>
                                <div class="row">
                                    <h5 class="pl-2" style="font-weight:bold;">Barang yang dimuat</h5>
                                    <div class="col-12 table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Kode Produk</th>
                                                    <th>Kode Pesanan</th>
                                                    <th>Produk</th>
                                                    <th>Unit</th>
                                                    <th>Qty</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($barang_muat as $d )
                                                <tr>
                                                    <td>{{$d->code_inventory}}</td>
                                                    <td>{{$d->order_number}}</td>
                                                    <td>{{$d->inventory}}</td>
                                                    <td>{{$d->unit}}</td>
                                                    <td>{{$d->qty}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.col -->
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
                                <!-- /.row -->
                                <!-- this row will not appear when printing -->
                                <div class="row no-print" style="margin-top:100px;">
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
                                <!-- /.invoice -->
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
            </section>

        </div>
    </div>
</body>

@include('script_footer')
<script>
</script>

</html>