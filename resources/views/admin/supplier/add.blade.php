<!DOCTYPE html>
<html lang="en">
@include('header')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('admin.sidebar', ['activePage' => 'master_supplier'])
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h1 class="m-0">
                                <a href="{{URL('admin/master_supplier')}}">Master Supplier</a>
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
                            <h3 class="card-title">Add New Supplier</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="formadd" action="{{URL('admin/master_supplier/do_add')}}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Code Supplier</label>
                                    <input type="text" class="form-control required" name="code" placeholder="Code">
                                </div>
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control required" name="name" placeholder="Name">
                                </div>
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="text" class="form-control required" name="phone" placeholder="Phone">
                                </div>
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" class="form-control required" name="address" placeholder="Address">
                                </div>
                                <input type="hidden" id="list_produk" name="list_produk">
                            </div>
                        </form>
                    </div>

                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Tambah Produk Supplier</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Tambah Produk Supplier</label>
                                <select id="produksupplier" class="form-control select2bs4" name="id_product" style="width: 100%;">
                                    @foreach ($list_inventory as $dt )
                                    <option value="{{$dt->id. '-' . $dt->name}}">{{$dt->name}}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-primary mt-3" onclick="tambahProduk()">Tambah Produk</button>
                            </div>

                            <label>Produk Supplier</label>
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <div class="btn btn-primary" onclick="submit()">Submit</div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</body>

@include('script_footer')
<script>
    let listProduk = [];

    function submit() {
        // submit form
        if (!validateForm()) {
            // validate form required
            return;
        }

        const list_produk = listProduk.map(val => val.split('-', 1)[0]);
        $("#list_produk").val(list_produk);

        $('#formadd').submit();
    }

    function tambahProduk() {
        const produkBaru = $("#produksupplier").val();

        if (listProduk.includes(produkBaru)) {
            swal("Produk sudah ada", "", "warning");
            return;
        }
        listProduk.push(produkBaru);
        console.log('listpr', listProduk);
        updateTable();
    }

    function updateTable() {

        // Clear the table body
        $('#tableBody').empty();
        // Populate the table with selected items and their stored values
        listProduk.forEach((item, i) => {
            const name = item.split('-', 2);
            const row = `<tr>
                            <td>${name[1]}</td>
                            <td><button class="btn btn-sm btn-danger" onclick="clickDelete(${i})"><i class="fa fa-trash"></i></button></td>
                        </tr>`;
            $('#tableBody').append(row);
        });
    }

    function clickDelete(index) {
        listProduk.splice(index, 1);
        updateTable();
    }
</script>

</html>