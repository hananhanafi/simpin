@extends('layouts.master')

@section('title')
Tambah Data Anggota
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Master Data Anggota</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Master</a></li>
                    <li class="breadcrumb-item active">Anggota</li>
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
                        <h4 class="card-title">Form Tambah Data Anggota</h4>
                        <p class="card-title-desc">
                            Data berasal dari Sumber yang tersimpan dalam database</code>.tes
                            @foreach ($profit as $item)
                            {{ $item->id }}
                            @endforeach
                        </p>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('data.anggota.index') }}" class="btn btn-info btn-sm" style="float: right"><i class="fa fa-chevron-left"></i> Kembali</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @include('includes.alert')
                <form action="{{ route('data.anggota.store') }}" method="POST" id="form-tambah">
                    <div class="row">
                        <div class="pb-3 col-md-6">
                            @csrf
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">No Anggota<small class="text-danger">*</small></label>
                                <div class="col-sm-8">
                                    <input type="text" name="no_anggota" class="form-control" id="no_anggota" placeholder="Nomor Anggota" required data-parsley-required-message="Nomor Anggota Harus Diisi" value="{{ old('no_anggota') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Nama Anggota<small class="text-danger">*</small></label>
                                <div class="col-sm-8">
                                    <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama Anggota" required data-parsley-required-message="Nama Anggota Harus Diisi" value="{{ old('nama') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Tempat Lahir</label>
                                <div class="col-sm-8">
                                    <input type="text" name="tmp_lahir" class="form-control" id="tmp_lahir" placeholder="Tempat Lahir" value="{{ old('tmp_lahir') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Tanggal Lahir</label>
                                <div class="col-sm-8">
                                    <input type="date" name="tgl_lahir" class="form-control" id="tgl_lahir" placeholder="Tanggal Lahir" value="{{ old('tgl_lahir') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Jenis Kelamin</label>
                                <div class="col-sm-8">
                                    <select class="form-control" style="width: 100%;" name="jenis_kelamin">
                                        <option value="1" {{ old('jenis_kelamin') == 1 ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="2" {{ old('jenis_kelamin') == 2 ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Agama</label>
                                <div class="col-sm-8">
                                    <select class="form-control" style="width: 100%;" name="agama">
                                        <option value="">-Pilih-</option>
                                        @foreach (FunctionHelper::agama() as $item)
                                        <option value="{{ $item }}" {{ old('agama') == $item ? 'selected' : '' }}>{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Golongan Darah</label>
                                <div class="col-sm-8">
                                    <select class="form-control" style="width: 100%;" name="goldar">
                                        <option value="">-Pilih-</option>
                                        @foreach (FunctionHelper::goldar() as $item)
                                        <option value="{{ $item }}" {{ old('goldar') == $item ? 'selected' : '' }}>{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Alamat</label>
                                <div class="col-sm-8">
                                    <input type="text" name="alamat" class="form-control" id="alamat" placeholder="Alamat" value="{{ old('alamat') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">No KTP</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" name="ktp" id="ktp" maxlength="50" value="{{ old('ktp') }}" placeholder="Masukan No KTP">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">No KK</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" name="no_kk" id="no_kk" maxlength="50" value="{{ old('no_kk') }}" placeholder="Masukan No KK">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Gaji</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" name="gaji" id="gaji" maxlength="50" value="{{ old('gaji') }}" placeholder="Masukan Gaji">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Noka BPJS</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" name="noka_bpjs" id="noka_bpjs" maxlength="50" value="{{ old('noka_bpjs') }}" placeholder="Masukan Noka BPJS">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">NPWP</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" name="npwp" id="npwp" maxlength="100" value="{{ old('npwp') }}" placeholder="Masukan NPWP">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Tanggal Mulai Bekerja</label>
                                <div class="col-sm-8">
                                    <input type="date" name="masukkerja_date" class="form-control" id="masukkerja_date" placeholder="Tanggal Lahir" value="{{ old('masukkerja_date') }}">
                                </div>
                            </div>
                        </div>
                        <div class="pb-3 col-md-6">

                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Email</label>
                                <div class="col-sm-8">
                                    <input type="text" name="email" class="form-control" id="email" placeholder="Masukan Email" value="{{ old('email') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Telepon</label>
                                <div class="col-sm-8">
                                    <input type="text" name="telepon" class="form-control" id="telepon" placeholder="Masukan Telepon" value="{{ old('telepon') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Telepon Ext</label>
                                <div class="col-sm-8">
                                    <input type="text" name="telepon_ext" class="form-control" id="telepon_ext" placeholder="Masukan Telepon Ext" value="{{ old('telepon_ext') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Departemen</label>
                                <div class="col-sm-8">
                                    <select class="form-control select2" style="width: 100%;" name="departement_id" id="departement_id">
                                        <option value="">-Pilih-</option>
                                        @foreach ($departemen as $item)
                                        <option value="{{ $item->id }}" {{ old('departement_id') == $item->id ? 'selected' : '' }}>{{ $item->kode }} - {{ $item->departemen }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Profit Center</label>
                                <div class="col-sm-8">
                                    <select class="form-control select2" style="width: 100%;" name="profit_id" id="profit_id">
                                        <option value="">-Pilih-</option>
                                        @foreach ($profit as $item)
                                        <option value="{{ $item->id }}" {{ old('profit_id') == $item->id ? 'selected' : '' }}>{{ $item->kode }} - {{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Grade Anggota <small class="text-danger">*</small></label>
                                <div class="col-sm-8">
                                    <select class="form-control" style="width: 100%;" name="grade_id" id="grade_id" placeholder="Nomor Anggota" required data-parsley-required-message="Grade Anggota Harus Diisi">
                                        <option value="">-Pilih-</option>
                                        @foreach ($grade as $item)
                                        <option value="{{ $item->id }}__{{ $item->simp_pokok }}__{{ $item->simp_wajib }}" {{ old('grade_id') == $item->id ? 'selected' : '' }}>{{ $item->kode }} - {{ $item->grade_name }} :: Simp.Pokok ({{ number_format($item->simp_pokok,0,',','.') }}) :: Simp.Wajib ({{ number_format($item->simp_wajib,0,',','.') }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div id="div-grade">
                                <div class="row mb-3">
                                    <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Simpanan Pokok</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="simpanan_pokok" class="form-control" id="simpanan_pokok" value="{{ old('simpanan_pokok') }}" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Simpanan Wajib</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="simpanan_wajib" class="form-control" id="simpanan_wajib" value="{{ old('simpanan_wajib') }}" readonly>
                                    </div>
                                </div>
                                <div id="div-grade">
                                    <div class="row mb-3">
                                        <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Simpanan Khusus</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="simpanan_pokok" class="form-control" placeholder="Simpanan Khusus" id="simpanan_pokok" value="{{ old('simpanan_pokok') }}">
                                        </div>
                                    </div>

                                </div>
                                <div id="div-grade">
                                    <div class="row mb-3">
                                        <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">DKM</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="simpanan_pokok" class="form-control" placeholder="Jumlah DKM" id="simpanan_pokok" value="{{ old('simpanan_pokok') }}">
                                        </div>
                                    </div>

                                </div>
                                <div class="row mb-3">
                                    <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Nama Bank</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="bank_code" class="form-control" id="bank_code" placeholder="Masukan Nama Bank" value="{{ old('bank_code') }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">No Rekening Bank</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="bank_norek" class="form-control" id="bank_norek" placeholder="Masukan No Rekening Bank" value="{{ old('bank_norek') }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Rekening Atas Nama</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="bank_nama" class="form-control" id="bank_nama" placeholder="Masukan Atas Nama Rekening" value="{{ old('bank_nama') }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Status E-Banking</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" style="width: 100%;" name="status_ebanking">
                                            <option value="1" {{ old('status_ebanking') == 1 ? 'selected' : '' }}>Aktif</option>
                                            <option value="2" {{ old('status_ebanking') == 2 ? 'selected' : '' }}>Tidak Aktif</option>
                                        </select>
                                    </div>
                                </div>
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
@endsection

@section('footscript')
<link rel="stylesheet" href="{{ asset('packages/select2/dist/css/select2.css') }}">
<script src="{{ asset('packages/select2/dist/js/select2.js') }}"></script>
<script type="text/javascript" src="{{ asset('js') }}/parsley.min.js"></script>
<script type="text/javascript" src="{{ asset('js') }}/currency.js"></script>
<script>
    $('#form-tambah').parsley();
    $(document).ready(function() {
        $('.select2').select2({
            width: '100%'
        })

        $('#gaji').on({
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
        $('#no_anggota, #nama, #tmp_lahir').on({
            keyup: function() {
                let input_val = $(this).val();
                // console.log('asd', input_val);
                $(this).val(input_val);
            },
            blur: function() {
                let input_val = $(this).val();
                input_val = (input_val);
                $(this).val(input_val);
            }
        });
        $('#grade_id').on('change', function() {
            var get = $(this).val().split('__')
            $('#simpanan_pokok').val(numberToCurrency(get[1]))
            $('#simpanan_wajib').val(numberToCurrency(get[2]))
        })
    });
</script>
<style>
    .parsley-errors-list li {
        color: red !important;
        font-style: italic;
    }
</style>
@endsection