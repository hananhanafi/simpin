@extends('layouts.master')

@section('title')
Data Pinjaman
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Data Pinjaman</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Data</a></li>
                    <li class="breadcrumb-item active">Pinjaman</li>
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
                        <h4 class="card-title">List Data Pinjaman</h4>
                        <p class="card-title-desc">Data berasal dari Sumber yang tersimpan dalam database</code>.</p>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('data.pinjaman.create') }}" class="btn btn-info btn-sm" style="float: right"><i class="fa fa-plus-circle"></i> Tambah Data</a>
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
                            {{-- <th class="text-center">Alamat</th>
                            <th class="text-center">Telepon</th> --}}
                            <th class="text-center">Mulai</th>
                            <th class="text-center">Akhir</th>
                            <th class="text-center">Angsuran</th>
                            <th class="text-center">Jangka Waktu</th>
                            <th class="text-center">Saldo</th>

                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
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

<script>
    var dt = $('#datatable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "{{ route('datatable.pinjaman') }}",
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
            // {
            //     "data": "alamat"
            //     // name: 'anggota.alamat',
            // },
            // {
            //     "data": "telepon",
            //     // name: 'anggota.telepon',
            // },
            {
                "data": "mulai"
            },
            {
                "data": "akhir"
            },
            {
                "data": "angsuran"
            },
            {
                "data": "jangka_waktu"
            },
            {
                "data": "saldo"
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
                "targets": [0, 1, 3, 4, 5, 6, 7, 8, 9, 10]
            },
            {
                "searchable": false,
                "targets": [0, 4, 5, 6, 7, 8, 9, 10]
            },
            {
                "orderable": false,
                "targets": [0, 4, 5, 6, 7, 8, 9, 10]
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