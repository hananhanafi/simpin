@extends('layouts.master')

@section('title')
Tambah Data Simpanan Baru
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Master Data Simpanan Baru</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Master</a></li>
                    <li class="breadcrumb-item active">Simpanan Baru</li>
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
                        <h4 class="card-title">Form Tambah Data Simpanan Baru Simpanan Pasti (SIMPAS)</h4>
                        <p class="card-title-desc">Data berasal dari Sumber yang tersimpan dalam database</code>.</p>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('data.simpanan.index') }}" class="btn btn-info btn-sm" style="float: right"><i class="fa fa-chevron-left"></i> Kembali</a>
                    </div>
                </div>
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
                            @foreach ($produk as $item)
                            {{-- <option value="{{ $item->id }}__{{ $item->tipe_produk }}__{{ $item->nama_produk }}">{{ $item->kode }} - {{ $item->nama_produk }}</option> --}}
                            @if ($item->nama_produk == 'SIMPANAN PASTI')
                            <input type="hidden" name="produk_id" id="produk_id" value="{{ $item->id }}__{{ $item->tipe_produk }}__{{ $item->nama_produk }}">
                            @endif
                            @endforeach
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
                            {{-- <input type="hidden" name="jangka_waktu_id" class="form-control" id="jangka_waktu_id" placeholder="Jangka Waktu" required data-parsley-required-message="Jangka Waktu Harus Diisi" value="{{ old('jangka_waktu') }}" onkeyup="pageSimulasi(0,0)"> --}}
                            <input type="hidden" name="jenis_ssb" id="jenis_ssb">
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Jumlah
                                    Bulan<small class="text-danger">*</small></label>
                                <div class="col-sm-4">
                                    <input type="text" name="jumlah_bulan" class="form-control" id="jumlah_bulan" placeholder="Jumlah Bulan" required data-parsley-required-message="Jumlah Bulan Harus Diisi" value="{{ old('jumlah_bulan') }}" onkeyup="pageSimulasi(this.value,0)">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Bunga P.A
                                    (%)<small class="text-danger">*</small></label>
                                <div class="col-sm-4">
                                    <input type="text" name="jumlah_bunga" class="form-control" id="jumlah_bunga" placeholder="Bunga P.A (%)" required data-parsley-required-message="Jumlah Bunga P.A Harus Diisi" value="{{ old('jumlah_bunga') }}" onkeyup="pageSimulasi(0,this.value)">
                                </div>
                            </div>
                            {{-- <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Jumlah Bunga Efektif(%)<small class="text-danger">*</small></label>
                                <div class="col-sm-4">
                                    <input type="text" name="jumlah_bunga_efektif" class="form-control" id="jumlah_bunga_efektif" placeholder=" Bunga Efektif(%)" value="{{ old('jumlah_bunga_efektif') }}" onkeyup="pageSimulasiEfektif(this.value)">
                        </div>
                    </div> --}}
                    <input type="hidden" name="jumlah_bunga_efektif" class="form-control" id="jumlah_bunga_efektif" placeholder=" Bunga Efektif(%)" value="{{ old('jumlah_bunga_efektif') }}" onkeyup="pageSimulasiEfektif(this.value)">
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

@section('footscript')
<link rel="stylesheet" href="{{ asset('packages/select2/dist/css/select2.css') }}">
<script src="{{ asset('packages/select2/dist/js/select2.js') }}"></script>
<script type="text/javascript" src="{{ asset('js') }}/parsley.min.js"></script>
<script type="text/javascript" src="{{ asset('js') }}/currency.js"></script>
<script type="text/javascript" src="{{ asset('js') }}/financial.js"></script>

<script>
    $('#form-tambah').parsley();
    $(document).ready(function() {
        $('#div-ssb').hide()
        $('#bunga-efektif').hide()
        $('#no_anggota').select2({
            width: '100%',
            ajax: {
                url: "{{ route('ajax.anggota') }}",
                dataType: 'json',
                placeholder: 'Ketik Minimal 2 Karakter',
                minimumInputLength: 2,
                processResults: function(data, params) {
                    // parse the results into the format expected by Select2
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data, except to indicate that infinite
                    // scrolling can be used
                    return {
                        results: data.results,
                        pagination: {
                            more: false
                        }
                    };
                },
            }
        })
        var produk_id = $('#produk_id').val();
        pilihProduk(produk_id);
        $('#saldo_minimal').on({
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

    function pageSimulasi(bulan = 0, bunga = 0) {


        if (bulan == 0) {
            var bulan = $('#jumlah_bulan').val()
        }
        if (bunga == 0) {
            var bunga = $('#jumlah_bunga').val()
        }


        // var efektif = hitungBungaEfektif(bunga,bulan)
        var efektif = bungaEfektif(bunga, bulan, 1)
        $('#jumlah_bunga_efektif').val(efektif.toFixed(5))

        var produk_id = $('#produk_id').val()
        var value = produk_id.split('__')

        var id_produk = value[0] + '__' + value[1]

        var jumlah_bunga_efektif = $('#jumlah_bunga_efektif').val()
        var saldo = $('#saldo_minimal').val()
        var jenis_ssb = $('#jenis_ssb').val()

        var get_no_anggota = $('#no_anggota').val()
        var no_anggota = get_no_anggota.split('__')

        $('#pages-simulasi').load("{{ route('ajax.simpanan.simulasi') }}?produk_id=" + id_produk + '&bunga=' + bunga +
            '&bulan=' + bulan + '&saldo=' + saldo + '&bunga_efektif=' + jumlah_bunga_efektif + '&jenis-ssb=' +
            jenis_ssb + '&no_anggota=' + no_anggota[0]);
    }

    function pageSimulasiEfektif(val) {

        var bulan = $('#jumlah_bulan').val()
        var bunga = $('#jumlah_bunga').val()

        var produk_id = $('#produk_id').val()
        var value = produk_id.split('__')

        var id_produk = value[0] + '__' + value[1]

        var jumlah_bunga_efektif = val
        var saldo = $('#saldo_minimal').val()
        var jenis_ssb = $('#jenis_ssb').val()


        $('#pages-simulasi').load("{{ route('ajax.simpanan.simulasi') }}?produk_id=" + id_produk + '&bunga=' + bunga +
            '&bulan=' + bulan + '&saldo=' + saldo + '&bunga_efektif=' + jumlah_bunga_efektif + '&jenis-ssb=' +
            jenis_ssb);
    }

    function pilihAnggota(val) {
        var get = val.split('__')
        $('#nama').val(get[1])
        pageSimulasi()
    }

    function pilihProduk(val) {

        var value = val.split('__')
        if (value[2] == 'SIMPANAN SUKARELA BERJANGKA')
            $('#div-ssb').show()
        else
            $('#div-ssb').hide()
        // if(value[1] == '105')
        //     $('#bunga-efektif').show()
        // else
        //     $('#bunga-efektif').hide()
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
                        i_margin += "<option value='" + data.data[i].jangka_waktu + "__" + data.data[i]
                            .margin + "'>";
                        i_margin += data.data[i].jangka_waktu + " bulan, Bunga : " + data.data[i].margin +
                            " %";
                        i_margin += "</option>";

                    }
                }
                $("#jangka_waktu_id").html(i_margin);
            }
        });
    }

    function pilihJangkaWaktu(val) {
        var get = val.split('__')
        $('#jumlah_bulan').val(get[0])
        $('#jumlah_bunga').val(get[1])

        pageSimulasi(get[0], get[1])
    }

    function unduhSimulasi(produk_id, bunga, bulan, saldo, bunga_efektif) {

        var request = '';

        request += 'produk_id=' + produk_id + '&'
        request += 'bunga=' + bunga + '&'
        request += 'bulan=' + bulan + '&'
        request += 'saldo=' + saldo + '&'
        request += 'bunga_efektif=' + bunga_efektif

        window.open(
            "{{ route('data.simpanan.simulasi-simpan.xls') }}?" + request,
            '_blank'
        );
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