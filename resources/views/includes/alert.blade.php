@if (Session::has('success'))

    <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show" role="alert">
        <i class="mdi mdi-check-all label-icon"></i><strong>Success</strong> - {!! Session::get('success') !!}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (Session::has('fail'))
<div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade show" role="alert">
    <i class="mdi mdi-block-helper label-icon"></i><strong>Error</strong> - {!! Session::get('fail') !!}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
