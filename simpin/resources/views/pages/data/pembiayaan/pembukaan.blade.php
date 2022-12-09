@extends('layouts.master')

@section('title')
Pembukaan Pinjaman
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Pembukaan Pinjaman</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Data</a></li>
                    <li class="breadcrumb-item">Pembiayaan</li>
                    <li class="breadcrumb-item active">Pembukaan</li>
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
                        <h4 class="card-title">Pembukaan Pinjaman</h4>
                        <p class="card-title-desc">Form Pembukaan Pinjaman.</code>.</p>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('data.pinjaman.index') }}" class="btn btn-info btn-sm" style="float: right"><i class="fa fa-chevron-left"></i> Kembali</a>
                    </div>
                    <div class="card-body">
                        @include('includes.alert')
                        <form action="{{ route('data.simpanan.store') }}" method="POST" id="form-tambah">
                            <div class="row">
                                <div class="pb-3 col-md-5">
                                    @csrf
                                    <div class="row mb-3">
                                        <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">No Anggota<small class="text-danger">*</small></label>
                                        <div class="col-sm-8">
                                            <select class="form-control select2" style="width: 100%;" name="no_anggota" id="no_anggota" onchange="pilihAnggota(this.value)">
                                                <option value="">-Pilih Nama Anggota-</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Nama
                                            Anggota<small class="text-danger">*</small></label>
                                        <div class="col-sm-8">
                                            <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama Anggota" required data-parsley-required-message="Nama Anggota Harus Diisi" value="{{ old('nama') }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Jumlah
                                            Simpanan<small class="text-danger">*</small></label>
                                        <div class="col-sm-8">
                                            <input type="text" name="saldo_minimal" class="form-control" id="saldo_minimal" placeholder="Jumlah Simpanan" required data-parsley-required-message="Jumlah Simpanan Harus Diisi" value="{{ old('saldo_minimal') }}" onkeyup="pageSimulasi(0,0)">
                                        </div>
                                    </div>
                                    {{-- <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Jenis Simpanan<small class="text-danger">*</small></label>
                                <div class="col-sm-8"> --}}
                                    {{-- <select class="form-control" style="width: 100%;" name="produk_id" required data-parsley-required-message="Jenis Simpanan Harus Di Pilih" onchange="pilihProduk(this.value)" id="produk_id"> --}}
                                    {{-- <option value="">-Pilih Produk-</option> --}}

                                    {{-- </select> --}}
                                    {{-- </div>
                            </div> --}}
                                    <div class="row mb-3">
                                        <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Jangka
                                            Waktu</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" style="width: 100%;" name="jangka_waktu_id" id="jangka_waktu_id" onchange="pilihJangkaWaktu(this.value)">
                                                <option value="">-Pilih Jangka Waktu-</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3" id="div-ssb">
                                        <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Jenis
                                            SSB</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" style="width: 100%;" name="jenis_ssb" id="jenis_ssb" onchange="pageSimulasi(0,0)">
                                                <option value="">-Pilih Jenis-</option>
                                                <option value="rollover">ROLLOVER</option>
                                                <option value="dibayar">DI BAYAR</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Jumlah
                                            Bulan<small class="text-danger">*</small></label>
                                        <div class="col-sm-4">
                                            <input type="text" name="jumlah_bulan" class="form-control" id="jumlah_bulan" placeholder="Jumlah Bulan" required data-parsley-required-message="Jumlah Bulan Harus Diisi" value="{{ old('jumlah_bulan') }}" onkeyup="pageSimulasi(this.value,0)">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Bunga
                                            P.A (%)<small class="text-danger">*</small></label>
                                        <div class="col-sm-4">
                                            <input type="text" name="jumlah_bunga" class="form-control" id="jumlah_bunga" placeholder="Bunga P.A (%)" required data-parsley-required-message="Jumlah Bunga P.A Harus Diisi" value="{{ old('jumlah_bunga') }}" onkeyup="pageSimulasi(0,this.value)">
                                        </div>
                                    </div>
                                    <input type="hidden" name="jumlah_bunga_efektif" class="form-control" id="jumlah_bunga_efektif" placeholder=" Bunga Efektif(%)" value="{{ old('jumlah_bunga_efektif') }}" onkeyup="pageSimulasi(0,0)">
                                    {{-- <div class="row mb-3" id="bunga-efektif">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Jumlah Bunga Efektif(%)<small class="text-danger">*</small></label>
                                <div class="col-sm-4">
                                    <input type="text" name="jumlah_bunga_efektif" class="form-control" id="jumlah_bunga_efektif" placeholder=" Bunga Efektif(%)" value="{{ old('jumlah_bunga_efektif') }}" onkeyup="pageSimulasi(0,0)">
                                </div>
                            </div> --}}
                            <input type="hidden" name="jumlah_bunga_efektif" class="form-control" id="jumlah_bunga_efektif" placeholder=" Bunga Efektif(%)" value="{{ old('jumlah_bunga_efektif') }}" onkeyup="pageSimulasi(0,0)">
                    </div>
                    <div class="pb-3 col-md-12">
                        <h4>Simulasi Perhitungan</h4>
                        <hr>
                        <div id="pages-simulasi"></div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <button type="submit" class="btn btn-primary btn-sm w-md"><i class="fa fa-save"></i>
                            Simpan Data</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection