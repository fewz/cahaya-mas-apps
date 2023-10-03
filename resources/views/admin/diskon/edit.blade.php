<!DOCTYPE html>
<html lang="en">
@include('header')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('admin.sidebar', ['activePage' => 'master_diskon'])
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h1 class="m-0">
                                <a href="{{URL('admin/master_diskon')}}">Master Diskon</a>
                                / Edit
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
                            <h3 class="card-title">Edit Diskon</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="formadd" action="{{URL('admin/master_diskon/do_edit').'/'.$data_diskon->id}}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Inventory</label>
                                    <select class="form-control select2bs4" name="id_inventory" id="id_inventory" style="width: 100%;" onchange="inventoryChange()">
                                        @foreach ($list_inventory as $dt )
                                        @if ($dt->id === $data_diskon->id_inventory)
                                        <option value="{{$dt->id}}" selected>{{$dt->name}}</option>
                                        @else
                                        <option value="{{$dt->id}}">{{$dt->name}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Unit</label>
                                    <select class="form-control select2bs4" name="id_unit" id="unitproduk" style="width: 100%;">
                                        @foreach ($list_unit as $dt )
                                        @if ($dt->id === $data_diskon->id_unit)
                                        <option value="{{$dt->id}}" selected>{{$dt->name}}</option>
                                        @else
                                        <option value="{{$dt->id}}">{{$dt->name}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Minimal Beli</label>
                                    <input type="text" class="form-control required" name="minimal" placeholder="Minimal Beli" value="{{$data_diskon->minimal}}">
                                </div>
                                <div class="form-group">
                                    <label>Potongan</label>
                                    <input type="text" class="form-control required" name="potongan" placeholder="Phone" value="{{$data_diskon->potongan}}">
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Mulai Diskon</label>
                                    <input type="date" class="form-control required" name="start_date" value="{{$data_diskon->start_date}}">
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Berakhir Diskon</label>
                                    <input type="date" class="form-control required" name="end_date" value="{{$data_diskon->end_date}}">
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
    function inventoryChange() {
        const id = $("#id_inventory").val();
        getUnit(id);
    }

    function submit() {
        // submit form
        if (!validateForm()) {
            // validate form required
            return;
        }
        $('#formadd').submit();
    }

    function getUnit(id) {
        $("#unitproduk option").remove();
        const produkBaru = $("#produksupplier").val();
        $.get(`/api/available_unit?id=${id}`, function(data) {
            console.log('dat', data);

            const unit = data.payload;
            unit.forEach((val) => {
                optionText = val.name;
                optionValue = val.id;

                $('#unitproduk').append(new Option(optionText, JSON.stringify(optionValue)));
            });
        }).fail(function(error) {
            console.error('Error fetching API data', error);
        });
    }
</script>

</html>