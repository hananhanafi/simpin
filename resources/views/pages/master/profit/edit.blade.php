@extends('layouts.master')

@section('title')
    Edit Data Master Profit Center
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Master Data Profit Center</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Master</a></li>
                    <li class="breadcrumb-item active">Profit Center</li>
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
                        <h4 class="card-title">Form Edit Data Profit Center Simpanan dan Pinjaman</h4>
                        <p class="card-title-desc">Data berasal dari Sumber yang tersimpan dalam database</code>.</p>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('master.profit.index') }}" class="btn btn-info btn-sm" style="float: right"><i class="fa fa-chevron-left"></i> Kembali</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @include('includes.alert')
                <form action="{{ route('master.profit.update', $id) }}" method="POST" id="form-tambah">
                    <div class="row">
                        <div class="pb-3 col-md-12">
                            @csrf
                            @method('PUT')
                            <div class="row mb-2">
                                <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Kode Profit Center<small class="text-danger">*</small></label>
                                <div class="col-sm-4">
                                    <input type="text" name="kode" class="form-control" id="kode" placeholder="Kode Profit Center" required required data-parsley-required-message="Kode Profit Center Harus Diisi" value="{{ $profit->kode }}">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Nama Profit Center<small class="text-danger">*</small></label>
                                <div class="col-sm-4">
                                    <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama Profit Center" required required data-parsley-required-message="Nama Profit Center Harus Diisi" value="{{ $profit->nama }}">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="horizontal-firstname-input" class="col-sm-2 col-form-label">Keterangan<small class="text-danger">*</small></label>
                                <div class="col-sm-9">
                                    <textarea name="desc" class="form-control" id="desc" placeholder="Keterangan" >{{ $profit->desc }}</textarea>
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

<link href="{{ asset('js/summernote') }}/summernote.min.css" rel="stylesheet">
<script src="{{ asset('js/summernote') }}/summernote.min.js"></script>

<script>
    $('#form-tambah').parsley();
    $(document).ready(function(){
        $('#desc').summernote({
            height:'400'
        })
	});

</script>
<style>
    .parsley-errors-list li{
        color : red !important;
        font-style: italic;
    }
</style>
@endsection
