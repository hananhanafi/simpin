@extends('layouts.master')

@section('title')
    Master Produk Type
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Master Data Produk Type</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Master</a></li>
                    <li class="breadcrumb-item active">Produk Type</li>
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
                        <h4 class="card-title">List Data Produk Type Simpanan dan Pinjaman</h4>
                        <p class="card-title-desc">Data berasal dari Sumber yang tersimpan dalam database</code>.</p>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('master.produk-kategori.create') }}" class="btn btn-info btn-sm" style="float: right;margin:0 2px"><i class="fa fa-plus-circle"></i> Tambah Data</a>
                        <a href="javascript:modalImport()" class="btn btn-success btn-sm" style="float: right;margin:0 2px"><i class="fa fa-file-excel"></i> Import Xls</a>
                        <a href="{{ route('export.produk_kategori') }}" class="btn btn-info btn-sm" style="float: right;margin:0 2px"><i class="fa fa-download"></i> Download Xls</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @include('includes.alert')
                <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama Produk</th>
                            <th>Tipe Produk</th>
                            <th>Aksi</th>
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
        td{
            font-size:11px !important;
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
            "ajax":{
                    "url": "{{ route('datatable.produk-kategori') }}",
                    "dataType": "json",
                },
            "columns": [
                { "data": 'DT_RowIndex' },
                { "data": "kode" },
                { "data": "nama" },
                { "data": "tipe_produk" },
                { "data": "aksi" },
            ],
            "columnDefs": [
                { "className": 'text-center', "targets": [0,1,3,4] },
            ]
        });


        function hapus(uuid){
            var url = '{{ route("master.produk-kategori.index") }}/' + uuid;
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
            function (isConfirm) {
                if (isConfirm) {
                    $('#delete-form').submit();
                }
            });
        }

        function modalImport(){
            $('#modal-import').modal('show')
        }

    </script>
@endsection

@section('modal')
<div id="modal-import" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('master.produk-kategori.importXlsProses') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Import File Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-4">
                        <h6 class="card-title">Unduh Contoh File</h6>
                        <a href="{{ asset('file/contoh-product-type.xls') }}" class="text-success"><i class="fa fa-download"></i> Unduh</a>
                    </div>

                    <div class="form-group mb-4">
                        <h6 class="card-title">Upload File</h6>
                        <input type="file" class="form-control" name="file" id="file" placeholder="Silahkan Pilih File" accept=".xls">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Import</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection
