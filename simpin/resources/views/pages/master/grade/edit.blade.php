@extends('layouts.master')

@section('title')
    Edit Data Master Grade Anggota
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Master Data Grade Anggota</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Master</a></li>
                    <li class="breadcrumb-item active">Grade Anggota</li>
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
                        <h4 class="card-title">Form Edit Data Grade Anggota</h4>
                        <p class="card-title-desc">Data berasal dari Sumber yang tersimpan dalam database</code>.</p>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('master.grade.index') }}" class="btn btn-info btn-sm" style="float: right"><i class="fa fa-chevron-left"></i> Kembali</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @include('includes.alert')
                <form action="{{ route('master.grade.update', $id) }}" method="POST" id="form-tambah">
                    <div class="row">
                        <div class="pb-3 col-md-6">
                            @csrf
                            @method('PUT')
                            <div class="row mb-2">
                                <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Kode Grade<small class="text-danger">*</small></label>
                                <div class="col-sm-9">
                                    <input type="text" name="kode" class="form-control" id="kode" placeholder="Kode Grade Anggota" required required data-parsley-required-message="Kode Grade Harus Diisi" value="{{ $grade->kode }}">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Nama Grade<small class="text-danger">*</small></label>
                                <div class="col-sm-9">
                                    <input type="text" name="grade_name" class="form-control" id="grade_name" placeholder="Nama Grade Anggota" required required data-parsley-required-message="Nama Grade Harus Diisi" value="{{ $grade->grade_name }}">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Simpanan Pokok<small class="text-danger">*</small></label>
                                <div class="col-sm-9">
                                    <input type="number" name="simp_pokok" class="form-control" id="simp_pokok" placeholder="Simpanan Pokok" required required data-parsley-required-message="Simpanan Pokok Harus Diisi" value="{{ $grade->simp_pokok }}">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Simpanan Wajib<small class="text-danger">*</small></label>
                                <div class="col-sm-9">
                                    <input type="number" name="simp_wajib" class="form-control" id="simp_wajib" placeholder="Simpanan Wajib" required required data-parsley-required-message="Simpanan Wajib Harus Diisi" value="{{ $grade->simp_wajib }}">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Simpanan Wajib</label>
                                <div class="col-sm-9">
                                    <input type="number" name="simp_sukarela" class="form-control" id="simp_sukarela" placeholder="Simpanan Sukarela"  value="{{ $grade->simp_sukarela }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    <button type="submit" class="btn btn-primary btn-sm w-md"><i class="fa fa-save"></i> Simpan Data</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footscript')
<link rel="stylesheet" href="{{ asset('packages/select2/dist/css/select2.css') }}">
<script src="{{ asset('packages/select2/dist/js/select2.js') }}"></script>
<script type="text/javascript" src="{{ asset('js') }}/parsley.min.js"></script>
<script>
    $('#form-tambah').parsley();
    $(document).ready(function(){
	});

</script>
<style>
    .parsley-errors-list li{
        color : red !important;
        font-style: italic;
    }
</style>
@endsection
