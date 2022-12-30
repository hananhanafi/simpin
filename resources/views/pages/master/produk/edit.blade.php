@extends('layouts.master')

@section('title')
    Edit Data Master Produk
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
                            <h4 class="card-title">Form Edit Data Produk Simpanan dan Pinjaman</h4>
                            <p class="card-title-desc">Data berasal dari Sumber yang tersimpan dalam database</code>.</p>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('master.produk.index') }}" class="btn btn-info btn-sm" style="float: right"><i
                                    class="fa fa-chevron-left"></i> Kembali</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('includes.alert')
                    <form action="{{ route('master.produk.update', $id) }}" method="POST" id="form-edit">
                        <div class="row">
                            <div class="pb-3 col-md-6">
                                @csrf
                                @method('PUT')
                                <div class="row mb-2">
                                    <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Kode
                                        Produk<small class="text-danger">*</small></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="kode" class="form-control" id="kode"
                                            placeholder="Kode Produk" required required
                                            data-parsley-required-message="Kode Produk" value="{{ $produk->kode }}">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Nama
                                        Produk<small class="text-danger">*</small></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="nama_produk" class="form-control" id="nama_produk"
                                            placeholder="Nama Produk" required required
                                            data-parsley-required-message="Nama Produk" value="{{ $produk->nama_produk }}">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="horizontal-password-input" class="col-sm-3 col-form-label">Tipe
                                        Produk</label>
                                    <div class="col-sm-9">
                                        <select class="form-control select2" style="width: 100%;" name="tipe_produk"
                                            onchange="kodeProduk(this.value)">
                                            <option value="">-Pilih-</option>
                                            @foreach ($kategori as $row)
                                                <option
                                                    value="{{ $row->kode }}-{{ $row->tipe_produk }}-{{ strtolower($row->nama) }}"
                                                    {{ $produk->tipe_produk == $row->kode ? 'selected' : '' }}>
                                                    {{ $row->kode }} - {{ $row->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @if ($produk->kode != 'S04')
                                    <div class="row mb-2">
                                        <label for="horizontal-password-input" class="col-sm-3 col-form-label">Tipe
                                            Margin<small class="text-danger">*</small></label>
                                        <div class="col-sm-9">
                                            <select class="form-control select2" style="width: 100%;" name="tipe_margin"
                                                required data-parsley-required-message="Tipe Margin Harus Di Pilih">
                                                <option value="1" {{ $produk->tipe_margin == 1 ? 'selected' : '' }}>
                                                    Flat</option>
                                                <option value="2" {{ $produk->tipe_margin == 2 ? 'selected' : '' }}>
                                                    Annuity</option>

                                            </select>
                                        </div>
                                    </div>
                                @endif

                                <div class="row mb-2">
                                    <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Admin Fee<small
                                            class="text-danger">*</small></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="admin_fee" class="form-control" id="admin_fee"
                                            placeholder="Admin Fee" required required
                                            data-parsley-required-message="Admin Fee Harus Di Isi"
                                            value="{{ $produk->admin_fee }}">
                                    </div>
                                </div>

                                @if ($produk->kode == 'S04')
                                    <div class="row mb-2" id="div-asuransi">
                                        <label for="horizontal-firstname-input"
                                            class="col-sm-3 col-form-label">Asuransi</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="asuransis" class="form-control" id="asuransi"
                                                step="0.1" placeholder="Asuransi" 
                                                required data-parsley-required-message="Asuransi Harus Di Isi"
                                                value="{{ $produk->asuransi }}">
                                        </div>
                                    </div>
                                @endif
                            </div>
                            @php
                                $no = 1;
                            @endphp
                            @if ($produk->kode != '105')
                                <div class="pb-3 col-md-8" id="div-margin">
                                    <hr>
                                    <h4>Margin</h4>
                                    <table class="table" id="dynamic-form">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Jangka Waktu</th>
                                                <th>Bunga P.A</th>
                                                {{-- <th>Bunga Efektif</th> --}}
                                                <th>Asuransi</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no = 1;
                                            @endphp
                                            @foreach ($produk->margin as $i => $item)
                                                <tr id="row{{ $item->id }}">
                                                    <td class="text-center">{{ $no }}</td>
                                                    <td class="text-center">
                                                        <input type="number" name="jangka_waktu[{{ $item->id }}]"
                                                            class="form-control" id="jangka_waktu_{{ $i }}"
                                                            placeholder="Dalam Bulan" value="{{ $item->jangka_waktu }}"
                                                            onkeyup="hitungEfektif({{ $i }})">
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="number" name="margin[{{ $item->id }}]"
                                                            class="form-control" id="bunga_pa_{{ $i }}"
                                                            placeholder="Persentase Margin" step=0.00000001
                                                            value="{{ $item->margin }}"
                                                            onkeyup="hitungEfektif({{ $i }})">
                                                    </td>
                                                    {{-- <td class="text-center">
                                                    @if ($item->margin_flat == 0)
                                                        @php
                                                            $bungaEfektif = FunctionHelper::hitungBungaEfektif($item->jangka_waktu,$item->margin);
                                                        @endphp
                                                        <input type="number" name="margin_flat[{{ $item->id }}]" class="form-control" id="bunga_efektif_{{ $i }}" placeholder="Margin Flat" readonly step=0.01 value="{{ number_format($bungaEfektif,2) }}">
                                                    @else 
                                                        <input type="number" name="margin_flat[{{ $item->id }}]" class="form-control" id="bunga_efektif_{{ $i }}" placeholder="Margin Flat" readonly step=0.01 value="{{ $item->margin_flat }}">
                                                    @endif
                                                    
                                                </td> --}}
                                                    <td class="text-center">
                                                        <input type="number" name="asuransi[{{ $item->id }}]"
                                                            class="form-control" placeholder="Persentase Asuransi"
                                                            step="any" value="{{ $item->asuransi }}">
                                                    </td>
                                                    <td>
                                                        <button type="button" id="{{ $item->id }}"
                                                            class="btn btn-sm btn-danger btn_remove"><i
                                                                class="fa fa-times"></i></button>
                                                    </td>
                                                </tr>
                                                @php
                                                    $no++;
                                                @endphp
                                            @endforeach
                                            @for ($i = 10000; $i <= 10005; $i++)
                                                <tr id="row{{ $i }}">
                                                    <td class="text-center">{{ $no }}</td>
                                                    <td class="text-center">
                                                        <input type="number" name="jangka_waktu[{{ $i }}]"
                                                            id="jangka_waktu_{{ $i }}" class="form-control"
                                                            placeholder="Dalam Bulan"
                                                            onkeyup="hitungEfektif({{ $i }})">
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="number" name="margin[{{ $i }}]"
                                                            id="bunga_pa_{{ $i }}" class="form-control"
                                                            placeholder="Persentase Margin" step=0.00000001
                                                            onkeyup="hitungEfektif({{ $i }})">
                                                    </td>
                                                    {{-- <td class="text-center">
                                                    
                                                </td> --}}
                                                    <input type="hidden" name="margin_flat[{{ $i }}]"
                                                        id="bunga_efektif_{{ $i }}" class="form-control"
                                                        placeholder="Margin Flat" step=0.01 value="0">
                                                    <td class="text-center">
                                                        <input type="number" name="asuransi[{{ $i }}]"
                                                            class="form-control" placeholder="Persentase Asuransi"
                                                            step=0.01>
                                                    </td>
                                                    <td>
                                                        <button type="button" id="{{ $i }}"
                                                            class="btn btn-sm btn-danger btn_remove"><i
                                                                class="fa fa-times"></i></button>
                                                    </td>
                                                </tr>
                                                @php
                                                    $no++;
                                                @endphp
                                            @endfor
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-sm-7 text-center">
                                    <button type="submit" class="btn btn-primary btn-sm w-md"><i class="fa fa-save"></i>
                                        Simpan Data</button>
                                    <button type="button" class="btn btn-sm btn-success btn-tambah" id="tambah"><i
                                            class="fa fa-plus"></i> Tambah Kolom</button>
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
        $('#form-edit').parsley();
        $(document).ready(function() {

            var tipe_produk = '{{ $produk->tipe_jenis }}';
            var kode_produk = '{{ $produk->tipe_produk }}';
            var nama = '{{ strtolower($produk->nama_produk) }}';
            // alert(kode_produk)
            // if(nama == 'simpanan pasti'){
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
            var no = '{{ $no }}';
            var html
            $('#tambah').click(function() {

                html = '<tr id="row' + no + '">\
                            <td class="text-center">' + no + '</td>\
                            <td>\
                                <input type="number" name="jangka_waktu[' + no + ']" class="form-control" placeholder="Dalam Bulan"/>\
                            </td>\
                            <td>\
                                <input type="number" name="margin[' + no + ']" class="form-control" placeholder="Persentase Margin" step=0.01>\
                            </td>\
                            <td style="display:none">\
                                <input type="number" name="margin_flat[' + no + ']" class="form-control" placeholder="Margin Flat" step=0.01 value="0">\
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

        function hitungEfektif(i) {
            var jangka_waktu = $('#jangka_waktu_' + i).val();
            var bunga_pa = $('#bunga_pa_' + i).val();
            var bunga_efektif = $('#bunga_efektif_' + i);

            var bunga = hitungBungaEfektif(bunga_pa, jangka_waktu);
            bunga_efektif.val(bunga.toFixed(2))
        }

        function kodeProduk(val) {
            // if()
            // alert(val)
            // var kode = val.split('-')
            // if(kode[2] == 'simpanan pasti'){
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
    </script>
    <style>
        .parsley-errors-list li {
            color: red !important;
            font-style: italic;
        }
    </style>
@endsection
