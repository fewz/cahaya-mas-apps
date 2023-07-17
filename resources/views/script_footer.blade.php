<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>

<!-- Select2 -->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script src="{{URL::asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>
<script>
    $(function() {

        $("#example1").DataTable();

        //Initialize Select2 Elements
        $('.select2').select2();

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

    });
</script>