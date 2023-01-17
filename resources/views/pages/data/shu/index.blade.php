@extends('layouts.master')

@section('title')
Data SHU
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Data SHU</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Data</a></li>
                    <li class="breadcrumb-item active">SHU</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row">

                    <div class="col-md-6">
                        <h4 class="card-title">List Data SHU</h4>
                        <p class="card-title-desc">Data berasal dari Sumber yang tersimpan dalam database</code>.</p>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('data.shu.create') }}" class="btn btn-info btn-sm" style="float: right"><i class="fa fa-plus-circle"></i> Tambah Data</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @include('includes.alert')
                <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                    <thead>
                        <tr>
                            <th class="text-center" rowspan="2">No</th>
                            <th class="text-center" rowspan="2">Tahun</th>
                            <th class="text-center" rowspan="2">Alokasi SHU</th>
                            <th class="text-center" colspan="2">SHU</th>
                            <th class="text-center" rowspan="2">Status</th>
                            <th class="text-center" rowspan="2">Aksi</th>
                        </tr>
                        <tr>
                            <th class="text-center">Pengurus dan Pengelola<br>(20 %)</th>
                            <th class="text-center">Anggota<br>(80 %)</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<form id="delete-form" method="post">
    @csrf
    @method('DELETE')
</form>
@endsection

@section('css')
<!-- DataTables -->
<link href="{{ asset('assets') }}/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets') }}/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

<!-- Responsive datatable examples -->
<link href="{{ asset('assets') }}/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{asset('assets')}}/sweetalert/sweetalert.css">

<style>
    td {
        font-size: 11px !important;
    }

    .text-right {
        text-align: right !important;
    }
</style>
@endsection

@section('footscript')
<!-- Required datatable js -->
<script src="{{ asset('assets') }}/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets') }}/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<!-- Buttons examples -->
<script src="{{ asset('assets') }}/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('assets') }}/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
<script src="{{ asset('assets') }}/libs/jszip/jszip.min.js"></script>
<script src="{{ asset('assets') }}/libs/pdfmake/build/pdfmake.min.js"></script>
<script src="{{ asset('assets') }}/libs/pdfmake/build/vfs_fonts.js"></script>
<script src="{{ asset('assets') }}/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="{{ asset('assets') }}/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="{{ asset('assets') }}/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>

<!-- Responsive examples -->
<script src="{{ asset('assets') }}/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('assets') }}/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script type="text/javascript" charset="utf8" src="{{ asset('assets') }}/sweetalert/sweetalert.min.js"></script>

<script>
    var dt = $('#datatable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "{{ route('datatable.shu') }}",
            "dataType": "json",
        },
        "columns": [{
                "data": 'DT_RowIndex'
            },
            {
                "data": "tahun"
            },
            {
                "data": "alokasi_shu"
            },
            {
                "data": "pengurus"
            },
            {
                "data": "anggota"
            },
            {
                "data": "status"
            },
            {
                "data": "aksi"
            },
        ],
        "columnDefs": [{
                "className": 'text-center',
                "targets": [0, 1, 5, 2, 3, 4]
            },
            {
                "searchable": false,
                "targets": [0, 1, 2, 3, 4, 5, 6]
            },
            {
                "orderable": false,
                "targets": [0, 1, 2, 3, 4, 5, 6]
            }
        ],

    });


    function hapus(uuid) {
        var url = '{{ route("data.shu.index") }}/' + uuid;
        $('#delete-form').attr('action', url);

        swal({
                title: "Apakah Anda Yakin !",
                text: "Ingin Menghapus Data Ini ?.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ya, Hapus",
                cancelButtonText: "Cancel",
                closeOnConfirm: false,
                closeOnCancel: true
            },
            function(isConfirm) {
                if (isConfirm) {
                    $('#delete-form').submit();
                }
            });
    }
</script>
@endsection

@section('modal')

@endsection