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
                            <h1 class="m-0">Transaksi</h1>
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
                                    <h3 class="card-title">List Transaksi</h3>
                                    <div class="ml-auto">
                                        <a href="{{ URL('admin/transaction/add') }}" class="btn btn-sm btn-primary">ADD <i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Order Number</th>
                                                <th>Customer</th>
                                                <th>Cashier</th>
                                                <th>Created Date</th>
                                                <th>Payment Method</th>
                                                <th>Status</th>
                                                <th>Grand Total</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $status = ["Draft", "Selesai", "Belum Lunas", "Belum Dikirim", "Siap Dikirim", "Sedang Dikirim", "Terkirim"]; ?>
                                            @foreach ($list_transaction as $dt )
                                            <tr>
                                                <td>{{$dt->order_number}}</td>
                                                <td>{{$dt->customer_name}}</td>
                                                <td>{{$dt->cashier_name}}</td>
                                                <td>{{$dt->created_date}}</td>
                                                <td>{{$dt->payment_method}}</td>
                                                <td>{{$status[$dt->status]}}</td>
                                                <td>
                                                    {{$dt->grand_total > 0 ? number_format($dt->grand_total,0,',','.') : "-"}}
                                                </td>
                                                <td>
                                                    <a href="{{ URL('admin/transaction/view/'.$dt->id) }}" class="btn btn-sm btn-primary">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <a href="{{ URL('admin/transaction/invoice/'.$dt->id) }}" class="btn btn-sm btn-primary">
                                                        <i class="fa fa-file-invoice"></i>
                                                    </a>
                                                    @if($dt->status === 1 && $dt->payment_method === 'CREDIT')
                                                    <a href="{{ URL('/bukti_transfer_transaction/'.$dt->id) }}" class="btn btn-sm btn-primary" target="_blank">
                                                        <i class="fa fa-image"></i>
                                                    </a>
                                                    @endif
                                                    <!-- <button class="btn btn-sm btn-danger" onclick="clickDelete('{{$dt->id}}')"><i class="fa fa-trash"></i></button> -->
                                                </td>
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
<form id="formDelete" action="{{URL('admin/transaction/delete')}}" method="POST">
    @csrf
    <input type="hidden" name="id" id="id_delete">
</form>

@include('script_footer')

<script>
    function clickDelete(id) {
        // confirmation delete
        swal({
                title: "Are you sure want to delete?",
                text: "Once deleted, you will not be able to recover this data!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $('#id_delete').val(id);
                    $('#formDelete').submit();
                }
            });
    }
</script>

</html>