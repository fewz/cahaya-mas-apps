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
                                / Invoice {{$header_transaction->order_number}}
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
                                            <i class="fas fa-globe"></i> Cahaya Mas. (INVOICE {{$header_transaction->order_number}})
                                            <small class="float-right">Tanggal Cetak: {{now()}}</small>
                                        </h4>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- info row -->
                                <div class="row invoice-info">
                                    <div class="col-sm-4 invoice-col">
                                        <address>
                                            <strong>Cahaya Mas.</strong><br>
                                            Jl. Bandang No.205<br>
                                            Makasar, Indonesia<br>
                                            Phone: 085212353958<br>
                                        </address>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4 invoice-col">
                                        Customer
                                        <address>
                                            <strong>{{$header_transaction->customer_name}}</strong><br>
                                            {{$header_transaction->alamat}}<br>
                                            Phone: {{$header_transaction->telp}}<br>
                                        </address>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4 invoice-col">
                                        <b>Nomor Invoice:</b> {{$header_transaction->order_number}}<br>
                                        <b>Tanggal Transaksi: </b> {{$header_transaction->created_date}}<br>
                                        <b>Kasir:</b> {{$header_transaction->cashier}}<br>
                                        <b>Metode Pembayaran: </b> {{$header_transaction->payment_method}}<br>
                                        @if($header_transaction->payment_method === 'CREDIT')
                                        <b>Jatuh Tempo: </b> {{$header_transaction->due_date}}
                                        @endif
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
                                                    <th>Harga</th>
                                                    <th>Qty</th>
                                                    <th>Diskon</th>
                                                    <th>Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($detail_transaction as $d )
                                                <tr>
                                                    <td>{{$d->code_inventory}}</td>
                                                    <td>{{$d->inventory}}</td>
                                                    <td>{{$d->unit}}</td>
                                                    <td>{{number_format(($d->sell_price + ($d->diskon / $d->qty)), 0, '','.')}}</td>
                                                    <td>{{$d->qty}}</td>
                                                    <td>{{number_format($d->diskon, 0, '','.')}}</td>
                                                    <td>{{number_format($d->sub_total, 0, '','.')}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                                <div class="row">
                                    <!-- accepted payments column -->
                                    <div class="col-6">
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-6">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tr>
                                                    <th>Total Sebelum Diskon:</th>
                                                    <td>Rp. {{number_format(($header_transaction->grand_total + $header_transaction->total_diskon + $header_transaction->diskon_poin),0,'.','.')}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Total Diskon</th>
                                                    <td>Rp. {{number_format($header_transaction->total_diskon,0,'.','.')}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Poin yang digunakan</th>
                                                    <td>Rp. {{number_format($header_transaction->diskon_poin,0,'.','.')}}</td>
                                                </tr>
                                                <tr>
                                                    <th style="width:50%">Grand Total:</th>
                                                    <td>Rp. {{number_format($header_transaction->grand_total,0,'.','.')}}</td>
                                                </tr>
                                                <tr>
                                                    <th style="width:50%">Sisa Poin:</th>
                                                    <td>{{number_format($header_transaction->poin,0,'.','.')}}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <div class="hidden-but-printable">
                                    <div class="row" style="margin-top:100px;">
                                        <div class="col-4 text-center font-weight-bold">
                                            Yang Menerima
                                        </div>
                                        <div class="col-4">
                                        </div>
                                        <div class="col-4 text-center font-weight-bold">
                                            Yang Menyetujui
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