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
                                    <label>Code Inventory</label>
                                    <input type="text" class="form-control required" name="code" placeholder="Code">
                                </div>
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
                                <div class="form-group">
                                    <label>Allowed Units</label>
                                    <select class="duallistbox" multiple="multiple" name="units[]" id="unit">
                                        @foreach ($list_units as $dt )
                                        <option value="{{$dt->id}}">{{$dt->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <label>Pricing by Tier</label>
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Id Unit</th>
                                            <th>Unit</th>
                                            <th>General</th>
                                            <th>Bronze</th>
                                            <th>Silver</th>
                                            <th>Gold</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableBody">
                                    </tbody>
                                </table>
                                <input id="pricing" type="hidden" name="pricing" />
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
        const jsonData = generateJSON();
        console.log(jsonData);
        $("#pricing").val(JSON.stringify(jsonData));

        $('#formadd').submit();
    }

    // Function to generate JSON object from the input values
    function generateJSON() {
        const json = [];
        $('input[type="number"]').each(function() {
            const key = $(this).attr('name');
            const value = $(this).val();
            const [field, id] = key.split(/\[|\]\[|\]/).filter(Boolean);
            json.push({
                id: id,
                name: field,
                value: value
            });
        });
        return json;
    }
    const dataUnit = <?php echo json_encode($list_units) ?>;
    $(document).ready(function() {
        console.log('dataUnit', dataUnit);

        // Event listener for changes in the multi-select
        $('#unit').on('change', updateDataTable);
        // Store input values separately
        const inputValues = {};

        // Function to update the data table based on multi-select changes
        function updateDataTable() {
            const selectedItems = $('#unit').val(); // Get an array of selected values

            // Store the current input values before updating
            saveInputValues();

            // Clear the table body
            $('#tableBody').empty();

            // Populate the table with selected items and their stored values
            selectedItems.forEach(item => {
                const unit = dataUnit.find(unit => unit.id === parseInt(item)); // Find the corresponding unit object
                if (unit) {
                    const row = `<tr>
                            <td>${item}</td>
                            <td>${unit.name}</td>
                            <td><input type="number" class="form-control" name="general[${item}]" min="0" value="${getInputValue(item, 'general')}"></td>
                            <td><input type="number" class="form-control" name="bronze[${item}]" min="0" value="${getInputValue(item, 'bronze')}"></td>
                            <td><input type="number" class="form-control" name="silver[${item}]" min="0" value="${getInputValue(item, 'silver')}"></td>
                            <td><input type="number" class="form-control" name="gold[${item}]" min="0" value="${getInputValue(item, 'gold')}"></td>
                        </tr>`;
                    $('#tableBody').append(row);
                }
            });
        }

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
    });
</script>

</html>