<!DOCTYPE html>
<html lang="en">
@include('header')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('admin.sidebar', ['activePage' => 'purchase_order'])
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h1 class="m-0">
                                <a href="{{URL('admin/purchase_order')}}">Purchase Order</a>
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
                            <h3 class="card-title">Add New Purchase Order</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="formadd" action="{{URL('admin/purchase_order/do_add')}}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Tanggal Order</label>
                                    <input type="date" class="form-control required" name="created_date" placeholder="Tanggal Order">
                                </div>
                                <div class="form-group">
                                    <label>Supplier</label>
                                    <select id="supplier" class="form-control select2bs4" name="id_supplier" style="width: 100%;" onchange="getProductSupplier()">
                                        @foreach ($list_supplier as $dt)
                                        <option value="{{$dt->id}}">{{$dt->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control select2bs4" name="status" style="width: 100%;" disabled>
                                        <option value="0">Draft</option>
                                    </select>
                                </div>
                                <input type="hidden" id="list_produk" name="list_produk">
                            </div>
                        </form>
                    </div>

                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Tambah Produk</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Produk Supplier</label>
                                <select id="produksupplier" class="form-control select2bs4" style="width: 100%;" onchange="getUnit()">
                                </select>
                                <label>Unit</label>
                                <select id="unitproduk" class="form-control select2bs4" style="width: 100%;">
                                </select>
                                <button class="btn btn-primary mt-3" onclick="tambahProduk()">Tambah Produk</button>
                            </div>

                            <label>Produk Supplier</label>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Unit</th>
                                        <th>Qty</th>
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

    function getProductSupplier() {
        $("#produksupplier option").remove();
        const idSupplier = $("#supplier").val();
        $.get(`/api/product_supplier?id=${idSupplier}`, function(data) {
            const product = data.payload;
            console.log('prd', product);

            product.forEach((val) => {
                optionText = val.product_name;
                optionValue = {
                    id_product: val.id_product,
                    product_name: val.product_name,
                    product_code: val.product_code
                };

                $('#produksupplier').append(new Option(optionText, JSON.stringify(optionValue)));
            });
            getUnit();
        }).fail(function(error) {
            console.error('Error fetching API data', error);
        });
    }

    function getUnit() {
        $("#unitproduk option").remove();
        const produkBaru = $("#produksupplier").val();
        const object = JSON.parse(produkBaru);
        console.log('object', object);

        $.get(`/api/available_unit?id=${object.id_product}`, function(data) {
            console.log('dat', data);

            const unit = data.payload;
            unit.forEach((val) => {
                optionText = val.name;
                optionValue = {
                    id: val.id,
                    name: val.name
                };

                $('#unitproduk').append(new Option(optionText, JSON.stringify(optionValue)));
            });
        }).fail(function(error) {
            console.error('Error fetching API data', error);
        });
    }

    function submit() {
        // submit form
        saveInputValues();
        if (!validateForm()) {
            // validate form required
            return;
        }
        const jsonObject = getJSONProduk();
        console.log('js', jsonObject);

        $("#list_produk").val(JSON.stringify(jsonObject));

        $('#formadd').submit();
    }

    function getJSONProduk() {

        const result = [];
        listProduk.forEach((val, i) => {
            const obj = JSON.parse(val);
            const unit = JSON.parse(obj.unit);
            const key = obj.product_code + '-' + unit.name;

            const qty = getInputValue(key, 'qty');

            const res = {
                id_product: obj.id_product,
                id_unit: unit.id,
                qty: qty
            }
            result.push(res);
        });

        return result;

    }

    function tambahProduk() {
        const produkBaru = $("#produksupplier").val();
        const unit = $("#unitproduk").val();
        const object = JSON.parse(produkBaru);
        const objectUnit = JSON.parse(unit);

        let duplicate = false;
        listProduk.forEach((val) => {
            const obj = JSON.parse(val);
            const un = JSON.parse(obj.unit);
            if (obj.product_name === object.product_name && un.id === objectUnit.id) {
                duplicate = true;
            }
        });

        if (duplicate) {
            swal("Produk sudah ditambahkan", "", "warning");
            return;
        };


        object.unit = unit;

        listProduk.push(JSON.stringify(object));
        updateTable();
    }

    const inputValues = {};

    // Save input values into the inputValues object
    function saveInputValues() {
        $('input[type="number"]').each(function() {
            const key = $(this).attr('name');
            const value = $(this).val();
            inputValues[key] = value;
        });
    }

    // Get saved input value for a specific unit and field
    function getInputValue(unitId, field) {
        const key = `${field}[${unitId}]`;
        return inputValues[key] || '';
    }

    function updateTable() {
        // Store the current input values before updating
        saveInputValues();

        // Clear the table body
        $('#tableBody').empty();
        // Populate the table with selected items and their stored values
        listProduk.forEach((item, i) => {
            const object = JSON.parse(item);
            const unit = JSON.parse(object.unit);
            const key = object.product_code + '-' + unit.name;
            const row = `<tr>
                            <td>${object.product_code}</td>
                            <td>${object.product_name}</td>
                            <td>${unit.name}</td>
                            <td><input class="form-control" type="number" name="qty[${key}]" value="${getInputValue(key, 'qty')}"/></td>
                            <td><button class="btn btn-sm btn-danger" onclick="clickDelete(${i})"><i class="fa fa-trash"></i></button></td>
                        </tr>`;
            $('#tableBody').append(row);
        });
    }

    function clickDelete(index) {
        listProduk.splice(index, 1);
        updateTable();
    }
    $(function() {
        getProductSupplier();

    });
</script>

</html>