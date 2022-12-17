@extends('layouts.master')

@section('title')
Plafon Pinjaman
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Plafon Pinjaman</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Data</a></li>
                    <li class="breadcrumb-item">Pinjaman</li>
                    <li class="breadcrumb-item active">Plafon</li>
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
                        <h4 class="card-title">Plafon Pinjaman</h4>
                        <p class="card-title-desc">Form Pengecekan Plafon untuk pinjaman baru.</code>.</p>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('data.pinjaman.create') }}" class="btn btn-info btn-sm" style="float: right"><i class="fa fa-chevron-left"></i> Kembali</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @include('includes.alert')
                <form action="{{ route('data.pinjaman.store') }}" method="POST" id="form-tambah">
                    <div class="row">
                        <div class="pb-3 col-md-6">
                            @csrf
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">No
                                    Anggota<small class="text-danger"></small></label>
                                <div class="col-sm-7">
                                    <input type="text" name="no_anggota" class="form-control" id="no_anggota" placeholder="No Anggota" required data-parsley-required-message="No Anggota" value="{{ $anggota->no_anggota }}" readonly onload="pagePlafon(0,0)">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Nama
                                    Anggota<small class="text-danger">*</small></label>
                                <div class="col-sm-7">
                                    <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama Anggota" required data-parsley-required-message="Nama Anggota Harus Diisi" value="{{ $anggota->nama }}" readonly onload="pagePlafon(0,0)">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Masa
                                    Kerja</label>
                                <div class="col-sm-7">
                                    <input type="number" name="masa_kerja" class="form-control" id="masa_kerja" placeholder="Masa Kerja (Tahun)" value="{{ $masa_kerja }}" onkeyup="pagePlafon(0,0)">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Gaji
                                    Pokok<small class="text-danger">*</small></label>
                                <div class="col-sm-7">
                                    <input type="text" name="gaji_pokok" class="form-control" id="gaji_pokok" placeholder="Gaji Pokok" required value="{{ number_format($anggota->gaji, '0', ',', '.') }}" onkeyup="pagePlafon(this.value,0)">
                                </div>
                            </div>
                        </div>

                        <div class="pb-3 col-md-6">
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Pengajuan
                                    Baru<small class="text-danger">*</small></label>
                                <div class="col-sm-7">
                                    <input type="text" name="jml_pengajuan_baru" class="form-control" id="jml_pengajuan_baru" placeholder="Jumlah Pengajuan Baru" required data-parsley-required-message="Jumlah Pengajuan Harus Diisi" value="{{ number_format($request->saldo, '0', ',', '.') }}" onkeyup="pagePlafon(0,0)">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Jumlah
                                    Bulan<small class="text-danger">*</small></label>
                                <div class="col-sm-7">
                                    <input type="text" name="bulan" class="form-control" id="bulan" placeholder="Jumlah Bulan" required data-parsley-required-message="Jumlah Bulan Harus Diisi" value="{{ $request->bulan }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Angsuran<small class="text-danger">*</small></label>
                                <div class="col-sm-7">
                                    <input type="text" name="angsuran" class="form-control" id="angsuran" placeholder="Angsuran" required data-parsley-required-message="Angsuran Harus Diisi" value="{{ number_format($request->totalAngsuran, '0', ',', '.') }}" onkeyup="pagePlafon(0,0)">
                                </div>
                            </div>
                            {{-- <div class="row mb-3" id="bunga-efektif">
                                    <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Bunga
                                        Efektif(%)<small class="text-danger">*</small></label>
                                    <div class="col-sm-4">
                                        <input type="text" name="jumlah_bunga_efektif" readonly class="form-control"
                                            id="jumlah_bunga_efektif" placeholder=" Bunga Efektif(%)"
                                            value="{{ old('jumlah_bunga_efektif') }}"
                            onkeyup="pageSimulasiEfektif(this.value)">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Margin
                            Flat(%)<small class="text-danger">*</small></label>
                        <div class="col-sm-4">
                            <input type="text" name="jumlah_bunga" class="form-control" id="jumlah_bunga" readonly placeholder="Margin Flat (%)" required data-parsley-required-message="Jumlah Bunga Harus Diisi" value="{{ old('jumlah_bunga') }}" onkeyup="pageSimulasi(0,this.value)">
                        </div>
                    </div> --}}
                    {{-- <input type="hidden" name="jumlah_bunga_efektif" class="form-control" id="jumlah_bunga_efektif" placeholder=" Bunga Efektif(%)" value="{{ old('jumlah_bunga_efektif') }}"
                    onkeyup="pageSimulasi(0,0)"> --}}



            </div>
        </div>
        <hr>
        <div class="pb-3 col-md-12">
            <div id="pages-simulasi"></div>
        </div>
        {{-- <hr> --}}
        {{-- <div class="row">
                            <div class="col-sm-12 text-center">
                                <button type="submit" class="btn btn-primary btn-sm w-md"><i class="fa fa-save"></i>
                                    Simpan Data</button>
                            </div>
                        </div> --}}
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
<script type="text/javascript" src="{{ asset('js') }}/financial.js"></script>

