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
                                / Stok
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
                            <h3 class="card-title">Inventory</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="formadd" action="{{URL('admin/master_inventory/do_edit').'/'.$data_inventory->id}}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Code Inventory</label>
                                    <input disabled type="text" class="form-control required" name="code" placeholder="Code" value="{{$data_inventory->code}}">
                                </div>
                                <div class="form-group">
                                    <label>Name</label>
                                    <input disabled type="text" class="form-control required" name="name" placeholder="Name" value="{{$data_inventory->name}}">
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
                            <h3 class="card-title">Stok</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Unit</th>
                                        <th>Stok</th>
                                        <th>Per satuan terkecil</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                    @foreach ($list_unit as $unit )
                                    <tr>
                                        <td>{{$unit->name}}</td>
                                        <td>{{$unit->stok}}</td>
                                        <td>{{$unit->qty_reference}}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary" onclick="openModalEdit('{{$unit->id}}', '{{$unit->name}}', '{{$unit->stok}}')">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</body>
<div id="modalEdit" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update Stok</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formedit" action="{{URL('admin/master_inventory/edit_stok')}}" method="POST">
                    @csrf
            <div class="modal-body">
                    <div class="form-group">
                        <label>Unit</label>
                        <input disabled type="text" class="form-control required" id="edit-name">
                    </div>
                    <div class="form-group">
                        <label>Stok</label>
                        <input type="number" class="form-control required" id="edit-stok" name="stok">
                    </div>
                    <input type="hidden" class="form-control required" id="edit-id" name="id">
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" value="Save changes"/>
            </div>
                </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@include('script_footer')
<script>
    const $satuanBaru = $("#satuanBaru");

    let listSatuan = <?php echo $list_unit; ?>;
    let listUnit = {};

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

    function openModalEdit(id, name, stok) {
        $("#edit-name").val(name);
        $("#edit-stok").val(stok);
        $("#edit-id").val(id);
        $("#modalEdit").modal();
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