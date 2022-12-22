@extends('layouts.master')

@section('title')
Tambah Data Pelunasan
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Form {{ $type_label }}</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Master</a></li>
                    <li class="breadcrumb-item active">Pelunasan</li>
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
                        <h4 class="card-title">Form Tambah Data {{ $type_label }}</h4>
                        <p class="card-title-desc">Data berasal dari Sumber yang tersimpan dalam database</code>.</p>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('data.pinjaman.pelunasan') }}" class="btn btn-info btn-sm" style="float: right"><i class="fa fa-chevron-left"></i> Kembali</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @include('includes.alert')
                <form action="{{ route('data.pelunasan.cicilan') }}" method="POST" id="form-tambah">

                    <input type="hidden" name="id_pinjaman" value="{{ $request->idPinjaman }}">
                    <input type="hidden" name="type" value="{{ $request->type }}">
                    <input type="hidden" name="no_anggota" value="{{ $anggota->no_anggota }}">

                    <div class="row">
                        <div class="pb-3 col-md-6">
                            @csrf
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Nama
                                    Anggota<small class="text-danger">*</small></label>
                                <div class="col-sm-7">
                                    <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama Anggota" required data-parsley-required-message="Nama Anggota Harus Diisi" value="{{ $anggota->nama }}" readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Jumlah
                                    Pinjaman<small class="text-danger">*</small></label>
                                <div class="col-sm-7">
                                    <input type="text" name="jumlah_pinjaman" class="form-control" id="jumlah_pinjaman" placeholder="Jumlah Pinjaman" required data-parsley-required-message="Jumlah Pinjaman Harus Diisi" value="{{ number_format($pinjamanDetail->jml_pinjaman, '0', ',', '.') }}" onkeyup="pageSimulasi(0,0)" readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Jangka Waktu (Bulan)<small class="text-danger">*</small></label>
                                <div class="col-sm-7">
                                    <input type="text" name="jangka_wakktu" class="form-control" id="jangka_wakktu" placeholder="Jangka Waktu" required value="{{ $pinjamanDetail->jangka_waktu }}" onkeyup="pageSimulasi(0,0)" readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Sisa Hutang<small class="text-danger">*</small></label>
                                <div class="col-sm-7">
                                    <input type="text" name="sisa_hutang" class="form-control" id="sisa_hutang" placeholder="Sisa Hutang" required value="{{ number_format($pinjamanDetail->sisa_hutangs, '0', ',', '.') }}" onkeyup="pageSimulasi(0,0)" readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Angsuran<small class="text-danger">*</small></label>
                                <div class="col-sm-7">
                                    <input type="text" name="angsuran" class="form-control" id="angsuran" placeholder="Angsuran" required value="{{ number_format($pinjamanDetail->angsuran, '0', ',', '.') }}" onkeyup="pageSimulasi(0,0)" readonly>
                                </div>
                            </div>
                            {{-- <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Total Pelunasan<small class="text-danger">*</small></label>
                                <div class="col-sm-7">
                                    <input type="text" name="nilai_trans" class="form-control" id="nilai_trans" placeholder="Total Pelunasan" required data-parsley-required-message="Total Pelunasan Harus Diisi" value="{{ number_format($pinjamanDetail->angsuran, '0', ',', '.') }}">
                        </div>
                    </div>--}}
            </div>

            <div class="pb-3 col-md-6">
                {{-- <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">No Rekening<small class="text-danger">*</small></label>
                                <div class="col-sm-7">
                                    <select class="form-control select2" style="width: 100%;" name="no_rekening" id="no_rekening" required data-parsley-required-message="No Rekening Harus Diisi" onchange="pilihAnggota(this.value)">
                                        <option value="">-Pilih Nomor Rekening-</option>
                                    </select>
                                </div>
                            </div> --}}

                {{-- <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Tanggal Pelunasan</label>
                                <div class="col-sm-7">
                                    <input type="date" name="tgl_trans" class="form-control" id="tgl_trans" placeholder="Tanggal Pencairan" required data-parsley-required-message="Tanggal Pelunasan Harus Diisi" value="{{ old('tgl_trans') }}">
            </div>
        </div> --}}
        {{-- <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Cicilan
                                    <small class="text-danger">*</small></label>
                                <div class="col-sm-4">
                                    <input type="number" min="1" name="cicilan" class="form-control" id="cicilan" placeholder="Masukkan cicilan ke-" required data-parsley-required-message="Jumlah Bulan Harus Diisi" value="{{ old('jumlah_bulan') }}" onkeyup="pageSimulasi(this.value,0)">
    </div>
</div> --}}
{{-- <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Total Pelunasan</label>
                                <div class="col-sm-4">
                                    <input type="text" name="asuransi" class="form-control" id="asuransi" placeholder="Total Pelunasan" value="{{ old('asuransi') }}">
</div>
</div> --}}

