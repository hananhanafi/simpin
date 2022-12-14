@extends('layouts.master')

@section('title')
    Edit Data Master Produk Type
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
                        <h4 class="card-title">Form Edit Data Produk Type Simpanan dan Pinjaman</h4>
                        <p class="card-title-desc">Data berasal dari Sumber yang tersimpan dalam database</code>.</p>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('master.produk-kategori.index') }}" class="btn btn-info btn-sm" style="float: right"><i class="fa fa-chevron-left"></i> Kembali</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @include('includes.alert')
                <form action="{{ route('master.produk-kategori.update', $id) }}" method="POST" id="form-tambah">
                    <div class="row">
                        <div class="pb-3 col-md-6">
                            @csrf
                            @method('PUT')
                            <div class="row mb-2">
                                <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Kode Produk Type<small class="text-danger">*</small></label>
                                <div class="col-sm-9">
                                    <input type="text" name="kode" class="form-control" id="kode" placeholder="Kode Produk Type" required required data-parsley-required-message="Kode Produk Type" value="{{ $productType->kode }}">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Nama Produk Type<small class="text-danger">*</small></label>
                                <div class="col-sm-9">
                                    <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama Produk Type" required required data-parsley-required-message="Nama Produk Type" value="{{ $productType->nama }}">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="horizontal-password-input" class="col-sm-3 col-form-label">Tipe Produk</label>
                                <div class="col-sm-9">
                                    <select class="form-control select2" style="width: 100%;" name="tipe_produk">
                                        <option value="1" {{ $productType->tipe_produk == 1 ? 'selected' : '' }}>Simpanan</option>
                                        <option value="2" {{ $productType->tipe_produk == 2 ? 'selected' : '' }}>Pinjaman</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-sm-7 text-center">
                                <button type="submit" class="btn btn-primary btn-sm w-md"><i class="fa fa-save"></i> Simpan Data</button>
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
