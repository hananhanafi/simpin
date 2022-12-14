@extends('layouts.master')

@section('title')
Cetak Sertifikat Simpanan
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Sertifikat Simpanan</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Data</a></li>
                    <li class="breadcrumb-item active">Simpanan</li>
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
                        <h4 class="card-title">Cetak Data Sertifikat</h4>
                        <p class="card-title-desc">Data berasal dari Sumber yang tersimpan dalam database</code>.</p>
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
                            <th class="text-center">Jenis Simpanan</th>
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
            "url": "{{ route('datatable.simpanan.sertif') }}",
            "dataType": "json",
        },
        "columns": [{
                "data": 'DT_RowIndex',
                name: 't_simpanan.id',
                orderable: 'true',
                searchable: 'false',
            },
            {
                "data": "no_rekening"
            },
            {
                "data": "no_anggota",
            },
            {
                "data": "nama",
                'name': 'anggota.nama'
            },
            {
                "data": "jenis_simpanan",
                'name': 'produk.nama_produk',
            },
            {
                "data": "saldo_akhir"
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
                "targets": [0, 1, 2, 4, 5, 6, 7]
            },
            {
                "searchable": false,
                "targets": [0]
            },
            {
                "orderable": false,
                "targets": [0, 4, 7, 6]
            }
        ],

    });
</script>
@endsection

@section('modal')
<div id="modal-tutup" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('data.simpanan.penutupan') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Form Penutupan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-2">
                        <h6 class="card-title">Tanggal Penutupan</h6>
                        <input type="date" class="form-control" name="tanggal" id="tanggal" value="{{ date('Y-m-d') }}">
                        {{-- <input type="text" class="form-control" name="id_simpanan" id="id-simpanan" > --}}
                    </div>
                    <div class="form-group mb-2">
                        <h6 class="card-title">Nomor Rekening</h6>
                        <input type="text" class="form-control" name="no_rekening" id="no-rekening" readonly>
                    </div>
                    <div class="form-group mb-2">
                        <h6 class="card-title">Nomor Anggota</h6>
                        <input type="text" class="form-control" name="no_anggota" id="no-anggota" readonly>
                    </div>
                    <div class="form-group mb-2">
                        <h6 class="card-title">Nama Anggota</h6>
                        <input type="text" class="form-control" name="nama" id="nama-anggota" readonly>
                    </div>
                    <div class="form-group mb-2">
                        <h6 class="card-title">Jenis Simpanan</h6>
                        <input type="text" class="form-control" name="jenis_simpanan" id="jenis_simpanan" readonly>
                    </div>
                    <div class="form-group mb-2">
                        <h6 class="card-title">Tanggal Pembukaan</h6>
                        <input type="text" class="form-control" name="tgl_pembukaan" id="tgl_pembukaan" readonly>
                    </div>
                    <div class="form-group mb-2">
                        <h6 class="card-title">Saldo</h6>
                        <input type="text" class="form-control" name="saldo" id="saldo" readonly>
                    </div>
                    <div class="form-group mb-2">
                        <h6 class="card-title">Pinalti</h6>
                        <input type="text" class="form-control" name="pinalti" id="pinalti">
                    </div>
                    <div class="form-group mb-2">
                        <h6 class="card-title">PPH</h6>
                        <input type="text" class="form-control" name="pph" id="pph">
                    </div>
                    <div class="form-group mb-2">
                        <h6 class="card-title">Alasan Penutupan</h6>
                        <input type="text" class="form-control" name="keterangan" id="keterangan" required placeholder="Masukan Keterangan" value="">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection