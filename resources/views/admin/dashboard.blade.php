<!DOCTYPE html>
<html lang="en">
@include('header')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('admin.sidebar', ['activePage' => 'dashboard'])
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h1 class="m-0">Dashboard</h1>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{$transaksi_bulan_ini}}</h3>

                                    <p>Transaksi bulan ini</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{$transaksi_butuh_dikirim}}</h3>

                                    <p>Transaksi butuh dikirim</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>{{$total_customer}}</h3>

                                    <p>Total Customer</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3>{{$total_po}}</h3>

                                    <p>Total Purchase Order</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                    </div>
                    <!-- /.row -->
                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <section class="col-lg-7 connectedSortable">
                            <!-- Custom tabs (Charts with tabs)-->

                            <div class="card">
                                <div class="card-header border-0">
                                    <div class="d-flex justify-content-between">
                                        <h3 class="card-title">Total Transaksi 7 hari terakhir</h3>
                                        <!-- <a href="javascript:void(0);">View Report</a> -->
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex">
                                        <!-- <p class="d-flex flex-column">
                                            <span class="text-bold text-lg"></span>
                                            <span>Sales Over Time</span>
                                        </p> -->
                                        <!-- <p class="ml-auto d-flex flex-column text-right">
                                            <span class="text-success">
                                                <i class="fas fa-arrow-up"></i> 33.1%
                                            </span>
                                            <span class="text-muted">Since last month</span>
                                        </p> -->
                                    </div>
                                    <!-- /.d-flex -->

                                    <div class="position-relative mb-4">
                                        <canvas id="sales-chart" height="200"></canvas>
                                    </div>

                                    <div class="d-flex flex-row justify-content-end">
                                        <span class="mr-2">
                                            <i class="fas fa-square text-primary"></i> This year
                                        </span>

                                        <span>
                                            <i class="fas fa-square text-gray"></i> Last year
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header border-0">
                                    <div class="d-flex justify-content-between">
                                        <h3 class="card-title">Tagihan yang jatuh tempo</h3>
                                        <input type="date" id="tgl">
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Kode</th>
                                                <th>Tanggal</th>
                                                <th>Customer</th>
                                                <th>Phone</th>
                                                <th>Address</th>
                                                <th>Grand Total</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tableBody">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </section>
                        <!-- /.Left col -->
                        <!-- right col (We are only adding the ID to make the widgets sortable)-->
                        <section class="col-lg-5 connectedSortable">

                            <!-- solid sales graph -->
                            <div class="card bg-gradient-primary">
                                <div class="card-header border-0">
                                    <h3 class="card-title">
                                        <i class="fas fa-th mr-1"></i>
                                        Penjualan 7 hari terakhir
                                    </h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn bg-primary btn-sm" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <canvas class="chart" id="line-chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                                <!-- /.card-body -->
                                <!-- /.card-footer -->
                            </div>
                            <div class="card">
                                <div class="card-header border-0">
                                    <div class="d-flex justify-content-between">
                                        <h3 class="card-title">Produk yang hampir kadaluarsa</h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Kode</th>
                                                <th>Nama</th>
                                                <th>Satuan</th>
                                                <th>Qty</th>
                                                <th>Tanggal Kadaluarsa</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tableBody">
                                            @foreach ($kadaluarsa as $dt )
                                            <tr>
                                                <td>{{$dt->code}}</td>
                                                <td>{{$dt->inventory}}</td>
                                                <td>{{$dt->unit}}</td>
                                                <td>{{$dt->qty}}</td>
                                                <td>{{$dt->exp_date}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /.card -->

                            <!-- /.card -->

                        </section>
                        <!-- right col -->
                    </div>
                    <div class="card bg-white">
                        <div class="card-header border-0">
                            <h3 class="card-title">
                                <i class="fas fa-bell mr-1"></i>
                                Reminder Hutang & Piutang
                            </h3>
                        </div>
                        <div class="card-body">
                            <p class="font-weight-bold">Piutang</p>
                            <table id="example2" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Order Number</th>
                                        <th>Customer</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Grand Total</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                    @foreach ($notif_piutang as $dt )
                                    <tr>
                                        <td>{{$dt->created_date}}</td>
                                        <td>{{$dt->order_number}}</td>
                                        <td>{{$dt->name}}</td>
                                        <td>{{$dt->phone}}</td>
                                        <td>{{$dt->address}}</td>
                                        <td>{{$dt->grand_total}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <p class="font-weight-bold mt-3">Hutang</p>
                            <table id="example3" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Order Number</th>
                                        <th>Supplier</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Grand Total</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                    @foreach ($notif_hutang as $dt )
                                    <tr>
                                        <td>{{$dt->created_date}}</td>
                                        <td>{{$dt->order_number}}</td>
                                        <td>{{$dt->name}}</td>
                                        <td>{{$dt->phone}}</td>
                                        <td>{{$dt->address}}</td>
                                        <td>{{$dt->grand_total}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <!-- /.card-footer -->
                    </div>
                    <!-- /.row (main row) -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->

</body>
<script>
    // Sales graph chart
    var salesGraphChartCanvas = $('#line-chart').get(0).getContext('2d')
    // $('#revenue-chart').get(0).getContext('2d');

    var salesGraphChartData = {
        labels: [
            <?php foreach ($graph_sales as $dt) {
                echo "'" . $dt->day_name . "',";
            } ?>
        ],
        datasets: [{
            label: 'Total Penjualan',
            fill: false,
            borderWidth: 2,
            lineTension: 0,
            spanGaps: true,
            borderColor: '#efefef',
            pointRadius: 3,
            pointHoverRadius: 7,
            pointColor: '#efefef',
            pointBackgroundColor: '#efefef',
            data: [
                <?php foreach ($graph_sales as $dt) {
                    echo $dt->total_sales . ",";
                } ?>
            ]
        }]
    }

    var salesGraphChartOptions = {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
            display: false
        },
        scales: {
            xAxes: [{
                ticks: {
                    fontColor: '#efefef'
                },
                gridLines: {
                    display: false,
                    color: '#efefef',
                    drawBorder: false
                }
            }],
            yAxes: [{
                ticks: {
                    stepSize: 1000000,
                    fontColor: '#efefef',
                    callback: function(value, index, ticks) {
                        return value;
                    }
                },
                gridLines: {
                    display: true,
                    color: '#efefef',
                    drawBorder: false
                }
            }]
        }
    }

    // This will get the first returned node in the jQuery collection.
    // eslint-disable-next-line no-unused-vars
    var salesGraphChart = new Chart(salesGraphChartCanvas, { // lgtm[js/unused-local-variable]
        type: 'line',
        data: salesGraphChartData,
        options: salesGraphChartOptions
    });

    var ticksStyle = {
        fontColor: '#495057',
        fontStyle: 'bold'
    }

    var mode = 'index'
    var intersect = true

    var $salesChart = $('#sales-chart')
    // eslint-disable-next-line no-unused-vars
    var salesChart = new Chart($salesChart, {
        type: 'bar',
        data: {
            labels: [
                <?php foreach ($total_transaksi as $dt) {
                    echo "'" . $dt->day_name . "',";
                } ?>
            ],
            datasets: [{
                backgroundColor: '#007bff',
                borderColor: '#007bff',
                data: [
                    <?php foreach ($total_transaksi as $dt) {
                        echo $dt->total_transaksi . ",";
                    } ?>
                ]
            }, ]
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                mode: mode,
                intersect: intersect
            },
            hover: {
                mode: mode,
                intersect: intersect
            },
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    // display: false,
                    gridLines: {
                        display: true,
                        lineWidth: '4px',
                        color: 'rgba(0, 0, 0, .2)',
                        zeroLineColor: 'transparent'
                    },
                    ticks: $.extend({
                        stepSize: 1,
                        beginAtZero: true,

                        // Include a dollar sign in the ticks
                        callback: function(value) {
                            if (value >= 1000) {
                                value /= 1000
                                value += 'k'
                            }

                            return value
                        }
                    }, ticksStyle)
                }],
                xAxes: [{
                    display: true,
                    gridLines: {
                        display: false
                    },
                    ticks: ticksStyle
                }]
            }
        }
    });

    // The Calender
    $('#calendar').datetimepicker({
        format: 'L',
        inline: true,
    });


    function get_tagihan(selectedDate) {
        $.get(`/api/get_tagihan_jatuh_tempo/${selectedDate}`, function(data) {
            // Clear the table body
            $('#tableBody').empty();
            // Populate the table with selected items and their stored values
            data.payload.forEach((item) => {
                const row = `<tr>
                    <td>${item.order_number}</td>
                    <td>${item.created_date}</td>
                    <td>${item.full_name}</td>
                    <td>${item.phone}</td>
                    <td>${item.address}</td>
                    <td>${item.grand_total}</td>
                </tr>`;
                $('#tableBody').append(row);
            });
        }).fail(function(error) {
            console.error('Error fetching API data', error);
        });
    }


    $(document).ready(function() {
        var currentDate = new Date();
        document.getElementById('tgl').valueAsDate = new Date();
        get_tagihan(currentDate);
        $("#tgl").on('change', function() {
            var selectedDate = $("#tgl").val();
            let convert = selectedDate.split('-');
            // selectedDate = convert[2] + '-' + convert[1] + '-' + convert[0];
            console.log('fa', selectedDate);


            get_tagihan(selectedDate);
        });
        $("#tgl").change();
    })
</script>

</html>