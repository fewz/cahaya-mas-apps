<!DOCTYPE html>
<html lang="en">
@include('header')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('admin.sidebar', ['activePage' => 'stok_opname'])
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h1 class="m-0">Stok Opname</h1>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <!-- /.card -->

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex">
                                    <h3 class="card-title">Stok Opname</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Tanggal</label>
                                        <input type="date" class="form-control required" value="{{$tgl}}" id="date" placeholder="Tanggal Order" onchange="tanggalChange()">
                                    </div>
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Inventory</th>
                                                <th>Unit</th>
                                                <th>Tipe</th>
                                                <th>Perubahan Stok</th>
                                                <th>Stok Akhir</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($list_data as $dt )
                                            <tr>
                                                <td>{{$dt->created_date}}</td>
                                                <td>{{$dt->inventory}}</td>
                                                <td>{{$dt->unit}}</td>
                                                <td>{{$dt->tipe}}</td>
                                                <td>{{$dt->qty}}</td>
                                                <td>{{$dt->stok_akhir}}</td>
                                            </tr>
                                            @endforeach
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</body>
<form id="formChange" action="{{URL('admin/stok_opname')}}" method="GET">
    <input type="hidden" name="date" id="date_req">
</form>
@include('script_footer')

<script>
    function tanggalChange() {
        var date = $("#date").val();
        console.log('fa', date);
        
        $('#date_req').val(date);
        $('#formChange').submit();
    }
</script>

</html>