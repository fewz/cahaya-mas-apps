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
                            <h1 class="m-0">Master Inventory</h1>
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
                                    <h3 class="card-title">List Inventory</h3>
                                    <div class="ml-auto">
                                        <a href="{{ URL('admin/master_inventory/add') }}" class="btn btn-sm btn-primary">ADD <i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                                <div class="py-2 px-3">
                                    <p class="text-info m-0">* Stok berdasarkan dari satuan terkecil per unit</p>
                                    <p class="text-info">* Harga berdasarkan dari satuan terkecil per tier dari atas (General - Bronze - Silver - Gold)</p>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <td class="d-none"></td>
                                                <th>Code</th>
                                                <th>Name</th>
                                                <th>Category</th>
                                                <th>Stok*</th>
                                                <th>Harga*</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($list_inventory as $dt )
                                            <tr>
                                                <td class="d-none">{{$dt->id}}</td>
                                                <td>{{$dt->code}}</td>
                                                <td>{{$dt->name}}</td>
                                                <td>{{$dt->category}}</td>
                                                <td>{{$dt->stok}}</td>
                                                <td>
                                                    Rp. {{$dt->list_harga[0]}} (General)<br>
                                                    Rp. {{$dt->list_harga[1]}} (Bronze)<br>
                                                    Rp. {{$dt->list_harga[2]}} (Silver)<br>
                                                    Rp. {{$dt->list_harga[3]}} (Gold)
                                                </td>
                                                <td>
                                                    <a href="{{ URL('admin/master_inventory/edit/'.$dt->id) }}" class="btn btn-sm btn-primary" title="edit inventory">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a href="{{ URL('admin/master_inventory/view_stok/'.$dt->id) }}" class="btn btn-sm btn-primary" title="Lihat stok">
                                                        <i class="fa fa-list"></i>
                                                    </a>
                                                    <button class="btn btn-sm btn-danger" onclick="clickDelete('{{$dt->id}}')"><i class="fa fa-trash"></i></button>
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
<form id="formDelete" action="{{URL('admin/master_inventory/delete')}}" method="POST">
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