@if ($request->type == 1)
<div class="row mb-3">
    <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">No Rekening<small class="text-danger">*</small></label>
    <div class="col-sm-7">
        <select class="form-control select2" style="width: 100%;" name="no_rekening" id="no_rekening" required data-parsley-required-message="No Rekening Harus Diisi" onchange="pilihAnggota(this.value)">
            <option value="">-Pilih Nomor Rekening-</option>
        </select>
    </div>
</div>
<div class="row mb-3">
    <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Tanggal Pelunasan</label>
    <div class="col-sm-7">
        <input type="date" name="tgl_trans" class="form-control" id="tgl_trans" placeholder="Tanggal Pencairan" required data-parsley-required-message="Tanggal Pelunasan Harus Diisi" value="{{ old('tgl_trans') }}">
    </div>
</div>
<div class="row mb-3">
    <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Cicilan Ke-<small class="text-danger">*</small></label>
    <div class="col-sm-7">
        <input type="number" name="cicilan" class="form-control" id="cicilan" placeholder="Masukkan cicilan ke-" required data-parsley-required-message="Cicilan Harus Diisi" value="{{ $cicilan }}">
    </div>
</div>
<div class="row mb-3">
    <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Total Pelunasan<small class="text-danger">*</small></label>
    <div class="col-sm-7">
        <input type="text" name="nilai_trans" class="form-control" id="nilai_trans" placeholder="Total Pelunasan" required data-parsley-required-message="Total Pelunasan Harus Diisi" value="{{ number_format($pinjamanDetail->angsuran, '0', ',', '.') }}">
    </div>
    @elseif ($request->type == 2)
    <div class="row mb-3">
        <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">No Rekening<small class="text-danger">*</small></label>
        <div class="col-sm-7">
            <select class="form-control select2" style="width: 100%;" name="no_rekening" id="no_rekening" required data-parsley-required-message="No Rekening Harus Diisi" onchange="pilihAnggota(this.value)">
                <option value="">-Pilih Nomor Rekening-</option>
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Tanggal Pelunasan</label>
        <div class="col-sm-7">
            <input type="date" name="tgl_trans" class="form-control" id="tgl_trans" placeholder="Tanggal Pencairan" required data-parsley-required-message="Tanggal Pelunasan Harus Diisi" value="{{ old('tgl_trans') }}">
        </div>
    </div>
    <div class="row mb-3">
        <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Jumlah Cicilan<small class="text-danger">*</small></label>
        <div class="col-sm-7">
            <input type="number" min="1" name="jumlah_cicilan" class="form-control" id="jumlah_cicilan" placeholder="Masukkan Jumlah Cicilan" required data-parsley-required-message="Jumlah Cicilan Harus Diisi" value="1" onchange="jumlahCicilanChangeHandler(this.value)">
        </div>
        <input type="hidden" name="cicilan" value="{{ $cicilan }}">
    </div>
    <div class="row mb-3">
        <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Total Pelunasan<small class="text-danger">*</small></label>
        <div class="col-sm-7">
            <input type="text" name="nilai_trans" class="form-control" id="nilai_trans" placeholder="Total Pelunasan" required data-parsley-required-message="Total Pelunasan Harus Diisi" value="{{ number_format($pinjamanDetail->angsuran, '0', ',', '.') }}">
        </div>
        @else ($request->type == 3)
        <div class="row mb-3">
            <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Total Pelunasan</label>
            <div class="col-sm-7">
                <input type="text" name="asuransi" class="form-control" id="asuransi" placeholder="Total Pelunasan" value="{{ old('asuransi') }}">
            </div>
        </div>

        <div class="row mb-3">
            <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Jumlah Pinjaman TopUp<small class="text-danger">*</small></label>
            <div class="col-sm-7">
                <input type="text" name="jumlah_pinjaman" class="form-control" id="jumlah_pinjaman" placeholder="Jumlah Pinjaman" required data-parsley-required-message="Jumlah Pinjaman Harus Diisi" value="{{ old('jumlah_pinjaman') }}" onkeyup="">
            </div>
        </div>

        <div class="row mb-3">
            <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Jenis Pinjaman<small class="text-danger">*</small></label>
            <div class="col-sm-7">
                <select class="form-control" style="width: 100%;" name="produk_id" required data-parsley-required-message="Jenis Pinjaman Harus Di Pilih" onchange="pilihProduk(this.value)" id="produk_id">
                    <option value="">-Pilih Produk-</option>

                    <option value="">

                    </option>
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
            <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Jumlah
                Bulan</label>
            <div class="col-sm-7">
                <input type="text" name="jumlah_bulan" class="form-control" id="jumlah_bulan" placeholder="Jumlah Bulan" required data-parsley-required-message="Jumlah Bulan Harus Diisi" value="{{ old('jumlah_bulan') }}">
            </div>
        </div>

        <div class="row mb-3">
            <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Asuransi</label>
            <div class="col-sm-7">
                <input type="text" name="asuransi" class="form-control" id="asuransi" placeholder="Asuransi" value="{{ old('asuransi') }}">
            </div>
        </div>
        <div class="row mb-3">
            <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Admin
                Bank</label>
            <div class="col-sm-7">
                <input type="text" name="admin_bank" class="form-control" id="admin_bank" placeholder="Admin Bank" value="{{ old('admin_bank') }}">
            </div>
        </div>

        @endif
    </div>
