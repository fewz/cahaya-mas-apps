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
                                / Surat Jalan {{$header_transaction->order_number}}
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
                                            <i class="fas fa-globe"></i> Cahaya Mas. ({{$header_transaction->order_number}})
                                            <small class="float-right">Tanggal Transaksi: {{$header_transaction->created_date}}</small>
                                        </h4>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- info row -->
                                <div class="row invoice-info">
                                    <div class="col-sm-4 invoice-col">
                                        Dari
                                        <address>
                                            <strong>Cahaya Mas.</strong><br>
                                            795 Folsom Ave, Suite 600<br>
                                            San Francisco, CA 94107<br>
                                            Phone: (804) 123-5432<br>
                                            Email: info@almasaeedstudio.com
                                        </address>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4 invoice-col">
                                        Ke
                                        <address>
                                            <strong>{{$header_transaction->customer_name}}</strong><br>
                                            {{$header_transaction->alamat}}<br>
                                            Phone: {{$header_transaction->telp}}<br>
                                        </address>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4 invoice-col">
                                        <b>Surat Jalan</b><br>
                                        <br>
                                        <b>Kode Pengiriman:</b> {{$header_transaction->code}}<br>
                                        <b>Transaction Date</b> {{$header_transaction->delivery_date}}<br>
                                        <b>Cashier:</b> {{$header_transaction->cashier}}<br>
                                        <b>Driver: </b> {{$header_transaction->driver}}
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->

                                <!-- Table row -->
                                <div class="row">
                                    <div class="col-12 table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Kode</th>
                                                    <th>Nama</th>
                                                    <th>Unit</th>
                                                    <th>Qty</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($detail_transaction as $d )
                                                    <tr>
                                                        <td>{{$d->code_inventory}}</td>
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
                                <!-- /.row -->

                                <!-- this row will not appear when printing -->
                                <div class="row no-print">
                                    <div class="col-12">
                                        <div class="btn btn-default" onclick="window.print();"><i class="fas fa-print"></i> Print</div>
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