@extends('layouts.master')

@section('title')
Data Pencairan Pinjaman
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Data Pencairan Pinjaman</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Data</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Pinjaman</a></li>
                    <li class="breadcrumb-item active">Pencairan</li>
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
                        <h4 class="card-title">List Data Pencairan Pinjaman</h4>
                    </div>

                    <div class="col-md-6">
                        <a href="{{ route('data.pinjaman.addPencairan') }}" class="btn btn-info btn-sm" style="float: right"><i class="fa fa-plus-circle"></i> Tambah Data</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @include('includes.alert')
                <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">No Rekening</th>
                            <th class="text-center">No Anggota</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Jumlah Pinjaman</th>
                            <th class="text-center">Masa</th>
                            <th class="text-center">Admin</th>
                            <th class="text-center">Asuransi</th>
                            <th class="text-center">Pelunasan Pinjaman</th>
                            <th class="text-center">Diterima</th>
                            <th class="text-center">Tanggal Pencairan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<form id="aproval-form" method="post">
    @csrf
    <input type="hidden" name="id_pinjaman" id="id_pinjaman">
</form>
@endsection

@section('css')
<!-- DataTables -->
<link href="{{ asset('assets') }}/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets') }}/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

<!-- Responsive datatable examples -->
<link href="{{ asset('assets') }}/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets') }}/sweetalert/sweetalert.css">

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
<script type="text/javascript" src="{{ asset('js') }}/parsley.min.js"></script>
<script>
    var dt = $('#datatable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "{{ route('datatable.pencairan') }}",
            "dataType": "json",
        },
        "columns": [{
                "data": 'DT_RowIndex'
            },
            {
                "data": "no_rekening"
            },
            {
                "data": "no_anggota"
            },
            {
                "data": "nama",
                name: 'anggota.nama',
            },
            {
                "data": "jml_pinjaman"
            },
            {
                "data": "masa"
            },
            // {
            //     "data": "telepon",
            //     'name': 'anggota.telepon',
            // },
            {
                "data": "admin"
            },
            {
                "data": "asuransi"
            },
            {
                "data": "nilai_pelunasan"
            },
            {
                "data": "nilai_pencairan"
            },
            {
                "data": "pencairan_date"
            },
            {
                "data": "aksi"
            },
        ],
        "columnDefs": [{
                "className": 'text-center',
                "targets": [0, 1, 3, 4, 5]
            },
            {
                "searchable": false,
                "targets": [0, 4]
            },
            {
                "orderable": false,
                "targets": [0, 4]
            }
        ],
    });


    function hapus(uuid) {
        var url = "{{ route('data.pinjaman.index') }}/" + uuid;
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