<script>
    $('#form-tambah').parsley();
    $(document).ready(function() {
        // $('#no_anggota').select2({
        //     width: '100%',
        //     ajax: {
        //         url: "{{ route('ajax.anggota') }}",
        //         dataType: 'json',
        //         placeholder: 'Ketik Minimal 2 Karakter',
        //         minimumInputLength: 2,
        //     }
        // })
        //     // var produk_id = $('#produk_id').val();
        //     // pilihProduk(produk_id);
        $('#jumlah_pinjaman, #asuransi, #gaji_pokok, #jml_pengajuan_baru, #angsuran').on({
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
    });

    function pagePlafon(gaji = 0, no_anggota = 0) {
        if (gaji == 0) {
            var gaji = $('#gaji_pokok').val()
        }


        gaji = numberToCurrency(gaji, true, true);

        if (no_anggota == 0) {
            var get_no_anggota = $('#no_anggota').val()
            var split_no_anggota = get_no_anggota.split('__')
            var no_anggota = split_no_anggota[0]
        }

        var masa_kerja = $('#masa_kerja').val()

        console.log('asd', masa_kerja)
        var jml_pengajuan_baru = $('#jml_pengajuan_baru').val()
        var bulan = $('#bulan').val()
        var angsuran = $('#angsuran').val()

        jml_pengajuan_baru = numberToCurrency(jml_pengajuan_baru, true, true);
        angsuran = numberToCurrency(angsuran, true, true);


        // var efektif = bungaEfektifRate(bunga, bulan, 1)
        // $('#jumlah_bunga_efektif').val(efektif.toFixed(6))

        // var saldo = $('#jumlah_pinjaman').val()
        // var jenis_ssb = $('#jenis_ssb').val()

        var request = ''

        request += 'no_anggota=' + no_anggota + '&'
        request += 'masa=' + masa_kerja + '&'
        request += 'gaji=' + gaji + '&'
        request += 'bulan=' + bulan + '&'
        request += 'jml_pengajuan_baru=' + jml_pengajuan_baru + '&'
        request += 'angsuran=' + angsuran

        $('#pages-simulasi').load("{{ route('ajax.pinjaman.plafon') }}?&" + request)
    }

    function pilihAnggota(val) {
        // console.log($('#no_anggota'));
        var get = val.split('__')
        $('#nama').val(get[1])
    }

    function pilihProduk(val) {
        var value = val.split('__')
        $.ajax({
            url: "{{ route('ajax.margin-by-produk') }}",
            dataType: "JSON",
            data: {
                produkid: value[0]
            },
            success: function(data) {
                var i_margin = "<option value=''>-Pilih-</option>";
                if (data.status == true) {
                    for (var i = 0; i < data.data.length; i++) {
                        i_margin += "<option value='" + data.data[i].jangka_waktu + "__" + data
                            .data[i]
                            .margin + "'>";
                        i_margin += data.data[i].jangka_waktu + " bulan, Bunga : " + data.data[i]
                            .margin +
                            " %";
                        i_margin += "</option>";

                    }
                }
                $("#jangka_waktu_id").html(i_margin);
            }
        });
    }

    function unduhSimulasi(no_anggota, masa_kerja, gaji, bulan, jml_pengajuan_baru, angsuran) {

        var request = ''

        request += 'no_anggota=' + no_anggota + '&'
        request += 'masa=' + masa_kerja + '&'
        request += 'gaji=' + gaji + '&'
        request += 'bulan=' + bulan + '&'
        request += 'jml_pengajuan_baru=' + jml_pengajuan_baru + '&'
        request += 'angsuran=' + angsuran

        window.open("{{ route('data.pinjaman.plafon.xls') }}?" + request, '_blank');

    }
</script>

<style>
    .parsley-errors-list li {
        color: red !important;
        font-style: italic;
    }

    td,
    th {
        font-size: 10px !important;
        padding: 0.30rem !important;
    }

    .text-right {
        text-align: right !important;
    }
</style>
@endsection