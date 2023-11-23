<!DOCTYPE html>
<html lang="en">
@include('header')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('admin.sidebar', ['activePage' => 'laporan_pembelian'])
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h1 class="m-0">Laporan Pembelian</h1>
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
                                    <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">Laporan Pembelian</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false">Laporan Pembelian Tunai</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-three-messages-tab" data-toggle="pill" href="#custom-tabs-three-messages" role="tab" aria-controls="custom-tabs-three-messages" aria-selected="false">Laporan Pembelian Kredit</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-three-x-tab" data-toggle="pill" href="#custom-tabs-three-x" role="tab" aria-controls="custom-tabs-three-x" aria-selected="false">Laporan Hutang</a>
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
                                                <th>Supplier</th>
                                                <th>Payment Method</th>
                                                <th>Grand Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($laporan_pembelian as $dt )
                                            <tr>
                                                <td>{{$dt->created_date}}</td>
                                                <td>{{$dt->order_number}}</td>
                                                <td>{{$dt->supplier}}</td>
                                                <td>{{$dt->payment_method}}</td>
                                                <td>{{number_format($dt->grand_total, 0, '','.')}}</td>
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
                                                <th>Supplier</th>
                                                <th>Payment Method</th>
                                                <th>Grand Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($laporan_tunai as $dt )
                                            <tr>
                                                <td>{{$dt->created_date}}</td>
                                                <td>{{$dt->order_number}}</td>
                                                <td>{{$dt->supplier}}</td>
                                                <td>{{$dt->payment_method}}</td>
                                                <td>{{number_format($dt->grand_total, 0, '','.')}}</td>
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
                                                <th>Supplier</th>
                                                <th>Payment Method</th>
                                                <th>Grand Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($laporan_kredit as $dt )
                                            <tr>
                                                <td>{{$dt->created_date}}</td>
                                                <td>{{$dt->order_number}}</td>
                                                <td>{{$dt->supplier}}</td>
                                                <td>{{$dt->payment_method}}</td>
                                                <td>{{number_format($dt->grand_total, 0, '','.')}}</td>
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
                                                <th>Supplier</th>
                                                <th>Payment Method</th>
                                                <th>Grand Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($laporan_hutang as $dt )
                                            <tr>
                                                <td>{{$dt->created_date}}</td>
                                                <td>{{$dt->order_number}}</td>
                                                <td>{{$dt->supplier}}</td>
                                                <td>{{$dt->payment_method}}</td>
                                                <td>{{number_format($dt->grand_total, 0, '','.')}}</td>
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