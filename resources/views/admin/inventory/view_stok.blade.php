<!DOCTYPE html>
<html lang="en">
@include('header')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('admin.sidebar', ['activePage' => 'master_inventory'])
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h1 class="m-0">
                                <a href="{{URL('admin/master_inventory')}}">Master Inventory</a>
                                / Stok
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
                            <h3 class="card-title">Inventory</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="formadd" action="{{URL('admin/master_inventory/do_edit').'/'.$data_inventory->id}}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Code Inventory</label>
                                    <input disabled type="text" class="form-control required" name="code" placeholder="Code" value="{{$data_inventory->code}}">
                                </div>
                                <div class="form-group">
                                    <label>Name</label>
                                    <input disabled type="text" class="form-control required" name="name" placeholder="Name" value="{{$data_inventory->name}}">
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <input id="pricing" type="hidden" name="pricing" />
                            <input id="units" type="hidden" name="units" />
                            <input id="list_units" type="hidden" name="list_units" />
                            <input id="satuan_terkecil" type="hidden" name="satuan_terkecil" />
                        </form>
                    </div>

                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Stok</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Unit</th>
                                        <th>Stok</th>
                                        <th>Per satuan terkecil</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                    @foreach ($list_unit as $unit )
                                    <tr>
                                        <td>{{$unit->name}}</td>
                                        <td>{{$unit->stok}}</td>
                                        <td>{{$unit->qty_reference}}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary" onclick="openModalEdit('{{$unit->id}}', '{{$unit->name}}', '{{$unit->stok}}')">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-primary" onclick="openmodal2('{{$unit->id_inventory}}', '{{$unit->name}}', '{{$unit->stok}}', '{{$unit->id}}', '{{$unit->qty_reference}}')">
                                                <i class="fa fa-box" aria-hidden="true"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</body>
<div id="modalEdit" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update Stok</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formedit" action="{{URL('admin/master_inventory/edit_stok')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Unit</label>
                        <input disabled type="text" class="form-control required" id="edit-name">
                    </div>
                    <div class="form-group">
                        <label>Stok</label>
                        <input type="number" class="form-control required" id="edit-stok" name="stok">
                    </div>
                    <input type="hidden" class="form-control required" id="edit-id" name="id">
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Save changes" />
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="modal2" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Konversi Stok</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form2" action="{{URL('admin/master_inventory/konversi_stok')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Dari unit</label>
                        <input disabled type="text" class="form-control required" id="konvert-dari">
                    </div>
                    <div class="form-group">
                        <label>Stok</label>
                        <input disabled type="text" class="form-control required" id="konvert-stok">
                    </div>
                    <div class="form-group">
                        <label>Ke Unit</label>
                        <select class="form-control required" id="konvert-ke" onchange="cbchange()">
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Satuan per konversi</label>
                        <input disabled type="text" class="form-control required" id="konvert-satuan">
                    </div>
                    <div class="form-group">
                        <label>Qty</label>
                        <input type="number" class="form-control required" id="konvert-qty" onchange="qtyChange()">
                    </div>
                    <div class="form-group">
                        <label>Total Konversi</label>
                        <input disabled type="number" class="form-control required" id="konvert-total">
                    </div>
                    <input type="hidden" id="id_dari" name="id_dari">
                    <input type="hidden" id="id_ke" name="id_ke">
                    <input type="hidden" id="qty_dari" name="qty_dari">
                    <input type="hidden" id="qty_ke" name="qty_ke">
                    <input type="hidden" id="id_inventory" name="id_inventory" value="{{$data_inventory->id}}">
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <div class="btn btn-primary" onclick="konvert()">Konversi</div>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@include('script_footer')
<script>
    const $satuanBaru = $("#satuanBaru");

    let listSatuan = <?php echo $list_unit; ?>;
    let listUnit = {};
    let ref = 0;

    function openModalEdit(id, name, stok) {
        $("#edit-name").val(name);
        $("#edit-stok").val(stok);
        $("#edit-id").val(id);
        $("#modalEdit").modal();
    }

    function openmodal2(idinvent, name, max, idunit, refs) {
        $("#id_dari").val(idunit);
        $.get(`/api/available_unit?id=${idinvent}`, function(data) {
            console.log('dat', refs);
            ref = parseInt(refs) || 1;
            $("#konvert-dari").val(name);
            $("#konvert-stok").val(max);
            const unit = data.payload;
            $('#konvert-ke').empty();
            unit.forEach((val) => {
                if (val.id !== parseInt(idunit)) {
                    optionText = val.name;

                    $('#konvert-ke').append(new Option(optionText, JSON.stringify(val)));
                }
            });
            cbchange();
        }).fail(function(error) {
            console.error('Error fetching API data', error);
        });
        $("#modal2").modal();
    }

    function cbchange() {
        const val = JSON.parse($("#konvert-ke").val());
        const qty_ref = val.qty_reference || 1;
        const satuan_per_konversi = ref / qty_ref;
        $("#konvert-satuan").val(satuan_per_konversi);
        $("#konvert-qty").val(0);
        $("#konvert-total").val(0);
    }

    function qtyChange() {
        let val = parseFloat($("#konvert-qty").val());
        const max = parseFloat($("#konvert-stok").val());
        if (val > max) {
            val = max;
        }
        const satuan = parseFloat($("#konvert-satuan").val())
        const total_konversi = Math.floor(val * satuan);
        let revisi = Math.floor(total_konversi / satuan);
        $("#konvert-qty").val(revisi);
        $("#konvert-total").val(total_konversi);
    }

    function konvert() {
        console.log('f');
        const val = JSON.parse($("#konvert-ke").val());
        $("#id_ke").val(val.id);
        $("#qty_dari").val($("#konvert-qty").val());
        $("#qty_ke").val($("#konvert-total").val());

        $("#form2").submit();
    }
</script>

</html>