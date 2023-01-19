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
                <div class="row">
                    <div class="col-md-6">
                        @csrf
                        <div class="row mb-3">
                            <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Tahun</label>
                            <div class="col-sm-7">
                                <b>{{ $shu->tahun }}</b>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Alokasi SHU</label>
                            <div class="col-sm-7">
                                <b>Rp. {{ number_format($shu->alokasi_shu,2,',','.') }}</b>
                            </div>
                        </div>
                    </div>
                    <div class="ol-md-12">
                        <table class="table table-bordered simulasi mt-5">
                            <thead>
                                <tr>
                                    <th style="text-align:center">
                                        Kategori
                                    </th>
                                    <th style="text-align:center;width:120px">
                                        %
                                    </th>
                                    <th style="text-align:center">
                                        Nominal
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $shu_anggota_persen = $shu->persen_anggota;
                                $shu_pengurus_persen = $shu->persen_pengurus;

                                $shu_anggota = $shu->shu_anggota;
                                $shu_pengurus = $shu->shu_pengurus;
                                @endphp
                                <tr style="background: #ccfff4 !important">
                                    <th style="background: #ccfff4 !important">SHU Bagian Anggota</th>
                                    <th class="text-center" style="background: #ccfff4 !important">
                                        {{ number_format($shu_anggota_persen,2) }}
                                    </th>
                                    <th class="text-center" style="background: #ccfff4 !important">
                                        <b>Rp. {{ number_format($shu_anggota,2,',','.') }}</b>
                                    </th>
                                </tr>
                                @foreach ($shu->detail as $item)
                                <tr>
                                    <td>{{ ucwords($item->keterangan) }}</td>
                                    <td class="text-center">
                                        {{ ($item->persen) }}
                                    </td>
                                    <td class="text-center">
                                        <b>Rp. {{ number_format($item->nilai_shu,2,',','.') }}</b>
                                    </td>
                                </tr>
                                @endforeach
                                <tr style="background: #ccfff4 !important">
                                    <th style="background: #ccfff4 !important">SHU Bagian Pengurus</th>
                                    <th class="text-center" style="background: #ccfff4 !important">
                                        {{ ($shu_pengurus_persen) }}
                                    </th>
                                    <th class="text-center" style="background: #ccfff4 !important">
                                        <b>Rp. {{ number_format($shu_pengurus,2,',','.') }}</b>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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

<script>

</script>
@endsection

@section('modal')

@endsection