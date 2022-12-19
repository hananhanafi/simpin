@extends('layouts.master')

@section('title')
impor
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Form Data Potongan HRD</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Data</a></li>
                    <li class="breadcrumb-item">Potongan HRD</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @include('includes.alert')
                <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">KODE PC</th>
                            <th class="text-center">KDPEG</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Total Potongan</th>
                            <th class="text-center">Potongan Pokok</th>
                            <th class="text-center">Potongan Wajib</th>
                            <th class="text-center">Potongan Simpas</th>
                            <th class="text-center">Potongan Koperasi</th>
                            <th class="text-center">Potongan DKM</th>
                            <th class="text-center">Sisa Potongan</th>
                        </tr>
                    </thead>
                </table>
            </div>
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
<link rel="stylesheet" href="{{ asset('packages/select2/dist/css/select2.css') }}">
<script src="{{ asset('packages/select2/dist/js/select2.js') }}"></script>
<script type="text/javascript" src="{{ asset('js') }}/parsley.min.js"></script>
<script type="text/javascript" src="{{ asset('js') }}/currency.js"></script>
<script type="text/javascript" src="{{ asset('js') }}/financial.js"></script>
<script type="text/javascript" charset="utf8" src="{{ asset('assets') }}/sweetalert/sweetalert.min.js"></script>

<script>
    $('#alokasi_shu').on({
        keyup: function() {
            let input_val = $(this).val();
            input_val = numberToCurrency(input_val);
            $(this).val(input_val);
        },
        blur: function() {
            let input_val = $(this).val();
            input_val = numberToCurrency(input_val, true, true);
            $(this).val(input_val);
        }
    });
    pageSimulasi();

    function pageSimulasi() {
        var alokasi_shu = $('#alokasi_shu').val();
        var tahun = $('#tahun').val();

        var pengurus_persen = $('#pengurus_persen').val()
        var pengawas_persen = $('#pengawas_persen').val()
        var karyawan_persen = $('#karyawan_persen').val()
        var pendidikan_persen = $('#pendidikan_persen').val()
        var shu_pengurus_persen = $('input[name=shu_pengurus_persen]').val()

        var shu_anggota_persen = $('input[name=shu_anggota_persen]').val()
        var anggota_usipa = $('#anggota_usipa').val()
        var anggota_angkutan = $('#anggota_angkutan').val()
        var anggota_s_toko = $('#anggota_s_toko').val()
        var anggota_toko = $('#anggota_toko').val()
        var anggota_rat_simpan = $('#anggota_rat_simpan').val()

        $('#pages-simulasi').load("{{ route('ajax.shu.simulasi') }}?tahun=" + tahun + '&alokasi_shu=' + alokasi_shu +
            '&shu_anggota_persen=' + shu_anggota_persen + '&anggota_usipa=' + anggota_usipa + '&anggota_angkutan=' +
            anggota_angkutan + '&anggota_s_toko=' + anggota_s_toko + '&anggota_toko=' + anggota_toko +
            '&anggota_rat_simpan=' + anggota_rat_simpan +
            // pengurus
            '&shu_pengurus_persen=' + shu_pengurus_persen +
            '&pengurus_persen=' + pengurus_persen + '&pengawas_persen=' + pengawas_persen + '&karyawan_persen=' +
            karyawan_persen + '&pendidikan_persen=' + pendidikan_persen);
    }
</script>
@endsection