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
                            <h1 class="m-0">
                                <a href="{{URL('admin/master_inventory')}}">Master Inventory</a>
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
                            <h3 class="card-title">Add New Inventory</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="formadd" action="{{URL('admin/master_inventory/do_add')}}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control required" name="name" placeholder="Name">
                                </div>
                                <div class="form-group">
                                    <label>Category</label>
                                    <select class="form-control select2bs4" name="id_category" style="width: 100%;">
                                        @foreach ($list_category as $dt )
                                        <option value="{{$dt->id}}">{{$dt->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <input id="pricing" type="hidden" name="pricing" />
                            <input id="units" type="hidden" name="units" />
                            <input id="satuan_terkecil" type="hidden" name="satuan_terkecil" />
                        </form>
                    </div>

                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Unit & Pricing</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Satuan Terkecil</label>
                                <input type="text" id="satuanterkecil" class="form-control required" placeholder="Satuan Terkecil" onchange="updateTable()">
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tambah Satuan Baru</label>
                                <input id="satuanBaru" type="text" class="form-control" placeholder="Satuan Baru">
                                <button class="btn btn-primary mt-3" onclick="tambahSatuan()">Tambah</button>
                            </div>
                            <label>Pricing by Tier</label>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Unit</th>
                                        <th>Per satuan terkecil</th>
                                        <th>General</th>
                                        <th>Bronze</th>
                                        <th>Silver</th>
                                        <th>Gold</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                </tbody>
                            </table>
                        </div>
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
    const $satuanBaru = $("#satuanBaru");

    var setting = JSON.parse('<?php echo $setting; ?>').reduce((obj, item) => (obj[item.name] = item.value, obj), {});

    let listSatuan = [];

    function submit() {
        // submit form
        if (!validateForm()) {
            // validate form required
            return;
        }
        const jsonData = generateJSON();
        console.log(jsonData);

        const groupedData = groupJSON(jsonData);
        console.log(groupedData);
        $("#pricing").val(JSON.stringify(groupedData));
        $("#satuan_terkecil").val($("#satuanterkecil").val());

        $('#formadd').submit();
    }

    function groupJSON(data) {

        const groupedData = {};

        for (const item of data) {
            const {
                unit,
                name,
                value
            } = item;

            if (!groupedData[unit]) {
                groupedData[unit] = {};
            }

            if (!groupedData[unit][name]) {
                groupedData[unit][name] = [];
            }

            groupedData[unit][name].push(value);
        }
        return groupedData;
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
        const satuanTerkecil = $("#satuanterkecil").val();
        const firstRow = `<tr>
                            <td>${satuanTerkecil}</td>
                            <td></td>
                            <td><input type="number" class="form-control required" name="general[${satuanTerkecil}]" min="0" value="${getInputValue(satuanTerkecil, 'general')}" id="general-${satuanTerkecil}" onchange="generalChange('${satuanTerkecil}')"></td>
                            <td><input type="number" class="form-control required" name="bronze[${satuanTerkecil}]" min="0" value="${getInputValue(satuanTerkecil, 'bronze')}" id="bronze-${satuanTerkecil}"></td>
                            <td><input type="number" class="form-control required" name="silver[${satuanTerkecil}]" min="0" value="${getInputValue(satuanTerkecil, 'silver')}" id="silver-${satuanTerkecil}"></td>
                            <td><input type="number" class="form-control required" name="gold[${satuanTerkecil}]" min="0" value="${getInputValue(satuanTerkecil, 'gold')}" id="gold-${satuanTerkecil}"></td>
                        </tr>`;
        $('#tableBody').append(firstRow);

        // Populate the table with selected items and their stored values
        listSatuan.forEach((item, i) => {
            const row = `<tr>
                            <td>${item}</td>
                            <td><input type="number" class="form-control required" name="refunit[${item}]" min="0" value="${getInputValue(item, 'refunit')}"></td>
                            <td><input type="number" class="form-control required" name="general[${item}]" min="0" value="${getInputValue(item, 'general')}" id="general-${item}" onchange="generalChange('${item}')"></td>
                            <td><input type="number" class="form-control required" name="bronze[${item}]" min="0" value="${getInputValue(item, 'bronze')}" id="bronze-${item}"></td>
                            <td><input type="number" class="form-control required" name="silver[${item}]" min="0" value="${getInputValue(item, 'silver')}" id="silver-${item}"></td>
                            <td><input type="number" class="form-control required" name="gold[${item}]" min="0" value="${getInputValue(item, 'gold')}" id="gold-${item}"></td>
                            <td><button class="btn btn-sm btn-danger" onclick="clickDelete(${i})"><i class="fa fa-trash"></i></button></td>
                        </tr>`;
            $('#tableBody').append(row);
        });
    }

    function generalChange(key) {
        const val = parseInt($("#general-" + key).val());
        // console.log('set', setting);
        $("#bronze-" + key).val(val + parseInt(setting['MARGIN_PRICE_GENERAL_BRONZE']));
        $("#silver-" + key).val(val + parseInt(setting['MARGIN_PRICE_GENERAL_SILVER']));
        $("#gold-" + key).val(val + parseInt(setting['MARGIN_PRICE_GENERAL_GOLD']));
    }

    function tambahSatuan() {
        console.log('list', listSatuan);

        if ($satuanBaru.val() === '') {
            return;
        }
        if (listSatuan.includes($satuanBaru.val())) {
            swal("Satuan sudah ada", "", "warning");
            return;
        }
        listSatuan.push($satuanBaru.val());
        $satuanBaru.val('');
        updateTable();
    }


    function clickDelete(index) {
        listSatuan.splice(index, 1);
        updateTable();
    }

    // Function to generate JSON object from the input values
    function generateJSON() {
        const json = [];
        $('input[type="number"]').each(function() {
            const key = $(this).attr('name');
            const value = $(this).val();
            const [field, id] = key.split(/\[|\]\[|\]/).filter(Boolean);
            json.push({
                unit: id,
                name: field,
                value: value
            });
        });
        return json;
    }
</script>

</html>