<script src="{{ asset('assets') }}/libs/jquery/jquery.min.js"></script>
<script src="{{ asset('assets') }}/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets') }}/libs/metismenu/metisMenu.min.js"></script>
<script src="{{ asset('assets') }}/libs/simplebar/simplebar.min.js"></script>
<script src="{{ asset('assets') }}/libs/node-waves/waves.min.js"></script>
<script src="{{ asset('assets') }}/libs/feather-icons/feather.min.js"></script>
<!-- pace js -->
<script src="{{ asset('assets') }}/libs/pace-js/pace.min.js"></script>
<script src="{{ asset('assets') }}/js/app.js"></script>

<script>
    $.ajaxSetup({
      headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>