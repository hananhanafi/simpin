@extends('layouts.master')

@section('title')
Tambah Data Pinjaman Baru
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Master Data Pinjaman Baru</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Master</a></li>
                    <li class="breadcrumb-item active">Pinjaman Baru</li>
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
                        <h4 class="card-title">Form Tambah Data Pinjaman Baru</h4>
                        <p class="card-title-desc">Data berasal dari Sumber yang tersimpan dalam database</code>.</p>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('data.pinjaman.index') }}" class="btn btn-info btn-sm" style="float: right"><i class="fa fa-chevron-left"></i> Kembali</a>
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
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">No Anggota<small class="text-danger">*</small></label>
                                <div class="col-sm-7">
                                    <select class="form-control select2" style="width: 100%;" name="no_anggota" id="no_anggota" onchange="pilihAnggota(this.value)">
                                        <option value="">-Pilih Nama Anggota-</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Nama
                                    Anggota<small class="text-danger">*</small></label>
                                <div class="col-sm-7">
                                    <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama Anggota" required data-parsley-required-message="Nama Anggota Harus Diisi" value="{{ old('nama') }}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Jumlah
                                    Pinjaman<small class="text-danger">*</small></label>
                                <div class="col-sm-7">
                                    <input type="text" name="jumlah_pinjaman" class="form-control" id="jumlah_pinjaman" placeholder="Jumlah Pinjaman" required data-parsley-required-message="Jumlah Pinjaman Harus Diisi" value="{{ old('jumlah_pinjaman') }}" onkeyup="pageSimulasi(0,0)">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Jenis
                                    Pinjaman<small class="text-danger">*</small></label>
                                <div class="col-sm-7">
                                    <select class="form-control" style="width: 100%;" name="produk_id" required data-parsley-required-message="Jenis Pinjaman Harus Di Pilih" onchange="pilihProduk(this.value)" id="produk_id">
                                        <option value="">-Pilih Produk-</option>
                                        @foreach ($produk as $item)
                                        <option value="{{ $item->id }}__{{ $item->tipe_produk }}__{{ $item->nama_produk }}">
                                            {{ $item->kode }} - {{ $item->nama_produk }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Jangka
                                    Waktu</label>
                                <div class="col-sm-7">
                                    <select class="form-control" style="width: 100%;" name="jangka_waktu_id" id="jangka_waktu_id" onchange="pilihJangkaWaktu(this.value)">
                                        <option value="">-Pilih Jangka Waktu-</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Sumber Dana<small class="text-danger"></small></label>
                                <div class="col-sm-7">
                                    <select class="form-control" style="width: 100%;" name="sumber_dana" required data-parsley-required-message="Sumber Dana" onchange="pilihSumberDana(this.value)" id="sumber_dana">
                                        <option value="">-Pilih Sumber Dana-</option>
                                        @foreach ($produk as $item)
                                        <option value="{{ $item->id }}__{{ $item->sumber_dana }}>
                                            {{ $item->kode }} - {{ $item->nama_produk }}">
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class=" pb-3 col-md-6">
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Jumlah
                                    Bulan<small class="text-danger">*</small></label>
                                <div class="col-sm-4">
                                    <input type="text" name="jumlah_bulan" class="form-control" id="jumlah_bulan" placeholder="Jumlah Bulan" required data-parsley-required-message="Jumlah Bulan Harus Diisi" value="{{ old('jumlah_bulan') }}" onkeyup="pageSimulasi(this.value,0)">
                                </div>
                            </div>
                            <div class="row mb-3" id="bunga-efektif">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Bunga
                                    Efektif(%)<small class="text-danger">*</small></label>
                                <div class="col-sm-4">
                                    <input type="text" name="jumlah_bunga_efektif" readonly class="form-control" id="jumlah_bunga_efektif" placeholder=" Bunga Efektif(%)" value="{{ old('jumlah_bunga_efektif') }}" onkeyup="pageSimulasiEfektif(this.value)">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Margin
                                    Flat(%)<small class="text-danger">*</small></label>
                                <div class="col-sm-4">
                                    <input type="text" name="jumlah_bunga" class="form-control" id="jumlah_bunga" readonly placeholder="Margin Flat (%)" required data-parsley-required-message="Jumlah Bunga Harus Diisi" value="{{ old('jumlah_bunga') }}" onkeyup="pageSimulasi(0,this.value)">
                                </div>
                            </div>
                            {{-- <input type="hidden" name="jumlah_bunga_efektif" class="form-control" id="jumlah_bunga_efektif" placeholder=" Bunga Efektif(%)" value="{{ old('jumlah_bunga_efektif') }}" onkeyup="pageSimulasi(0,0)"> --}}


                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Asuransi</label>
                                <div class="col-sm-4">
                                    <input type="text" name="asuransi" class="form-control" id="asuransi" placeholder="Asuransi" value="{{ old('asuransi') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Administrasi</label>
                                <div class="col-sm-4">
                                    <input type="text" name="admin_bank" class="form-control" id="admin_bank" placeholder="Administrasi" value="{{ old('admin_bank') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Admin Bank</label>
                                <div class="col-sm-4">
                                    <input type="text" name="" class="form-control" id="biaya_bank" placeholder="Admin Bank" value="{{ old('biaya_bank') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="pb-3 col-md-12">
                        <div id="pages-simulasi"></div>
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
    var produkList = <?php echo json_encode($produk); ?>;
    var jangkaWaktuList = null
    var selectedProduk = null;
    $(document).ready(function() {
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

        $('#jumlah_pinjaman,#asuransi,#admin_bank,#biaya_bank').on({
            keyup: function() {
                let input_val = $(this).val();
                input_val = numberToCurrency(input_val);
                $(this).val(input_val);
            },
            blur: function() {
                let input_val = $(this).val();
                input_val = numberToCurrency(input_val, true, true);
                $(this).val(input_val);
            },
            change: function() {
                let input_val = $(this).val();
                input_val = numberToCurrency(input_val, true, true);
                $(this).val(input_val);
            },
        });
    });

    function pageSimulasi(bulan = 0, bunga = 0) {


        if (bulan == 0) {
            var bulan = $('#jumlah_bulan').val()
        }
        if (bunga == 0) {
            var bunga = $('#jumlah_bunga').val()
        }

        var produk_id = $('#produk_id').val()
        var value = produk_id.split('__')

        var get_no_anggota = $('#no_anggota').val()
        var no_anggota = get_no_anggota.split('__')

        var id_produk = value[0] + '__' + value[1]

        var efektif = bungaEfektifRate(bunga, bulan, 1)
        $('#jumlah_bunga_efektif').val(efektif.toFixed(6))

        var saldo = $('#jumlah_pinjaman').val()
        var jenis_ssb = $('#jenis_ssb').val()

        const saldoInt = parseInt(saldo.replaceAll('.', ''))
        const adminFee = (saldoInt * 0.0125)
        $('#admin_bank').val(numberToCurrency(adminFee))


        $('#pages-simulasi').load("{{ route('ajax.pinjaman.pengajuan') }}?produk_id=" + id_produk + '&bunga=' + bunga +
            '&bulan=' + bulan + '&saldo=' + saldo + '&bunga_efektif=' + efektif + '&no_anggota=' + no_anggota[0])
    }

    function pageSimulasiEfektif(val) {

        var bulan = $('#jumlah_bulan').val()
        var bunga = $('#jumlah_bunga').val()

        var produk_id = $('#produk_id').val()
        var value = produk_id.split('__')

        var id_produk = value[0] + '__' + value[1]

        var jumlah_bunga_efektif = val
        var saldo = $('#jumlah_pinjaman').val()
        var jenis_ssb = $('#jenis_ssb').val()

        var bPA = bungaPA(val, bulan, 1);
        $('#jumlah_bunga').val(bPA.toFixed(6))
        $('#pages-simulasi').load("{{ route('ajax.pinjaman.simulasi') }}?produk_id=" + id_produk + ' & bunga = ' + bunga +
            '&bulan=' + bulan + '&saldo=' + saldo + '&bunga_efektif=' + jumlah_bunga_efektif + '&jenis-ssb=' +
            jenis_ssb);
        // $('#pages-simulasi').load('{{ route('ajax.pinjaman.simulasi') }}?produk_id='+id_produk+'&bunga='+bunga+'&bulan='+bulan+'&saldo='+saldo+'&bunga_efektif='+jumlah_bunga_efektif+'&jenis-ssb='+jenis_ssb);
    }

    function pilihAnggota(val) {
        var get = val.split('__')
        $('#nama').val(get[1])
        pageSimulasi(0, 0);
    }

    function pilihProduk(val) {
        // console.log('val produk',val)  
        var value = val.split('__')
        const produkID = value[0]
        selectedProduk = produkList.find(produk => produk.id == produkID)
        $.ajax({
            url: "{{ route('ajax.margin-by-produk') }}",
            dataType: "JSON",
            data: {
                produkid: produkID
            },
            success: function(data) {

                jangkaWaktuList = data.data
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

        const jumlahBulan = get[0]
        // const adminFee = selectedProduk.admin_fee
        // $('#admin_bank').val(adminFee)
        var jumlahPinjaman = $('#jumlah_pinjaman').val()
        const jumlahPinjamanInt = parseInt(jumlahPinjaman.replaceAll('.', ''))
        const asuransi = jangkaWaktuList.find(jw => jw.jangka_waktu == jumlahBulan).asuransi
        let calculateAsuransi = (jumlahPinjamanInt * asuransi) / 100
        $('#asuransi').val(numberToCurrency(calculateAsuransi))

        pageSimulasi(get[0], get[1])
    }

    function pilihSumberDana(val) {
        var get = val.split('__')
        $('#sumber_dana').val(get[1])
        pageSimulasi(0, 0);
    }

    function unduhSimulasi(produk_id, bunga, bulan, saldo, bunga_efektif, no_anggota) {

        var request = '';

        request += 'produk_id=' + produk_id + '&'
        request += 'bunga=' + bunga + '&'
        request += 'bulan=' + bulan + '&'
        request += 'saldo=' + saldo + '&'
        request += 'bunga_efektif=' + bunga_efektif + '&'
        request += 'no_anggota=' + no_anggota

        window.open(
            "{{ route('data.pinjaman.pengajuan.xls') }}?" + request,
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