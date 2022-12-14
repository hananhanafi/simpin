
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">{{ $salam }}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                            <li class="breadcrumb-item active">Beranda</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-10">
                    <?php echo $obj->parsed ?>
            </div>
            <div class="col-sm-2 text-right" style="text-align: right">
                <a href="{{ url('setting') }}" title="ubah data">
                <i data-feather="edit-3" class="feather-icon"></i>
                </a>
            </div>
        </div>
    </div>
</div>
