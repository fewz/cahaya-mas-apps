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
                                    <h3 class="card-title">List Stok Opname</h3>
                                    <div class="ml-auto">
                                        <a href="{{ URL('admin/stok_opname/add') }}" class="btn btn-sm btn-primary">ADD <i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Inventory</th>
                                                <th>Checker</th>
                                                <th>Unit</th>
                                                <th>Stok App</th>
                                                <th>Stok Gudang</th>
                                                <th>Selisih</th>
                                                <th>Notes</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($list_stock as $dt )
                                            <tr>
                                                <td>{{$dt->created_date}}</td>
                                                <td>{{$dt->produk}}</td>
                                                <td>{{$dt->checker}}</td>
                                                <td>{{$dt->unit}}</td>
                                                <td>{{$dt->stok}}</td>
                                                <td>{{$dt->stok_gudang}}</td>
                                                <td>{{$dt->selisih}}</td>
                                                <td>{{$dt->notes}}</td>
                                                <td>
                                                    @if($dt->status === 0)
                                                    <button class="btn btn-sm btn-primary" onclick="openModal('{{$dt->id}}','{{$dt->created_date}}','{{$dt->produk}}','{{$dt->checker}}','{{$dt->stok}}','{{$dt->stok_gudang}}','{{$dt->selisih}}','{{$dt->stok_unit}}','{{$dt->unit}}')">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" onclick="clickDelete('{{$dt->id}}')"><i class="fa fa-trash"></i></button>
                                                    @else
                                                    Revisi Selesai
                                                    @endif
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
<form id="formDelete" action="{{URL('admin/stok_opname/delete')}}" method="POST">
    @csrf
    <input type="hidden" name="id" id="id_delete">
</form>
@include('script_footer')

<div id="modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Revisi Stok</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formedit" action="{{URL('admin/stok_opname/revisi')}}" method="POST">
                @csrf
                <div class="modal-body" style="max-height:650px; overflow:auto;">
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input disabled type="text" class="form-control required" id="tanggal">
                    </div>
                    <div class="form-group">
                        <label>Produk</label>
                        <input disabled type="text" class="form-control required" id="produk">
                    </div>
                    <div class="form-group">
                        <label>Checker</label>
                        <input disabled type="text" class="form-control required" id="checker">
                    </div>
                    <div class="form-group">
                        <label>Unit</label>
                        <input disabled type="text" class="form-control required" id="unit">
                    </div>
                    <div class="form-group">
                        <label>Stok Saat Input</label><br>
                        <input disabled class="form-control required" type="number" id="stok_saat_input" name="tanggal_bayar">
                    </div>
                    <div class="form-group">
                        <label>Stok Gudang</label><br>
                        <input disabled class="form-control required" type="number" id="stok_gudang" name="tanggal_bayar">
                    </div>
                    <div class="form-group">
                        <label>Selisih</label><br>
                        <input disabled class="form-control required" type="number" id="selisih" name="tanggal_bayar">
                    </div>
                    <div class="form-group">
                        <label>Stok Saat Ini</label><br>
                        <input disabled class="form-control required" type="number" id="stok_saat_ini" name="tanggal_bayar">
                    </div>
                    <div class="form-group">
                        <label>Stok yang terivisi</label><br>
                        <input class="form-control required" type="number" id="stok_revisi" name="stok_revisi">
                    </div>
                    <input type="hidden" class="form-control required" id="id_stok_opname" name="id_stok_opname">
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Revisi Stok" />
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script>
    function openModal(id_stok_opname, tanggal, produk, checker, stok_saat_input, stok_gudang, selisih, stok_saat_ini, unit) {
        console.log('t', tanggal);

        $("#tanggal").val(tanggal);
        $("#produk").val(produk);
        $("#checker").val(checker);
        $("#unit").val(unit);
        $("#stok_saat_input").val(stok_saat_input);
        $("#stok_gudang").val(stok_gudang);
        $("#selisih").val(selisih);
        $("#id_stok_opname").val(id_stok_opname);
        $("#stok_saat_ini").val(stok_saat_ini);
        $("#stok_revisi").val(parseInt(stok_saat_ini) + parseInt(selisih));
        $("#modal").modal();
    }

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