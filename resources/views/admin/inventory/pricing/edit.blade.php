<!DOCTYPE html>
<html lang="en">
@include('header')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('admin.sidebar', ['activePage' => 'master_pricing'])
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h1 class="m-0">
                                <a href="{{URL('admin/master_pricing')}}">Master Pricing</a>
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
                            <h3 class="card-title">Edit Pricing</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="formadd" action="{{URL('admin/master_pricing/do_edit').'/'.$data_pricing->id}}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Inventory</label>
                                    <select class="form-control select2bs4" name="id_inventory" style="width: 100%;">
                                        @foreach ($list_inventory as $dt ) 
                                        @if ($dt->id === $data_pricing->id_inventory)
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
                                        @if ($dt->id === $data_pricing->id_unit)
                                        <option value="{{$dt->id}}" selected>{{$dt->name}}</option>
                                        @else
                                        <option value="{{$dt->id}}">{{$dt->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Tier Customer</label>
                                    <select class="form-control select2bs4" name="id_tier_customer" style="width: 100%;">
                                        @foreach ($list_tier_customer as $dt ) 
                                        @if ($dt->id === $data_pricing->id_tier_customer)
                                        <option value="{{$dt->id}}" selected>{{$dt->name}}</option>
                                        @else
                                        <option value="{{$dt->id}}">{{$dt->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Sell Price</label>
                                    <input type="number" class="form-control required" name="sell_price" placeholder="Name" value="{{$data_pricing->sell_price}}">
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