<!DOCTYPE html>
<html lang="en">
@include('header')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('admin.sidebar', ['activePage' => 'laporan_penjualan'])
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h1 class="m-0">Laporan Penjualan</h1>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <!-- /.card -->

                <div class="container-fluid">
                    <div class="card card-primary card-outline card-tabs">
                        <div class="card-header p-0 pt-1 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">Laporan Penjualan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false">Laporan Penjualan Tunai</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-three-messages-tab" data-toggle="pill" href="#custom-tabs-three-messages" role="tab" aria-controls="custom-tabs-three-messages" aria-selected="false">Laporan Penjualan Kredit</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-three-x-tab" data-toggle="pill" href="#custom-tabs-three-x" role="tab" aria-controls="custom-tabs-three-x" aria-selected="false">Laporan Piutang</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-three-tabContent">
                                <div class="tab-pane fade show active" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Order Number</th>
                                                <th>Customer</th>
                                                <th>Transaction Type</th>
                                                <th>Payment Method</th>
                                                <th>Grand Total</th>
                                                <th>Untung Bersih</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($laporan_penjualan as $dt )
                                            <tr>
                                                <td>{{$dt->created_date}}</td>
                                                <td>{{$dt->order_number}}</td>
                                                <td>{{$dt->customer}}</td>
                                                <td>{{$dt->transaction_type}}</td>
                                                <td>{{$dt->payment_method}}</td>
                                                <td>{{$dt->grand_total}}</td>
                                                <td>{{$dt->netto}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
                                    <table id="example2" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Order Number</th>
                                                <th>Customer</th>
                                                <th>Transaction Type</th>
                                                <th>Payment Method</th>
                                                <th>Grand Total</th>
                                                <th>Untung Bersih</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($laporan_tunai as $dt )
                                            <tr>
                                                <td>{{$dt->created_date}}</td>
                                                <td>{{$dt->order_number}}</td>
                                                <td>{{$dt->customer}}</td>
                                                <td>{{$dt->transaction_type}}</td>
                                                <td>{{$dt->payment_method}}</td>
                                                <td>{{$dt->grand_total}}</td>
                                                <td>{{$dt->netto}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-three-messages" role="tabpanel" aria-labelledby="custom-tabs-three-messages-tab">
                                    <table id="example3" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Order Number</th>
                                                <th>Customer</th>
                                                <th>Transaction Type</th>
                                                <th>Payment Method</th>
                                                <th>Grand Total</th>
                                                <th>Untung Bersih</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($laporan_kredit as $dt )
                                            <tr>
                                                <td>{{$dt->created_date}}</td>
                                                <td>{{$dt->order_number}}</td>
                                                <td>{{$dt->customer}}</td>
                                                <td>{{$dt->transaction_type}}</td>
                                                <td>{{$dt->payment_method}}</td>
                                                <td>{{$dt->grand_total}}</td>
                                                <td>{{$dt->netto}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-three-x" role="tabpanel" aria-labelledby="custom-tabs-three-x-tab">
                                    <table id="example4" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Order Number</th>
                                                <th>Customer</th>
                                                <th>Transaction Type</th>
                                                <th>Payment Method</th>
                                                <th>Grand Total</th>
                                                <th>Untung Bersih</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($laporan_piutang as $dt )
                                            <tr>
                                                <td>{{$dt->created_date}}</td>
                                                <td>{{$dt->order_number}}</td>
                                                <td>{{$dt->customer}}</td>
                                                <td>{{$dt->transaction_type}}</td>
                                                <td>{{$dt->payment_method}}</td>
                                                <td>{{$dt->grand_total}}</td>
                                                <td>{{$dt->netto}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </section>
        </div>
    </div>
</body>
@include('script_footer')

<script>
    $("#example2").DataTable();
    $("#example3").DataTable();
    $("#example4").DataTable();
</script>

</html>