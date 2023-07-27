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
        initializeOnchangeForm();
    });

    //validate field with class required
    function initializeOnchangeForm() {
        const $field = $(".required");
        $field.each((_, element) => {

            if (element.tagName === 'INPUT') {
                element.addEventListener('change', (evt) => {
                    const el = evt.target;

                    if (el.value) {
                        el.classList.remove('is-invalid');
                    }
                });
            } else if (element.tagName === 'SELECT') {
                $(element).on('change', (evt) => {
                    const el = evt.target;
                    if (el.value) {
                        const $sibling = $(el).siblings();
                        $sibling.find('.select2-selection').removeClass('is-invalid');
                    }

                })

            }
        });
    }

    function validateForm() {
        // validate form
        const $field = $(".required");
        let isValid = true;

        $field.each((_, element) => {
            if (element.value == undefined || element.value == '' || !element.value) {
                // console.log('elem', element);

                if (element.tagName === 'INPUT') {
                    // validate input
                    element.classList.add('is-invalid');
                    if (isValid) {
                        isValid = false;
                        element.scrollIntoView({
                            block: 'center'
                        });
                    }
                } else if (element.tagName === 'SELECT') {
                    // validate select
                    const $sibling = $(element).siblings();
                    $sibling.find('.select2-selection').addClass('is-invalid');
                    // console.log('ss', $sibling);
                    if (isValid) {
                        isValid = false;
                        element.scrollIntoView({
                            block: 'center'
                        });
                    }


                }
            }
        });
        return isValid;
    }
</script>