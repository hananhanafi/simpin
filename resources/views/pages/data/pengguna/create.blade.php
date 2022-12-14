@extends('layouts.master')

@section('title')
    Tambah Profil Pengguna
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Tambah Profil Pengguna</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Tambah</a></li>
                    <li class="breadcrumb-item active">Profil</li>
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
                        <h4 class="card-title">Form Tambah Data Pengguna</h4>
                        <p class="card-title-desc">Data berasal dari Sumber yang tersimpan dalam database</code>.</p>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('data.pengguna.index') }}" class="btn btn-info btn-sm" style="float: right"><i class="fa fa-chevron-left"></i> Kembali</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @include('includes.alert')
                <form action="{{ route('data.pengguna.store') }}" method="POST" id="form-tambah">
                    <div class="row">
                        <div class="pb-3 col-md-6">
                            @csrf
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">NIK<small class="text-danger">*</small></label>
                                <div class="col-sm-9">
                                    <input type="text" name="nik" class="form-control" id="nik" placeholder="NIK" required data-parsley-required-message="Nomor NIK Harus Diisi" value="{{ old('nik') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Nama<small class="text-danger">*</small></label>
                                <div class="col-sm-9">
                                    <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama" required data-parsley-required-message="Nama Harus Diisi" value="{{ old('nama') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Keterangan</label>
                                <div class="col-sm-9">
                                    <input type="text" name="keterangan" class="form-control" id="keterangan" placeholder="Keterangan"  value="{{ old('keterangan') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="text" name="email" class="form-control" id="email" placeholder="Email"  value="{{ old('email') }}">
                                </div>
                            </div>
                           
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Nomor Telepon</label>
                                <div class="col-sm-9">
                                    <input type="text" name="telepon" class="form-control" id="telepon" placeholder="Nomor Telepon"  value="{{ old('telepon') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Username</label>
                                <div class="col-sm-9">
                                    <input type="text" name="username" class="form-control" id="username" placeholder="Nama Pengguna"  value="{{ old('username') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Password</label>
                                <div class="col-sm-9">
                                    <input type="text" name="password" class="form-control" id="password" placeholder="Password">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Group Akses</label>
                                <div class="col-sm-9">
                                    <select class="form-control" style="width: 100%;" name="group_akses">
                                        <option value="">-Pilih Produk-</option>
                                        <option value="1">Admin</option>
                                        <option value="2">Operator</option>
                                        <option value="3">Pengurus Yayasan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Status</label>
                                <div class="col-sm-9">
                                    <select class="form-control" style="width: 100%;" name="status_akses">
                                        <option value="">-Pilih status-</option>
                                        <option value="1">Aktif</option>
                                        <option value="0">Tidak AKtif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 text-center">
                            <hr>
                            <button type="submit" class="btn btn-primary btn-sm w-md"><i class="fa fa-save"></i> Simpan Data</button>
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
<script type="text/javascript" src="{{ asset('js') }}/currency.js"></script>
<script>
    $('#form-tambah').parsley();

</script>
<style>
    .parsley-errors-list li{
        color : red !important;
        font-style: italic;
    }
</style>
@endsection
