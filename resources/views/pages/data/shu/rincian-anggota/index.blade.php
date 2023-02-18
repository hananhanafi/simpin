@extends('layouts.master')

@section('title')
    Data Rincian Anggota
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Data Rincian Anggota</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Data</a></li>
                        <li class="breadcrumb-item active">Rincian Anggota</li>
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
                            <h4 class="card-title">List Data Rincian Anggota</h4>
                            <p class="card-title-desc">Data berasal dari Sumber yang tersimpan dalam database</code>.</p>
                        </div>
                        {{-- <div class="col-md-6">
                            <a href="{{ route('data.anggota.create') }}" class="btn btn-info btn-sm" style="float: right"><i
                                    class="fa fa-plus-circle"></i> Tambah Data</a>
                        </div> --}}
                    </div>
                </div>
                <div class="card-body">
                    @include('includes.alert')
                    <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                        <thead>
                            <tr>
                                <th rowspan="2">No</th>
                                <th rowspan="2">No Anggota</th>
                                <th rowspan="2">Nama</th>
                                <th rowspan="2">Departemen</th>
                                {{-- <th rowspan="2">Tahun</th> --}}
                                <th colspan="4" class="text-center">Pembagian SHU sesuai aktivitas </th>

                                <th rowspan="2">Total SHU</th>
                                <th rowspan="2">Status</th>
                                <th rowspan="2">Aksi</th>
                            </tr>
                            <tr>
                                <th>Simpanan</th>
                                <th>Pinjaman 30%</th>
                                <th>Pinjaman 70%</th>
                                <th>Sembako</th>
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
    <link href="{{ asset('assets') }}/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets') }}/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ asset('assets') }}/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />
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
                "url": "{{ route('datatable.rincian-anggota') }}",
                "dataType": "json",
            },
            "columns": [{
                    "data": 'DT_RowIndex'
                },
                {
                    "data": "no_anggota"
                },
                {
                    "data": "nama"
                },
                {
                    "data": "departement",
                },
                // {
                //     // "data": 2020,
                // },
                {
                    "data": "simpanan",
                },
                {
                    "data": "saldo_pinjaman",
                },
                {
                    "data": "saldo_pinjaman",
                },
                {
                    "data": "sembako",
                },
                {
                    "data": "telepon"
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
                    "targets": [0, 1, 4, 5, 6]
                },
                {
                    "searchable": false,
                    "targets": [0, 5, 6]
                },
                {
                    "orderable": false,
                    "targets": [0, 5, 6]
                }
            ],

        });

        function penutupan(id, nama, noanggota) {
            $('#id-anggota').val(id)
            $('#no-anggota').val(noanggota)
            $('#nama-anggota').val(nama)
            $('#modal-tutup').modal('show')
        }

        function hapus(uuid) {
            var url = '{{ route('data.anggota.index') }}/' + uuid;
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
    <div id="modal-tutup" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('data.anggota.penutupan') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Form Penutupan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-4">
                            <h6 class="card-title">Tanggal Penutupan</h6>
                            <input type="date" class="form-control" name="tanggal" id="tanggal">
                            <input type="hidden" class="form-control" name="id_anggota" id="id-anggota">
                        </div>
                        <div class="form-group mb-4">
                            <h6 class="card-title">Nomor Anggota</h6>
                            <input type="text" class="form-control" name="no_anggota" id="no-anggota" readonly>
                        </div>
                        <div class="form-group mb-4">
                            <h6 class="card-title">Nama Anggota</h6>
                            <input type="text" class="form-control" name="nama" id="nama-anggota" readonly>
                        </div>
                        <div class="form-group mb-4">
                            <h6 class="card-title">Alasan Penutupan</h6>
                            <input type="text" class="form-control" name="keterangan" id="keterangan"
                                placeholder="Masukan Keterangan" value="">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection
