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
                                / View
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
                            <h3 class="card-title">Purchase Order</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="formadd" action="{{URL('admin/purchase_order/do_finish').'/'.$data_purchase_order->id}}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Order Number</label>
                                    <input disabled type="text" class="form-control" name="order_number" placeholder="Order Number" value="{{$data_purchase_order->order_number}}">
                                </div>
                                <div class="form-group">
                                    <label>Supplier</label>
                                    <select disabled id="supplier" class="form-control select2bs4" name="id_supplier" style="width: 100%;">
                                        @foreach ($list_supplier as $dt )
                                        @if ($dt->id === $data_purchase_order->id_supplier)
                                        <option value="{{$dt->id}}" selected>{{$dt->name}}</option>
                                        @else
                                        <option value="{{$dt->id}}">{{$dt->name}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <select disabled class="form-control select2bs4" name="status" style="width: 100%;">
                                        <option value="0" <?php echo $data_purchase_order->status === 0 ? 'selected' : ''; ?>>Draft</option>
                                        <option value="1" <?php echo $data_purchase_order->status === 1 ? 'selected' : ''; ?>>Diproses Supplier</option>
                                        <option value="2" <?php echo $data_purchase_order->status === 2 ? 'selected' : ''; ?>>Selesai</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Created Date</label>
                                    <input type="date" class="form-control" value="{{$data_purchase_order->created_date}}" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Finish Date</label>
                                    <input type="date" class="form-control" value="{{$data_purchase_order->finish_date}}" name="finish_date" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Payment Method</label>
                                    <input type="text" class="form-control" value="{{$data_purchase_order->payment_method}}" disabled>
                                </div>
                                @if(isset($data_purchase_order->due_date))
                                <div class="form-group">
                                    <label>Due Date</label>
                                    <input type="date" class="form-control" value="{{$data_purchase_order->due_date}}" disabled>
                                </div>
                                @endif
                                <input type="hidden" id="list_produk" name="list_produk">
                                <input type="hidden" id="grand_total" name="grand_total">
                            </div>
                        </form>
                    </div>

                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Ringkasan Produk yang diterima</h3>
                        </div>
                        <div class="card-body">
                            <label>Produk yang terkirim</label>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Unit</th>
                                        <th>Qty Order</th>
                                        <th>Qty Terima</th>
                                        <th>Harga per unit</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                </tbody>
                            </table>

                            <div class="mt-3 float-right text-right">
                                <label>Grand Total</label>
                                <p id="totalHarga">Rp. {{number_format($data_purchase_order->grand_total,0,'.','.')}}</p>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>

                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Detail Penerimaan barang</h3>
                        </div>
                        <div class="card-body">
                            <label>Detail Penerimaan barang</label>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width:150px;">Pengiriman ke</th>
                                        <th>Tanggal</th>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Unit</th>
                                        <th>Expired</th>
                                        <th>Qty</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                    @foreach ($data_log as $data )
                                        <tr>
                                            <td>{{$data->pengiriman_ke}}</td>
                                            <td>{{$data->created_date}}</td>
                                            <td>{{$data->product_code}}</td>
                                            <td>{{$data->product_name}}</td>
                                            <td>{{$data->unit_name}}</td>
                                            <td>{{$data->exp_date}}</td>
                                            <td>{{$data->qty}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </section>
        </div>
    </div>
</body>

@include('script_footer')
<script>
    let listProduk = <?php echo $data_product; ?>;
    console.log('li', listProduk);


    $(function() {
        const temp = listProduk;
        listProduk = [];
        temp.forEach((val, index) => {
            console.log('index', index);
            console.log('val', val);

            const unit = {
                id: val.id_unit,
                name: val.unit_name
            };
            const res = {
                id_product: val.id_inventory,
                product_name: val.product_name,
                product_code: val.product_code,
                price: val.price_buy,
                qty: val.qty,
                qty_order: val.order_qty,
                date_expired: val.date_expired,
                unit: JSON.stringify(unit)
            };
            const key = val.product_code + '-' + val.unit_name;
            inputValues[`qty[${key}]`] = val.qty;
            inputValues[`price[${key}]`] = 0;
            listProduk.push(JSON.stringify(res));
        });
        saveInputValues();

        updateTable();
    });

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
            const harga = getInputValue(key, 'price');
            const expdate = getInputValue(key, 'expdate');
            const res = {
                id_product: obj.id_product,
                id_unit: unit.id,
                qty: qty,
                price: harga,
                expdate: expdate
            }
            result.push(res);
        });

        return result;

    }

    function tambahProduk() {
        const produkBaru = $("#produksupplier").val();
        const object = JSON.parse(produkBaru);
        object.unit = $("#unitproduk").val();

        listProduk.push(JSON.stringify(object));
        updateTable();
    }

    function hitungTotal() {
        saveInputValues();
        let totalHarga = 0;
        console.log('inputval', inputValues);
        listProduk.forEach((val) => {
            const obj = JSON.parse(val);
            const unit = JSON.parse(obj.unit);
            const key = obj.product_code + '-' + unit.name;
            const harga = getInputValue(key, 'price') || 0;
            const qty = getInputValue(key, 'qty') || 0;
            console.log('har', harga);


            totalHarga += (parseInt(harga) * parseInt(qty));
        })

        $("#totalHarga").text('Rp. ' + numberWithCommas(totalHarga));
        $("#grand_total").val(totalHarga);
    }

    const inputValues = {};

    // Save input values into the inputValues object
    function saveInputValues() {
        $('#tableBody input[type="number"], #tableBody input[type="date"]').each(function() {
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
                            <td>${object.qty_order}</td>
                            <td>${object.qty}</td>
                            <td>Rp. ${numberWithCommas(object.price)}</td>
                        </tr>`;
            $('#tableBody').append(row);
        });
    }

    function clickDelete(index) {
        console.log('d', inputValues);
        listProduk.splice(index, 1);
        updateTable();
    }
</script>

</html>