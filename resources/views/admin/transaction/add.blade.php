<!DOCTYPE html>
<html lang="en">
@include('header')

<?php

use App\Helpers\CommonHelper;
?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('admin.sidebar', ['activePage' => 'transaction'])
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h1 class="m-0">
                                <a href="{{URL('admin/transaction')}}">Transaksi</a>
                                / New
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
                    <div id="container1" class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Transaksi Baru</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="formadd" action="{{URL('admin/transaction/do_add')}}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Tanggal Order</label>
                                    <input type="date" class="form-control required" name="created_date" placeholder="Tanggal Order">
                                </div>
                                <div class="form-group">
                                    <label>Metode Pembayaran</label>
                                    <select id="payment_method" class="form-control select2bs4" name="payment_method" style="width: 100%;" onchange="paymentMethodChange(this)">
                                        <option value="CASH">Cash</option>
                                        <option value="CREDIT">Credit</option>
                                    </select>
                                </div>
                                <div class="form-group d-none" id="jatuh_tempo">
                                    <label>Tanggal Jatuh Tempo</label>
                                    <input type="date" class="form-control" name="due_date" placeholder="Tanggal Jatuh Tempo" id="due_date">
                                </div>
                                <div class="form-group">
                                    <label>Tipe Transaksi</label>
                                    <select class="form-control select2bs4" name="type" style="width: 100%;" id="type_transaction">
                                        <option value="OFFLINE">Offline</option>
                                        <option value="DELIVERY">Delivery</option>
                                    </select>
                                </div>
                                <input type="hidden" id="list_produk" name="list_produk">
                                <input type="hidden" id="grand_total" name="grand_total">
                                <input type="hidden" id="total_diskon" name="total_diskon">
                                <input type="hidden" id="id_customer" name="id_customer">
                                <input type="hidden" id="diskon_poin" name="diskon_poin">
                            </div>
                        </form>
                    </div>

                    <div id="container2" class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Customer</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Customer</label>
                                <select id="customer" class="form-control select2bs4" name="id_customer" style="width: 100%;" onchange="customerChange()">
                                    @foreach ($list_customer as $dt)
                                    <option value="{{$dt->id}}">{{$dt->full_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label>Kode Customer</label>
                                    <p id="label_kode_customer"></p>
                                </div>
                                <div class="col-6">
                                    <label>Phone</label>
                                    <p id="label_phone_customer"></p>
                                </div>
                                <div class="col-6">
                                    <label>Alamat</label>
                                    <p id="label_alamat_customer"></p>
                                </div>
                                <div class="col-6">
                                    <label>Tier</label>
                                    <p id="label_tier_customer"></p>
                                </div>
                                <div class="col-6">
                                    <label>Poin</label>
                                    <p id="label_poin_customer"></p>
                                </div>
                                <div class="col-6">
                                    <label>Pakai Poin</label>
                                    <input type="number" class="form-control" onchange="poinChange()" id="poin">
                                </div>
                            </div>
                            <!-- <div class="custom-control custom-checkbox" id="bisa_cashback">
                                <input class="custom-control-input" type="checkbox" id="use_point">
                                <label for="use_point" class="custom-control-label">Pakai poin cashback</label>
                            </div> -->
                        </div>
                    </div>

                    <div id="container3" class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Tambah Produk</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Produk</label>
                                <select id="listproduk" class="form-control select2bs4" style="width: 100%;" onchange="getUnit()">
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Unit</label>
                                <select id="unitproduk" class="form-control select2bs4" style="width: 100%;" onchange="getPriceAndStock()">
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Qty</label>
                                <input onclick="this.select();" id="qtyproduk" type="number" class="form-control required" placeholder="Qty" value="0" onchange="countSubTotal()" />
                            </div>
                            <div class="row mt-3">
                                <div class="col-6">
                                    <label>Stok</label>
                                    <p id="label_stok_produk"></p>
                                </div>
                                <div class="col-6">
                                    <label>Harga</label>
                                    <p id="label_harga_produk"></p>
                                </div>
                                <div class="col-6">
                                    <label>Minimal Beli untuk Potongan</label>
                                    <p id="label_minimal_diskon"></p>
                                </div>
                                <div class="col-6">
                                    <label>Diskon per unit</label>
                                    <p id="label_diskon_produk">-</p>
                                </div>
                                <div class="col-6">
                                    <label>Total Diskon</label>
                                    <p id="label_total_diskon">-</p>
                                </div>
                                <div class="col-6">
                                    <label>Subtotal</label>
                                    <p id="label_subtotal_produk"></p>
                                </div>
                            </div>
                            <button class="btn btn-primary mt-3" onclick="tambahProduk()">Tambah Produk ke Keranjang</button>

                            <div class="form-group mt-3">
                                <label>Keranjang Belanja</label>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Kode</th>
                                            <th>Nama</th>
                                            <th>Unit</th>
                                            <th>Qty</th>
                                            <th>Harga</th>
                                            <th>Diskon</th>
                                            <th>Subtotal</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableBody">
                                    </tbody>
                                </table>
                            </div>
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
    let availableProduct = <?php echo $list_inventory; ?>;
    let listCustomer = <?php echo $list_customer; ?>;

    let customer = $("#customer").val();
    let selectedCustomer = listCustomer.filter((val) => val.id == customer)[0];

    let selectedProductPrice = 0;
    let selectedProductStock = 0;
    let subTotalProduct = 0;
    let selectedMinimalDiskon = null;
    let selectedDiskon = 0;

    function initialize() {
        getProductSupplier();
        customerChange();
    }

    function hitungDiskon() {
        $("#label_diskon_produk").html('-');
        $("#label_total_diskon").html('0');
        $("#label_minimal_diskon").html(selectedMinimalDiskon);
        if (selectedMinimalDiskon && selectedMinimalDiskon <= $("#qtyproduk").val()) {
            selectedProductPrice -= selectedDiskon;
            $("#label_diskon_produk").html(numberWithCommas(selectedDiskon));
            $("#label_subtotal_produk").html(numberWithCommas(subTotalProduct));
            const qty = $("#qtyproduk").val();
            $("#label_total_diskon").html(qty * selectedDiskon);
        }
    }

    function getPriceAndStock() {
        const id_unit = JSON.parse($("#unitproduk").val()).id;
        const produkBaru = $("#listproduk").val();
        const object = JSON.parse(produkBaru);
        $.get(`/api/get_price_and_stock?id_unit=${id_unit}&id_inventory=${object.id_product}&tier=${selectedCustomer.tier_customer}`, function(data) {

            const payload = data.payload;
            $("#label_stok_produk").html(numberWithCommas(payload.stock));
            $("#label_harga_produk").html(numberWithCommas(payload.pricing.sell_price));
            if (payload.discount) {
                selectedMinimalDiskon = payload.discount.minimal;
                selectedDiskon = payload.discount.potongan;
            } else {
                selectedMinimalDiskon = null;
                selectedDiskon = 0;
            }
            selectedProductPrice = payload.pricing.sell_price;
            selectedProductStock = payload.stock;
            countSubTotal();
        }).fail(function(error) {
            console.error('Error fetching API data', error);
        });
    }

    function countSubTotal() {

        if ($("#qtyproduk").val() > selectedProductStock) {
            $("#qtyproduk").val(selectedProductStock);
        }
        const qty = $("#qtyproduk").val();
        hitungDiskon();
        subTotalProduct = qty * selectedProductPrice;
        $("#label_subtotal_produk").html(numberWithCommas(subTotalProduct));
    }

    function customerChange() {
        customer = $("#customer").val();
        selectedCustomer = listCustomer.filter((val) => val.id == customer)[0];

        $("#label_kode_customer").html(selectedCustomer.code);
        $("#label_phone_customer").html(selectedCustomer.phone);
        $("#label_alamat_customer").html(selectedCustomer.address);
        $("#label_tier_customer").html(selectedCustomer.tier_customer);
        $("#label_poin_customer").html(selectedCustomer.poin);

        if (parseInt(selectedCustomer.poin) <= 0) {
            $("#bisa_cashback").addClass('d-none');
        }
    }

    function getProductSupplier() {
        $("#listproduk option").remove();
        availableProduct.forEach((val) => {
            optionText = val.name;
            optionValue = {
                id_product: val.id,
                product_name: val.name,
                product_code: val.code
            };

            $('#listproduk').append(new Option(optionText, JSON.stringify(optionValue)));
        });
        getUnit();
    }

    function getUnit() {
        $("#unitproduk option").remove();
        const produkBaru = $("#listproduk").val();
        const object = JSON.parse(produkBaru);

        $.get(`/api/available_unit?id=${object.id_product}`, function(data) {
            const unit = data.payload;
            unit.forEach((val) => {
                optionText = val.name;
                optionValue = {
                    id: val.id,
                    name: val.name
                };

                $('#unitproduk').append(new Option(optionText, JSON.stringify(optionValue)));
            });
            getPriceAndStock();
        }).fail(function(error) {
            console.error('Error fetching API data', error);
        });
    }

    function paymentMethodChange(comp) {
        if ($(comp).val() === "CREDIT") {
            $("#jatuh_tempo").removeClass('d-none');
        } else {
            $("#jatuh_tempo").addClass('d-none');
        }

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

        if ($("#payment_method").val() === 'CREDIT') {
            if (!$("#due_date").val()) {
                swal('Tanggal jatuh tempo tidak boleh kosong');
                return;
            }
        }
        if ($("#type_transaction").val() === 'DELIVERY') {
            console.log(grand_total);
            if (parseInt(grand_total) < 5000000) {
                swal('Transaksi Minimal untuk Delivery adalah 5.000.000');
                return;
            }
        }

        $("#id_customer").val($("#customer").val());
        $("#grand_total").val(grand_total);
        $("#list_produk").val(JSON.stringify(jsonObject));
        $("#total_diskon").val(total_diskon);
        $("#diskon_poin").val(diskon_poin);

        $('#formadd').submit();
    }

    let grand_total = 0;
    let total_diskon = 0;
    let useDiskonPoint = 0;

    function getJSONProduk() {
        grand_total = 0;
        total_diskon = 0;
        diskon_poin = 0;
        const result = [];
        listProduk.forEach((val, i) => {
            const obj = JSON.parse(val);

            const unit = JSON.parse(obj.unit);
            const key = obj.product_code + '-' + unit.name;

            const qty = getInputValue(key, 'qty');

            const res = {
                id_product: obj.id_product,
                id_unit: unit.id,
                qty: parseInt(obj.qty),
                subtotal: obj.subtotal,
                diskon: obj.diskon,
                price: obj.harga
            }
            grand_total += obj.subtotal;
            total_diskon += obj.diskon;
            result.push(res);
        });

        if (selectedCustomer.poin > 0) {
            diskon_poin = useDiskonPoint;
            grand_total -= diskon_poin;
        }

        return result;

    }

    function tambahProduk() {
        const produkBaru = $("#listproduk").val();
        const unit = $("#unitproduk").val();
        const object = JSON.parse(produkBaru);
        const objectUnit = JSON.parse(unit);

        let duplicate = false;
        listProduk.forEach((val) => {
            console.log('tes', val);

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
        object.qty = $("#qtyproduk").val();
        object.harga = selectedProductPrice;
        object.subtotal = subTotalProduct;
        object.minimal_diskon = selectedMinimalDiskon;
        object.besar_diskon = selectedDiskon;
        object.stok = selectedProductStock;
        object.diskon = 0;
        if (selectedMinimalDiskon && selectedMinimalDiskon <= $("#qtyproduk").val()) {
            object.diskon = selectedDiskon * object.qty;
        }

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
        let total = 0;
        listProduk.forEach((item, i) => {
            const object = JSON.parse(item);
            const unit = JSON.parse(object.unit);
            console.log('tee', object);
            const key = object.product_code + '-' + unit.name;
            const row = `<tr>
                            <td>${object.product_code}</td>
                            <td>${object.product_name}</td>
                            <td>${unit.name}</td>
                            <td>${object.qty}</td>
                            <td>${numberWithCommas(object.harga)}</td>
                            <td>${numberWithCommas(object.diskon)}</td>
                            <td>${numberWithCommas(object.subtotal)}</td>
                            <td>
                                <button class="btn btn-sm btn-primary" onclick="minus(${i})"><i class="fa fa-minus"></i></button>
                                <button class="btn btn-sm btn-primary" onclick="plus(${i})"><i class="fa fa-plus"></i></button>
                                <button class="btn btn-sm btn-danger" onclick="clickDelete(${i})"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>`;
            $('#tableBody').append(row);
            total += object.subtotal;
        });
        if (useDiskonPoint > 0) {
            if (useDiskonPoint > total) {
                useDiskonPoint = total;
                $("#poin").val(useDiskonPoint);
            }
            const row = `<tr>
                        <td colspan="6" style="font-weight:bold; text-align:right;">Diskon Poin</td>
                        <td colspan="2" style="font-weight:bold; text-align:left;">${numberWithCommas(useDiskonPoint)}</td>
                    </tr>`;
            $("#tableBody").append(row);
            total -= useDiskonPoint;
        }
        const row = `<tr>
                        <td colspan="6" style="font-weight:bold; text-align:right;">Grand Total</td>
                        <td colspan="2" style="font-weight:bold; text-align:left;">${numberWithCommas(total)}</td>
                    </tr>`;
        $("#tableBody").append(row);
    }

    function plus(index) {
        const prod = JSON.parse(listProduk[index]);
        if (prod.qty <= prod.stok - 1) {
            prod.qty = parseInt(prod.qty) + 1;
            prod.subtotal = (prod.qty * prod.harga);
            if (prod.qty >= prod.minimal_diskon) {
                prod.subtotal -= prod.besar_diskon;
                prod.diskon = prod.besar_diskon;
            } else {
                prod.diskon = 0;
            }
            listProduk[index] = JSON.stringify(prod);
            updateTable();
        }
    }

    function minus(index) {
        const prod = JSON.parse(listProduk[index]);
        if (prod.qty >= 2) {
            prod.qty = parseInt(prod.qty) - 1;
            prod.subtotal = (prod.qty * prod.harga);
            if (prod.qty >= prod.minimal_diskon) {
                prod.subtotal -= prod.besar_diskon;
                prod.diskon = prod.besar_diskon;
            } else {
                prod.diskon = 0;
            }
            listProduk[index] = JSON.stringify(prod);
            updateTable();
        }
    }

    function clickDelete(index) {
        listProduk.splice(index, 1);
        updateTable();
    }

    function poinChange() {
        const point = $("#poin").val();
        useDiskonPoint = point;
        if (point > selectedCustomer.poin) {
            useDiskonPoint = selectedCustomer.poin;
            $("#poin").val(selectedCustomer.poin);
        }
        updateTable();
    }
    $(function() {
        console.log('avai', availableProduct);
        initialize();

    });
</script>

</html>