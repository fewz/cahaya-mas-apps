<!DOCTYPE html>
<html lang="en">
@include('header')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('customer.sidebar', ['activePage' => 'pesanan_saya'])
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h1 class="m-0">
                                <a href="{{URL('customer/pesanan_saya')}}">Pesanan Saya</a>
                                / Detail
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
                            <h3 class="card-title">Transaksi</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="formadd" action="{{URL('admin/transaction/do_add')}}" method="POST">
                            @csrf
                            <?php $status = ["Draft", "Selesai", "Belum Lunas", "Belum Dikirim", "Siap Dikirim", "Sedang Dikirim", "Terkirim"]; ?>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Order Number</label>
                                    <input type="text" class="form-control" placeholder="Order Number" value="{{$data_order->order_number}}" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Order</label>
                                    <input type="date" class="form-control" name="created_date" placeholder="Tanggal Order" value="{{$data_order->created_date}}" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Payment Method</label>
                                    <input type="text" class="form-control" name="created_date" placeholder="Tanggal Order" value="{{$data_order->payment_method}}" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <input type="text" class="form-control" name="created_date" placeholder="Tanggal Order" value="{{$status[$data_order->status]}}" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Transaction Type</label>
                                    <input type="text" class="form-control" name="created_date" placeholder="Tanggal Order" value="{{$data_order->transaction_type}}" disabled>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div id="container3" class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Detail Belanja</h3>
                        </div>
                        <div class="card-body">
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
                                        </tr>
                                    </thead>
                                    <tbody id="tableBody">
                                        @foreach ($data_product as $data )
                                        <tr>
                                            <td>{{$data->product_code}}</td>
                                            <td>{{$data->product_name}}</td>
                                            <td>{{$data->unit_name}}</td>
                                            <td>{{$data->qty}}</td>
                                            <td>{{number_format($data->sell_price,0,"",".")}}</td>
                                            <td>{{number_format($data->diskon,0,"",".")}}</td>
                                            <td>{{number_format($data->sub_total,0,"",".")}}</td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="6" style="font-weight:bold; text-align:right;">Diskon Poin</td>
                                            <td>{{number_format($data_order->diskon_poin,0,"",".")}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" style="font-weight:bold; text-align:right;">Grand Total</td>
                                            <td>{{number_format($data_order->grand_total,0,"",".")}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            @if($data_order->status === 6)
                            <form action="{{URL('customer/detail_pesanan/do_finish')}}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{$data_order->id}}">
                                <button class="btn btn-primary">Konfirmasi Terima Barang</button>
                            </form>
                            @endif
                            @if($data_order->status === 2)
                            <form action="{{URL('customer/detail_pesanan/upload_bukti_transfer')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{$data_order->id}}">
                                <input class="required" type="file" name="file" accept="image/png, image/jpeg">
                                <button class="btn btn-primary">Upload Bukti Transfer</button>
                            </form>
                            @endif
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
    let listProduk = [];

    let customer = $("#customer").val();
    let selectedCustomer = listCustomer.filter((val) => val.id == customer)[0];

    let selectedProductPrice = 0;
    let selectedProductStock = 0;
    let subTotalProduct = 0;

    function initialize() {
        getProductSupplier();
        customerChange();
    }

    function getPriceAndStock() {
        const id_unit = JSON.parse($("#unitproduk").val()).id;
        const produkBaru = $("#listproduk").val();
        const object = JSON.parse(produkBaru);
        $.get(`/api/get_price_and_stock?id_unit=${id_unit}&id_inventory=${object.id_product}&tier=${selectedCustomer.tier_customer}`, function(data) {
            console.log('dat', data);

            const payload = data.payload;
            $("#label_stok_produk").html(payload.stock);
            $("#label_harga_produk").html(payload.pricing.sell_price);
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
        $("#label_subtotal_produk").html(qty * selectedProductPrice);
        subTotalProduct = qty * selectedProductPrice;
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
            getPriceAndStock();
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

        $("#id_customer").val($("#customer").val());
        $("#grand_total").val(grand_total);
        $("#list_produk").val(JSON.stringify(jsonObject));

        $('#formadd').submit();
    }

    let grand_total = 0;

    function getJSONProduk() {
        grand_total = 0;
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
                price: obj.subtotal / parseInt(obj.qty)
            }
            grand_total += obj.subtotal;
            result.push(res);
        });

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
            console.log('tee', object);
            const key = object.product_code + '-' + unit.name;
            const row = `<tr>
                            <td>${object.product_code}</td>
                            <td>${object.product_name}</td>
                            <td>${unit.name}</td>
                            <td>${object.qty}</td>
                            <td>${object.harga}</td>
                            <td>${object.subtotal}</td>
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
        console.log('avai', availableProduct);
        initialize();

    });
</script>

</html>