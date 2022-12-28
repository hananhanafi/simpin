@extends('layouts.master')

@section('title')
Tambah Data Master Produk
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Master Data Produk</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Master</a></li>
                    <li class="breadcrumb-item active">Produk</li>
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
                        <h4 class="card-title">Form Tambah Data Produk Simpanan dan Pinjaman</h4>
                        <p class="card-title-desc">Data berasal dari Sumber yang tersimpan dalam database</code>.</p>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('master.produk.index') }}" class="btn btn-info btn-sm" style="float: right"><i class="fa fa-chevron-left"></i> Kembali</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @include('includes.alert')
                <form action="{{ route('master.produk.store') }}" method="POST" id="form-tambah">
                    <div class="row">
                        <div class="pb-3 col-md-6">
                            @csrf
                            <div class="row mb-2">
                                <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Kode Produk<small class="text-danger">*</small></label>
                                <div class="col-sm-9">
                                    <input type="text" name="kode" class="form-control" id="kode" placeholder="Kode Produk" required required data-parsley-required-message="Kode Produk" value="{{ old('kode') }}">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Nama Produk<small class="text-danger">*</small></label>
                                <div class="col-sm-9">
                                    <input type="text" name="nama_produk" class="form-control" id="nama_produk" placeholder="Nama Produk" required required data-parsley-required-message="Nama Produk" value="{{ old('nama_produk') }}">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="horizontal-password-input" class="col-sm-3 col-form-label">Tipe Produk<small class="text-danger">*</small></label>
                                <div class="col-sm-9">
                                    <select class="form-control select2" style="width: 100%;" name="tipe_produk" required data-parsley-required-message="Tipe Produk Harus Di Pilih" onchange="kodeProduk(this.value)">
                                        <option value="">-Pilih-</option>
                                        @foreach($kategori as $row)
                                        <option value="{{$row->kode}}-{{ $row->tipe_produk }}-{{strtolower($row->nama)}}" {{ old('tipe_produk') == $row->kode ? 'selected' : '' }}>{{ $row->kode }} - {{$row->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-2" id="tipe-margin">
                                <label for="horizontal-password-input" class="col-sm-3 col-form-label">Tipe Margin</label>
                                <div class="col-sm-9">
                                    <select class="form-control select2" style="width: 100%;" name="tipe_margin">
                                        <option value="1">Flat</option>
                                        <option value="2">Annuity</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Admin Fee<small class="text-danger">*</small></label>
                                <div class="col-sm-9">
                                    <input type="text" name="admin_fee" class="form-control" id="admin_fee" placeholder="Admin Fee" required required data-parsley-required-message="Admin Fee Harus Di Isi" value="{{ old('admin_fee') }}">
                                </div>
                            </div>
                            <div class="row mb-2" id="div-asuransi">
                                <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Asuransi</label>
                                <div class="col-sm-9">
                                    <input type="text" name="asuransis" class="form-control" id="asuransi" placeholder="Asuransi" value="{{ old('asuransi') }}">
                                </div>
                            </div>
                        </div>
                        <div class="pb-3 col-md-8" id="div-margin">
                            <hr>
                            <h4>Margin</h4>
                            <table class="table" id="dynamic-form">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Jangka Waktu</th>
                                        <th>Bunga Flat</th>
                                        {{-- <th>Bunga Efektif</th> --}}
                                        <th>Asuransi</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i=1; $i<=10 ;$i++) <tr id="row{{ $i }}">
                                        <td class="text-center">{{ $i }}</td>
                                        <td class="text-center">
                                            <input type="number" name="jangka_waktu[{{ $i }}]" class="form-control" id="jangka_waktu_{{ $i }}" placeholder="Dalam Bulan" onkeyup="hitungEfektif({{ $i }})">
                                        </td>
                                        <td class="text-center">
                                            <input type="number" name="margin[{{ $i }}]" class="form-control" id="bunga_pa_{{ $i }}" placeholder="Persentase Margin" step=0.01 onkeyup="hitungEfektif({{ $i }})">
                                        </td>
                                        {{-- <td class="text-center">
                                                <input type="number" name="margin_flat[{{ $i }}]" class="form-control" id="bunga_efektif_{{ $i }}" placeholder="Margin Flat" step=0.01 readonly>
                                        </td> --}}
                                        <td class="text-center">
                                            <input type="number" name="asuransi[{{ $i }}]" class="form-control" placeholder="Persentase Asuransi" step=0.01>
                                        </td>
                                        <td>
                                            <button type="button" id="{{ $i }}" class="btn btn-sm btn-danger btn_remove"><i class="fa fa-times"></i></button>
                                        </td>
                                        </tr>
                                        @endfor
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-sm-7 text-center">
                                <button type="submit" class="btn btn-primary btn-sm w-md"><i class="fa fa-save"></i> Simpan Data</button>
                                <button type="button" class="btn btn-sm btn-success btn-tambah" id="tambah"><i class="fa fa-plus"></i> Tambah Kolom</button>
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
<script type="text/javascript" src="{{ asset('js') }}/currency.js"></script>
<script>
    $('#form-tambah').parsley();
    $(document).ready(function() {

        var no = '{{ $i }}';
        var html

        // $('#div-margin').hide();
        $('#admin_fee').on({
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
        $('#asuransi').on({
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
        $('#tambah').click(function() {

            html = '<tr id="row' + no + '">\
                        <td class="text-center">' + no + '</td>\
                        <td>\
                            <input type="number" name="jangka_waktu[' + no + ']" class="form-control" placeholder="Dalam Bulan"/>\
                        </td>\
                        <td>\
                            <input type="number" name="margin[' + no + ']" class="form-control" placeholder="Persentase Margin" step=0.01/>\
                        </td>\
                        <td>\
                            <input type="number" name="margin_flat[' + no + ']" class="form-control" placeholder="Margin Flat" step=0.01/>\
                        </td>\
                        <td>\
                            <input type="number" name="asuransi[' + no + ']" class="form-control" placeholder="Persentase Asuransi" step=0.01>\
                        </td>\
                        <td>\
                            <button type="button" id="' + no + '" class="btn btn-danger btn-sm btn_remove"><i class="fa fa-times"></i></button>\
                        </td>\
                    </tr>';

            $('#dynamic-form').append(html);
            no++;
        });
        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
        });
    });

    function kodeProduk(val) {
        // if()
        // alert(val)
        // var kode = val.split('-')
        // if(kode[2] === 'simpanan pasti'){
        //     $('#div-margin').hide();
        //     $('#tipe-margin').hide()
        //     $('#tambah').hide()
        //     $('#div-asuransi').show()
        // }
        // else{
        $('#div-margin').show();
        $('#tambah').show()
        $('#tipe-margin').show()
        $('#div-asuransi').hide()
        // }
    }

    function hitungEfektif(i) {
        var jangka_waktu = $('#jangka_waktu_' + i).val();
        var bunga_pa = $('#bunga_pa_' + i).val();
        var bunga_efektif = $('#bunga_efektif_' + i);

        var bunga = hitungBungaEfektif(bunga_pa, jangka_waktu);
        bunga_efektif.val(bunga.toFixed(2))
    }
</script>
<style>
    .parsley-errors-list li {
        color: red !important;
        font-style: italic;
    }
</style>
@endsection