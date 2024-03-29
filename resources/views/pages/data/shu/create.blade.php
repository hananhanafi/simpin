@extends('layouts.master')

@section('title')
Tambah Data SHU
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Tambah Data SHU</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Data</a></li>
                    <li class="breadcrumb-item">SHU</li>
                    <li class="breadcrumb-item active">Tambah</li>
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
                        <h4 class="card-title">Form Tambah Data SHU</h4>
                        <p class="card-title-desc">Form untuk menambah data SHU</code>.</p>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('data.shu.index') }}" class="btn btn-info btn-sm" style="float: right"><i class="fa fa-chevron-left"></i> Kembali</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @include('includes.alert')
                <form action="{{ route('data.shu.store') }}" method="POST" id="form-tambah">
                    <div class="row">
                        <div class="pb-3 col-md-6">
                            @csrf
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Tahun<small class="text-danger">*</small></label>
                                <div class="col-sm-7">
                                    <select class="form-control select2" style="width: 100%;" name="tahun" id="tahun">
                                        @php
                                        for ($i=1;$i<=10;$i++) { $it=date("Y") - 10 + $i; echo "<option value=\"".$it."\""; if ($it==$thn) { echo " selected" ; } echo ">" .$it."</option>";
                                            }
                                            @endphp
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Alokasi SHU<small class="text-danger">*</small></label>
                                <div class="col-sm-7">
                                    <input type="text" name="alokasi_shu" class="form-control" id="alokasi_shu" placeholder="Jumlah Alokasi SHU" required data-parsley-required-message="Jumlah Alokasi SHU Harus Diisi" value="{{ old('alokasi_shu') }}" onkeyup="pageSimulasi()">
                                </div>
                            </div>
                        </div>
                        <div class="pb-3 col-md-12">
                            <hr>
                            <div id="pages-simulasi"></div>
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <button type="submit" class="btn btn-primary btn-sm w-md"><i class="fa fa-save"></i> Simpan Data</button>
                        </div>
                    </div>
                </form>
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
        var alokasi_shu = parseInt($('#alokasi_shu').val().replaceAll('.',''));
        var tahun = $('#tahun').val();
        var shu_anggota_persen = $('input[name=shu_anggota_persen]').val() === undefined ? 80 : $('input[name=shu_anggota_persen]').val()
        var pengurus_persen = $('#pengurus_persen').val() === undefined ? 4 : $('#pengurus_persen').val()
        var pengawas_persen = $('#pengawas_persen').val() === undefined ? 1 : $('#pengawas_persen').val()
        var karyawan_persen = $('#karyawan_persen').val() === undefined ? 8 : $('#karyawan_persen').val()
        var pendidikan_persen = $('#pendidikan_persen').val() === undefined ? 7 : $('#pendidikan_persen').val()
        var shu_pengurus_persen = $('input[name=shu_pengurus_persen]').val() === undefined ? 20 : $('input[name=shu_pengurus_persen]').val()
        $('#pages-simulasi').load('{{ route("ajax.shu.simulasi") }}?tahun=' + tahun + '&alokasi_shu=' + alokasi_shu + '&shu_anggota_persen=' + shu_anggota_persen + '&pengurus_persen=' + pengurus_persen + '&pengawas_persen=' + pengawas_persen + '&karyawan_persen=' + karyawan_persen + '&pendidikan_persen=' + pendidikan_persen + '&shu_pengurus_persen=' + shu_pengurus_persen);

    }
</script>
@endsection

@section('modal')

@endsection