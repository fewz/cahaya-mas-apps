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
                            <h1 class="m-0">
                                <a href="{{URL('admin/stok_opname')}}">Stok Opname</a>
                                / Add
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
                            <h3 class="card-title">Tambah Stok Opname</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="formadd" action="{{URL('admin/stok_opname/do_add')}}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Inventory</label>
                                    <select id="listproduk" class="form-control select2bs4" name="id_inventory" style="width: 100%;" onchange="getUnit()">
                                        @foreach ($list_inventory as $dt )
                                        <option value="{{$dt->id}}">{{$dt->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Unit</label>
                                    <select id="unitproduk" class="form-control select2bs4" name="id_unit" style="width: 100%;" onchange="updateStok()">
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Stok Sekarang</label>
                                    <input id="vstok_sekarang" type="number" disabled class="form-control required" name="stok" placeholder="Stok Sekarang">
                                    <input id="stok_sekarang" type="hidden" class="form-control required" name="stok" placeholder="Stok Sekarang">
                                </div>
                                <div class="form-group">
                                    <label>Stok Gudang</label>
                                    <input id="stok_gudang" type="number" class="form-control required" name="stok_gudang" placeholder="Stok Gudang" onchange="updateSelisih()">
                                </div>
                                <div class="form-group">
                                    <label>Selisih</label>
                                    <input id="vselisih" type="number" disabled class="form-control required" name="price_buy" placeholder="Selisih">
                                    <input id="selisih" type="hidden" class="form-control required" name="selisih" placeholder="Price Buy">
                                </div>
                                <div class="form-group">
                                    <label>Notes</label>
                                    <input id="notes" type="text" class="form-control required" name="notes" placeholder="Notes">
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <div class="btn btn-primary" onclick="submit()">Submit</div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
</body>

@include('script_footer')
<script>
    units = [];

    function submit() {
        // submit form
        if (!validateForm()) {
            // validate form required
            return;
        }
        $('#formadd').submit();
    }

    function getUnit() {
        $("#unitproduk option").remove();
        const produkBaru = $("#listproduk").val();
        console.log('pr', produkBaru);

        $.get(`/api/available_unit?id=${produkBaru}`, function(data) {
            const unit = data.payload;
            console.log('da', unit);

            unit.forEach((val) => {
                optionText = val.name;
                optionValue = val.id;
                units.push(val);
                $('#unitproduk').append(new Option(optionText, optionValue));
            });
            updateStok();
        }).fail(function(error) {
            console.error('Error fetching API data', error);
        });
    }

    function updateStok() {
        const id_unit = $("#unitproduk").val();
        const selectedUnit = units.filter((val) => val.id == id_unit)[0];

        $("#vstok_sekarang").val(selectedUnit.stok);
        $("#stok_sekarang").val(selectedUnit.stok);
        $("#stok_gudang").val(selectedUnit.stok);
        updateSelisih();
    }

    function updateSelisih() {
        const stok = $("#stok_sekarang").val();
        const selisih =  $("#stok_gudang").val() - stok;
        console.log('ad', stok);
        
        $("#vselisih").val(selisih);
        $("#selisih").val(selisih);
    }
    $(function() {
        getUnit();
    });
</script>

</html>