</div>
{{-- <div class="pb-3 col-md-12">
                        <div id="pages-simulasi"></div>
                    </div> --}}
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

<div class="pb-3 col-12 table-responsive">
    <h4>Data Pelunasan</h4>
    <table id="table" class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>No Rekening</th>
                <th>Tipe Pelunasan</th>
                <th>Cicilan Ke-</th>
                <th>Nilai Transaksi</th>
                <th>Tgl Transaksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pelunasan as $no => $item)
            <tr>
                <td>{{ ($no+1) }}</td>
                <td>{{ $item->no_rekening }}</td>
                <td> {{ $item->tipe_trans == 2 ? 'Pelunasan Dipercepat' : ($item->tipe_trans == 3 ? 'Pelunasan Topup' : 'Pelunasan Sesuai Cicilan') }}</td>
                <td>{{ $item->cicilan_ke }}</td>
                <td>{{ $item->nilai_trans }}</td>
                <td>{{ $item->tgl_trans }}</td>
            </tr>
            @php
            $cicilan += $item->cicilan;
            @endphp
            @endforeach
        </tbody>
    </table>

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
        $('#no_rekening').select2({
            width: '100%',
            ajax: {
                url: "{{ route('ajax.noRekening') }}",
                dataType: 'json',
                placeholder: 'Ketik Minimal 2 Karakter',
                minimumInputLength: 2,
            }
        })
        // var produk_id = $('#produk_id').val();
        // pilihProduk(produk_id);
        $('#jumlah_pinjaman,#asuransi,#admin_bank').on({
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

    function jumlahCicilanChangeHandler(jml_cicilan) {
        let angsuran = $("input[name='angsuran']").val()
        angsuran = parseInt(angsuran.replaceAll('.', ''))
        const totalPelunasan = jml_cicilan * angsuran
        $("input[name='nilai_trans']").val(numberToCurrency(totalPelunasan))
    }

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
        // var get = val.split('__')
        // $('#nama').val(get[1])
    }

    // function pilihProduk(val) {

    //     var value = val.split('__')
    //     $.ajax({
    //         url: "{{ route('ajax.margin-by-produk') }}",
    //         dataType: "JSON",
    //         data: {
    //             produkid: value[0]
    //         },
    //         success: function(data) {
    //             var i_margin = "<option value=''>-Pilih-</option>";
    //             if (data.status == true) {
    //                 for (var i = 0; i < data.data.length; i++) {
    //                     i_margin += "<option value='" + data.data[i].jangka_waktu + "__" + data.data[i]
    //                         .margin + "'>";
    //                     i_margin += data.data[i].jangka_waktu + " bulan, Bunga : " + data.data[i].margin +
    //                         " %";
    //                     i_margin += "</option>";

    //                 }
    //             }
    //             $("#jangka_waktu_id").html(i_margin);
    //         }
    //     });
    // }

    function pilihJangkaWaktu(val) {
        var get = val.split('__')
        $('#jumlah_bulan').val(get[0])
        $('#jumlah_bunga').val(get[1])

        pageSimulasi(get[0], get[1])
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

    .text-right {
        text-align: right !important;
    }
</style>
@endsection