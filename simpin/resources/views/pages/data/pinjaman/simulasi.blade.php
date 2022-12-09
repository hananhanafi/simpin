@extends('layouts.master')

@section('title')
    Simulasi Pinjaman SSB
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Simulasi Pinjaman</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Data</a></li>
                        <li class="breadcrumb-item">Simulasi</li>
                        <li class="breadcrumb-item active">Pinjaman</li>
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
                            <h4 class="card-title">Simulasi Pinjaman</h4>
                            <p class="card-title-desc">Data berasal dari Sumber yang tersimpan dalam database</code>.</p>
                        </div>
                        <div class="col-md-6">
                            {{-- <a href="{{ route('data.pinjaman.index') }}" class="btn btn-info btn-sm" style="float: right"><i class="fa fa-plus-circle"></i> Tambah Data</a> --}}
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('includes.alert')
                    <form action="{{ route('data.pinjaman.simulasi') }}" method="GET">
                        @csrf
                        <div class="pb-3 col-md-12">
                            @csrf
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Jumlah
                                    Pinjaman<small class="text-danger">*</small></label>
                                <div class="col-sm-4">
                                    <input type="text" name="saldo_minimal" class="form-control" id="saldo_minimal"
                                        placeholder="Jumlah Pinjaman" required
                                        data-parsley-required-message="Jumlah Pinjaman Harus Diisi"
                                        value="{{ old('saldo_minimal') }}" onkeyup="pageSimulasi(0,0)">
                                </div>
                            </div>
                            {{-- @foreach ($produk as $item)
                            <option value="{{ $item->id }}__{{ $item->tipe_produk }}__{{ $item->nama_produk }}">{{ $item->kode }} - {{ $item->nama_produk }}</option>
                            @if ($item->nama_produk == 'SIMPANAN PASTI')
                                <input type="hidden" name="produk_id" id="produk_id" value="{{ $item->id }}__{{ $item->tipe_produk }}__{{ $item->nama_produk }}">
                            @endif
                        @endforeach
                        <input type="hidden" name="jangka_waktu_id" class="form-control" id="jangka_waktu_id" placeholder="Jangka Waktu" required data-parsley-required-message="Jangka Waktu Harus Diisi" value="{{ old('jangka_waktu') }}" onkeyup="pageSimulasi(0,0)"> --}}
                            <input type="hidden" name="jenis_ssb" id="jenis_ssb">
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Jenis Pinjaman<small
                                        class="text-danger">*</small></label>
                                <div class="col-sm-4">
                                    <select class="form-control" style="width: 100%;" name="produk_id" required
                                        data-parsley-required-message="Jenis Pinjaman Harus Di Pilih"
                                        onchange="pilihProduk(this.value)" id="produk_id">
                                        <option value="">-Pilih Produk-</option>
                                        @foreach ($produk as $item)
                                            <option
                                                value="{{ $item->id }}__{{ $item->tipe_produk }}__{{ $item->nama_produk }}">
                                                {{ $item->kode }} - {{ $item->nama_produk }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Jangka Waktu</label>
                                <div class="col-sm-4">
                                    <select class="form-control" style="width: 100%;" name="jangka_waktu_id"
                                        id="jangka_waktu_id" onchange="pilihJangkaWaktu(this.value)">
                                        <option value="">-Pilih Jangka Waktu-</option>

                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Jumlah Bulan<small
                                        class="text-danger">*</small></label>
                                <div class="col-sm-4">
                                    <input type="text" name="jumlah_bulan" class="form-control" id="jumlah_bulan"
                                        placeholder="Jumlah Bulan" required
                                        data-parsley-required-message="Jumlah Bulan Harus Diisi"
                                        value="{{ old('jumlah_bulan') }}" onkeyup="pageSimulasi(this.value, 0)">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Bunga
                                    Efektif(%)<small class="text-danger">*</small></label>
                                <div class="col-sm-4">
                                    <input type="text" name="jumlah_bunga_efektif" readonly class="form-control"
                                        id="jumlah_bunga_efektif" placeholder=" Bunga Efektif(%)"
                                        value="{{ old('jumlah_bunga_efektif') }}" onkeyup="pageSimulasiEfektif(this.value)">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Margin Flat(%)<small
                                        class="text-danger">*</small></label>
                                <div class="col-sm-4">
                                    <input type="text" name="jumlah_bunga" class="form-control" id="jumlah_bunga"
                                        readonly placeholder="Margin Flat (%)" required
                                        data-parsley-required-message="Jumlah Bunga Harus Diisi"
                                        value="{{ old('jumlah_bunga') }}" onkeyup="pageSimulasi(0,this.value)">
                                    {{-- <input type="text" name="jumlah_bunga"  class="form-control" id="jumlah_bunga" readonly placeholder="Jumlah Bunga (%)" required data-parsley-required-message="Jumlah Bunga Harus Diisi" value="{{ old('jumlah_bunga') }}"> --}}
                                </div>
                            </div>
                            {{--  --}}
                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    {{-- <button type="submit" class="btn btn-primary btn-sm w-md"><i class="fa fa-save"></i> Simulasi Pinjaman</button> --}}
                                </div>
                            </div>
                        </div>
                        <div class="pb-3 col-md-12">
                            <hr>
                            <div id="pages-simulasi"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <form id="delete-form" method="post">
        @csrf
        @method('DELETE')
    </form>
@endsection

@section('css')
    <!-- DataTables -->
    <link href="{{ asset('assets') }}/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets') }}/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ asset('assets') }}/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css"
        rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/sweetalert/sweetalert.css">

    <style>
        td {
            font-size: 11px !important;
        }

        .text-right {
            text-align: right !important;
        }
    </style>
@endsection

@section('footscript')
    <!-- Required datatable js -->
    <script src="{{ asset('assets') }}/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('assets') }}/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <!-- Buttons examples -->
    <script src="{{ asset('assets') }}/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('assets') }}/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="{{ asset('assets') }}/libs/jszip/jszip.min.js"></script>
    <script src="{{ asset('assets') }}/libs/pdfmake/build/pdfmake.min.js"></script>
    <script src="{{ asset('assets') }}/libs/pdfmake/build/vfs_fonts.js"></script>
    <script src="{{ asset('assets') }}/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="{{ asset('assets') }}/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="{{ asset('assets') }}/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>

    <!-- Responsive examples -->
    <script src="{{ asset('assets') }}/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('assets') }}/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
    <script type="text/javascript" charset="utf8" src="{{ asset('assets') }}/sweetalert/sweetalert.min.js"></script>
    <script type="text/javascript" src="{{ asset('js') }}/currency.js"></script>
    <script type="text/javascript" src="{{ asset('js') }}/financial.js"></script>
    <script>
        $(document).ready(function() {
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

        function pageSimulasi(bulan = 0, bunga = 0) {


            if (bulan == 0) {
                var bulan = $('#jumlah_bulan').val()
            }
            if (bunga == 0) {
                var bunga = $('#jumlah_bunga').val()
            }


            // var efektif = hitungBungaEfektif(bunga,bulan)


            var produk_id = $('#produk_id').val()
            var value = produk_id.split('__')

            var id_produk = value[0] + '__' + value[1]

            var jumlah_bunga_efektif = $('#jumlah_bunga_efektif').val()
            var saldo = $('#saldo_minimal').val()
            var jenis_ssb = $('#jenis_ssb').val()

            var efektif = bungaEfektifRate(bunga, bulan, 1)
            $('#jumlah_bunga_efektif').val(efektif.toFixed(3))

            $('#pages-simulasi').load('{{ route('ajax.pinjaman.simulasi') }}?produk_id=' + id_produk + '&bunga=' + bunga +
                '&bulan=' + bulan + '&saldo=' + saldo + '&bunga_efektif=' + efektif + '&jenis-ssb=' + jenis_ssb);
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

            // getBungaPA(val, bulan, saldo);
            var bPA = bungaPA(val, bulan, saldo);
            // console.log(bpA);
            $('#jumlah_bunga').val(bPA.toFixed(2))
            $('#pages-simulasi').load('{{ route('ajax.pinjaman.simulasi') }}?produk_id=' + id_produk + '&bunga=' + bunga +
                '&bulan=' + bulan + '&saldo=' + saldo + '&bunga_efektif=' + jumlah_bunga_efektif + '&jenis-ssb=' +
                jenis_ssb);
        }

        function getBungaPA(val, bulan, saldo) {
            $.ajax({
                url: '{{ url('ajax/get-bungapa-by-marginflat') }}',
                data: {
                    marginFlat: val,
                    bulan: bulan,
                    saldo: saldo,
                },
                type: 'POST',
                success: function(res) {
                    $('#jumlah_bunga').val(res)
                }
            })
        }

        function unduhSimulasi(produk_id, bunga, bulan, saldo, bunga_efektif) {

            var request = '';

            request += 'produk_id=' + produk_id + '&'
            request += 'bunga=' + bunga + '&'
            request += 'bulan=' + bulan + '&'
            request += 'saldo=' + saldo + '&'
            request += 'bunga_efektif=' + bunga_efektif

            window.open(
                '{{ route('data.pinjaman.simulasi.xls') }}?' + request,
                '_blank'
            );
        }
    </script>
@endsection

@section('modal')
@endsection
