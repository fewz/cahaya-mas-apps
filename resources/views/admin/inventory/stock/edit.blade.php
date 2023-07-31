<!DOCTYPE html>
<html lang="en">
@include('header')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('admin.sidebar', ['activePage' => 'mater_stock'])
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h1 class="m-0">
                                <a href="{{URL('admin/mater_stock')}}">Master Stock</a>
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
                            <h3 class="card-title">Edit New Stock</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="formadd" action="{{URL('admin/master_stock/do_edit').'/'.$data_stock->id}}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Inventory</label>
                                    <select class="form-control select2bs4" name="id_inventory" style="width: 100%;">
                                        @foreach ($list_inventory as $dt )
                                        @if ($dt->id === $data_stock->id_category)
                                        <option value="{{$dt->id}}" selected>{{$dt->name}}</option>
                                        @else
                                        <option value="{{$dt->id}}">{{$dt->name}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Unit</label>
                                    <select class="form-control select2bs4" name="id_unit" style="width: 100%;">
                                        @foreach ($list_unit as $dt )
                                        @if ($dt->id === $data_stock->id_category)
                                        <option value="{{$dt->id}}" selected>{{$dt->name}}</option>
                                        @else
                                        <option value="{{$dt->id}}">{{$dt->name}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Date Input</label>
                                    <input type="date" class="form-control required" name="date_input" placeholder="Date Input" value="{{$data_stock->date_input}}">
                                </div>
                                <div class="form-group">
                                    <label>Date Expired</label>
                                    <input type="date" class="form-control" name="date_expired" placeholder="Date Expired" value="{{$data_stock->date_expired}}">
                                </div>
                                <div class="form-group">
                                    <label>Qty</label>
                                    <input type="number" class="form-control required" name="qty" placeholder="Qty" value="{{$data_stock->qty}}">
                                </div>
                                <div class="form-group">
                                    <label>Price Buy</label>
                                    <input type="number" class="form-control required" name="price_buy" placeholder="Price Buy" value="{{$data_stock->price_buy}}">
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
    function submit() {
        // submit form
        if (!validateForm()) {
            // validate form required
            return;
        }
        $('#formadd').submit();
    }
</script>

</html>