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
                            <h3 class="card-title">Edit Inventory</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="formadd" action="{{URL('admin/master_inventory/do_edit').'/'.$data_inventory->id}}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Code Inventory</label>
                                    <input type="text" class="form-control required" name="code" placeholder="Code" value="{{$data_inventory->code}}">
                                </div>
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control required" name="name" placeholder="Name" value="{{$data_inventory->name}}">
                                </div>
                                <div class="form-group">
                                    <label>Category</label>
                                    <select class="form-control select2bs4" name="id_category" style="width: 100%;">
                                        @foreach ($list_category as $dt )
                                        @if ($dt->id === $data_inventory->id_category)
                                        <option value="{{$dt->id}}" selected>{{$dt->name}}</option>
                                        @else
                                        <option value="{{$dt->id}}">{{$dt->name}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <input id="pricing" type="hidden" name="pricing" />
                            <input id="units" type="hidden" name="units" />
                            <input id="list_units" type="hidden" name="list_units" />
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
                                <input type="text" id="satuanterkecil" class="form-control required" placeholder="Satuan Terkecil" value="{{$list_unit[0]->name}}" onchange="satuanTerkecilChange()">
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tambah Satuan Baru</label>
                                <input id="satuanBaru" type="text" class="form-control" placeholder="Satuan Baru">
                                <button class="btn btn-primary mt-3" onclick="tambahSatuan()">Tambah</button>
                            </div>
                            <label>Pricing by Tier</label>
                            <table id="example1" class="table table-bordered table-striped">
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

    let listSatuan = <?php echo $list_unit; ?>;
    let listUnit = {};


    $(function() {
        listSatuan.forEach((val) => {
            console.log('val', val);
            if (!listUnit[val.name]) {
                listUnit[val.name] = {};
            }
            if (!listUnit[val.name][val.tier_customer]) {
                listUnit[val.name][val.tier_customer] = {};
            }
            listUnit[val.name][val.tier_customer]['sell_price'] = val.sell_price;
            listUnit[val.name]['id'] = val.id_unit;
            listUnit[val.name][val.tier_customer]['id'] = val.id;
            if (val.qty_reference !== null) {
                listUnit[val.name]['qty_reference'] = val.qty_reference;
            }
        });

        console.log('tes', listUnit);


        listSatuan = [];

        // Clear the table body
        $('#tableBody').empty();
        let i = 0;
        for (var key in listUnit) {
            // skip loop if the property is from prototype
            if (!listUnit.hasOwnProperty(key)) continue;

            var obj = listUnit[key];


            const row = `<tr>
                            <td>
                                ${key}
                                <input type="number" class="form-control d-none" name="id[${key}]" value="${obj?.id}">
                            </td>
                            <td>
                                <input type="number" class="form-control ${!obj?.qty_reference ? 'd-none' : ''}" name="refunit[${key}]" min="0" value="${obj?.qty_reference ? obj.qty_reference : null}">
                            </td>
                            <td>
                                <input type="number" class="form-control" name="general[${key}]" min="0" value="${obj?.general?.sell_price || 0}">
                                <input type="number" class="form-control d-none" name="id_general[${key}]" value="${obj?.general?.id}">
                            </td>
                            <td>
                                <input type="number" class="form-control" name="bronze[${key}]" min="0" value="${obj?.bronze?.sell_price || 0}">
                                <input type="number" class="form-control d-none" name="id_bronze[${key}]" value="${obj?.bronze?.id}">
                            </td>
                            <td>
                                <input type="number" class="form-control" name="silver[${key}]" min="0" value="${obj?.silver?.sell_price || 0}">
                                <input type="number" class="form-control d-none" name="id_silver[${key}]" value="${obj?.silver?.id}">
                            </td>
                            <td>
                                <input type="number" class="form-control" name="gold[${key}]" min="0" value="${obj?.gold?.sell_price || 0}">
                                <input type="number" class="form-control d-none" name="id_gold[${key}]" value="${obj?.gold?.id}">
                            </td>
                            <td>
                                <button class="btn btn-sm btn-danger" onclick="clickDelete(${i})"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>`;
            $('#tableBody').append(row);
            listSatuan.push(key);
            i++;
        }

    });

    function submit() {
        // submit form
        if (!validateForm()) {
            // validate form required
            return;
        }
        const jsonData = generateJSON();

        const groupedData = groupJSON(jsonData);
        const jsonUnit = getUnitJSON(groupedData);
        console.log('grpdjson', groupedData);
        console.log('jsonUnit', jsonUnit);



        $("#pricing").val(JSON.stringify(groupedData));
        $("#satuan_terkecil").val($("#satuanterkecil").val());
        $("#list_units").val(JSON.stringify(jsonUnit));

        $('#formadd').submit();
    }

    function getUnitJSON(data) {
        const result = [];
        Object.keys(data).forEach((key) => {
            const res = {
                id: data[key]['id']['value'],
                name: key,
                refunit: data[key]['refunit']?.value || null
            };
            result.push(res);
        });
        return result;
    }

    function groupJSON(data) {
        console.log('data', data);


        const groupedData = {};

        for (const item of data) {
            let {
                unit,
                name,
                value
            } = item;

            if (!groupedData[unit]) {
                groupedData[unit] = {};
            }

            let isId = false;
            if (name.includes('id')) {
                const temp = name.split('_');
                if (temp.length > 1) {
                    name = temp[1];
                    isId = true;
                }
            }

            if (!groupedData[unit][name]) {
                groupedData[unit][name] = {};
            }
            if (isId) {
                groupedData[unit][name]['id'] = value;
            } else {
                groupedData[unit][name]['value'] = value;
            }
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

    function satuanTerkecilChange() {
        const satuanTerkecil = $("#satuanterkecil").val();
        listSatuan[0] = satuanTerkecil;
        updateTable();
    }

    function updateTable() {
        // Store the current input values before updating
        saveInputValues();

        // Clear the table body
        $('#tableBody').empty();

        listSatuan.forEach((item, i) => {
            console.log('ite', item);

            const row = `<tr>
                            <td>
                                ${item}
                                <input type="number" class="form-control d-none" name="id[${item}]" value="${getInputValue(item, 'id')}">
                            </td>
                            <td>
                                <input type="number" class="form-control ${i === 0 ? 'd-none' : ''}" name="refunit[${item}]" min="0" value="${getInputValue(item, 'refunit')}">
                            </td>
                            <td>
                                <input type="number" class="form-control" name="general[${item}]" min="0" value="${getInputValue(item, 'general')}">
                                <input type="number" class="form-control d-none" name="id_general[${item}]" value="${getInputValue(item, 'idgeneral')}">
                            </td>
                            <td>
                                <input type="number" class="form-control" name="bronze[${item}]" min="0" value="${getInputValue(item, 'bronze')}">
                                <input type="number" class="form-control d-none" name="id_bronze[${item}]" value="${getInputValue(item, 'idbronze')}">
                            </td>
                            <td>
                                <input type="number" class="form-control" name="silver[${item}]" min="0" value="${getInputValue(item, 'silver')}">
                                <input type="number" class="form-control d-none" name="id_silver[${item}]" value="${getInputValue(item, 'idsilver')}">
                            </td>
                            <td>
                                <input type="number" class="form-control" name="gold[${item}]" min="0" value="${getInputValue(item, 'gold')}">
                                <input type="number" class="form-control d-none" name="id_gold[${item}]" value="${getInputValue(item, 'idgold')}">
                            </td>
                            <td>
                                <button class="btn btn-sm btn-danger" onclick="clickDelete(${i})"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>`;
            $('#tableBody').append(row);
        });
    }

    function tambahSatuan() {
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