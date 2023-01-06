@extends('layouts.master')

@section('title')
Data Aktivasi Pinjaman
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Data Aktivasi Pinjaman</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Data</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Approval</a></li>
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
                        <h4 class="card-title">List Data Aktivasi Pinjaman</h4>
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
                            <th class="text-center">Jenis Pinjaman</th>
                            <th class="text-center">Jumlah Pinjaman</th>
                            <th class="text-center">Status</th>
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
    <input type="hidden" name="id_pinjaman">
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
            "url": "{{ route('datatable.pinjaman') }}",
            "dataType": "json",
            "data": {
                'approval': true
            }
        },
        "columns": [{
                "data": 'DT_RowIndex'
            },
            {
                "data": "no_rekening"
            },
            {
                "data": "no_anggota",
            },
            {
                "data": "nama",
                name: 'anggota.nama'
            },
            {
                "data": "nama_produk"
            },
            {
                "data": "jml_pinjaman"
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
                "targets": [0, 4, 7, 6]
            },
            {
                "orderable": false,
                "targets": [0, 4, 7, 6]
            }
        ],
    });

    function approve(uuid) {
        var url = "{{ route('approval.pinjaman.approve') }}";
        $('#aproval-form').attr('action', url);
        // $('#id_pinjaman').val(uuid)
        $("input[name='id_pinjaman']").val(uuid);
        $('#aproval-form').submit();
        // swal({
        //         title: "Apakah Anda Yakin !",
        //         text: "Ingin Menolak Data Ini ?.",
        //         type: "warning",
        //         showCancelButton: true,
        //         confirmButtonColor: "#802d34",
        //         confirmButtonText: "Ya, Tolak",
        //         cancelButtonText: "Cancel",
        //         closeOnConfirm: false,
        //         closeOnCancel: true
        //     },
        //     function(isConfirm) {
        //         if (isConfirm) {
        //             $('#aproval-form').submit();
        //         }
        //     });
    }

    function tolak(id) {
        $("input[name='id_pinjaman']").val(id);
        $('#modal-reject').modal('show')
    }

    function penutupan(id, nama, noanggota) {
        $('#id-anggota').val(id)
        $('#no-anggota').val(noanggota)
        $('#nama-anggota').val(nama)
        $('#modal-tutup').modal('show')
    }
    $(document).ready(function() {
        $('#post-approve').parsley()
    })
</script>
@endsection

@section('modal')
<div id="modal-reject" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('approval.pinjaman.approve') }}" method="POST" id="post-approve">
                @csrf
                <input type="hidden" name="id_pinjaman">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Form Approval Pinjaman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-4">
                        <h6 class="card-title">Alasan Ditolak</h6>
                        <textarea class="form-control" name="keterangan" id="keterangan" required placeholder="Masukan Keterangan"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection