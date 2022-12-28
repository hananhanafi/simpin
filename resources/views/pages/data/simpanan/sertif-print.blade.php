@extends('layouts.master')

@section('title')
{{ 'Sertifikat ' . ucwords(strtolower($simpanan->produk->nama_produk)) }}
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18"> Data Sertifikat</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Data</a></li>
                    <li class="breadcrumb-item">Sertifikat</li>
                    <li class="breadcrumb-item active">{{ $simpanan->anggota->nama }}</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header titlely">
                    <div class="row">

                        <div class="col-md-10">
                            <h4 class="card-title">{{ 'Sertifikat ' . ucwords(strtolower($simpanan->produk->nama_produk)) }}
                            </h4>
                        </div>
                        <div class="col-md-2">
                            <!--<button id="generatePDF" class="btn btn-success">Cetak PDF</button>-->
                            {{-- <a href="http://mafiska.net/dev/kopkarmi/simpin/export/sertifikat-ssb/{{$simpanan->id}}" class="btn btn-info btn-sm" style="float: right;margin:0 2px"><i class="fa fa-file-pdf"></i> Cetak PDF</a> --}}
                            <a href="{{ route('export.sertifikat_ssb', $simpanan->id) }}" class="btn btn-info btn-sm" style="float: right;margin:0 2px"><i class="fa fa-file-pdf"></i> Cetak PDF</a>
                            {{-- <a href="http://localhost:8000/export/sertifikat-ssb/{{$simpanan->id}}" class="btn btn-info btn-sm" style="float: right;margin:0 2px"><i class="fa fa-file-pdf"></i> Cetak PDF</a> --}}
                        </div>

                        <div class="col-md-10">
                            <h4 class="card-title">{{ 'Sertifikat ' . ucwords(strtolower($simpanan->produk->nama_produk)) }}
                            </h4>
                            {{-- <p class="card-title-desc">Data berasal dari Sumber yang tersimpan dalam database</code>.</p> --}}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="pb-3 col-md-12">
                                <table id="datatable" class="table dt-responsive nowrap w-100">
                                    <thead>

                                        <tr>
                                            <th colspan="3" class="text-center"><strong>SERTIFIKAT</strong></th>
                                        </tr>
                                        <tr>
                                            <th colspan="3" class="text-center">
                                                <strong>{{ ucwords(strtolower($simpanan->produk->nama_produk)) }}</strong>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Nomor Sertifikat</td>
                                            <td>:</td>
                                            {{-- <td>{{strtotime($simpanan->created_at)}}</td> --}}
                                            <td>{{ date('Y', strtotime($simpanan->created_at)) . $simpanan->id . $simpanan->no_anggota }}
                                            </td>
                                        </tr>
                                        {{-- <tr></tr> --}}
                                        <tr>
                                            <td>Nomor Anggota</td>
                                            <td>:</td>
                                            <td>{{ $simpanan->no_anggota }}</td>
                                        </tr>
                                        <tr>
                                            <td>Nama Anggota</td>
                                            <td>:</td>
                                            <td>{{ $simpanan->nama }}</td>
                                        </tr>
                                        <tr>
                                            <td>Jumlah Nominal</td>
                                            <td>:</td>
                                            <td>Rp. {{ number_format($simpanan->saldo_akhir, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <td>Terbilang</td>
                                            <td>:</td>
                                            <td> {{ strtoupper(Terbilang::make($simpanan->saldo_akhir, ' rupiah')) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Jangka Waktu</td>
                                            <td>:</td>
                                            <td> {{ $simpanan->jangka_waktu }}</td>
                                        </tr>
                                        <tr>
                                            <td>Bunga per tahun</td>
                                            <td>:</td>
                                            <td> {{ $simpanan->jumlah_bunga }}%</td>
                                        </tr>
                                        <tr>
                                            <td>Jenis Simpanan</td>
                                            <td>:</td>
                                            {{-- <td> {{ strtoupper($simpanan->detail[0]->jenis) }}</td> --}}
                                            <td> {{ strtoupper($simpanan->produk->nama_produk) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal Penempatan</td>
                                            <td>:</td>
                                            <td> {{ date('d M Y', strtotime($simpanan->created_at)) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tangga Jatuh Tempo</td>
                                            <td>:</td>
                                            @php
                                            $created = $simpanan->created_at;
                                            $add_month = '+' . ($simpanan->jangka_waktu - 1) . ' months -1 day';
                                            $tempo = date('d M Y', strtotime($add_month, strtotime($created)));
                                            @endphp
                                            <td> {{ $tempo }} </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-right">
                                                <p>Koperasi Karyawan Mulia Industry</p>
                                                <p>{{ date('d-m-Y', strtotime(today())) }}</p>
                                            </td>
                                        </tr>
                                    </tbody>

                                </table>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="pb-3 col-md-12">
                            <table id="datatable" class="table dt-responsive nowrap w-100">
                                <thead>

                                    <tr>
                                        <th colspan="3" class="text-center"><strong>SERTIFIKAT</strong></th>
                                    </tr>
                                    <tr>
                                        <th colspan="3" class="text-center">
                                            <strong>{{ ucwords(strtolower($simpanan->produk->nama_produk)) }}</strong>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Nomor Sertifikat</td>
                                        <td>:</td>
                                        {{-- <td>{{strtotime($simpanan->created_at)}}</td> --}}
                                        <td>{{ date('Y', strtotime($simpanan->created_at)) . $simpanan->id . $simpanan->no_anggota }}
                                        </td>
                                    </tr>
                                    {{-- <tr></tr> --}}
                                    <tr>
                                        <td>Nomor Anggota</td>
                                        <td>:</td>
                                        <td>{{ $simpanan->no_anggota }}</td>
                                    </tr>
                                    <tr>
                                        <td>Nama Anggota</td>
                                        <td>:</td>
                                        <td>{{ $simpanan->nama }}</td>
                                    </tr>
                                    <tr>
                                        <td>Jumlah Nominal</td>
                                        <td>:</td>
                                        <td>Rp. {{ number_format($simpanan->saldo_akhir, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Terbilang</td>
                                        <td>:</td>
                                        <td> {{ strtoupper(Terbilang::make($simpanan->saldo_akhir, ' rupiah')) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Jangka Waktu</td>
                                        <td>:</td>
                                        <td> {{ $simpanan->jangka_waktu }}</td>
                                    </tr>
                                    <tr>
                                        <td>Bunga per tahun</td>
                                        <td>:</td>
                                        <td> {{ $simpanan->jumlah_bunga }}%</td>
                                    </tr>
                                    <tr>
                                        <td>Jenis Simpanan</td>
                                        <td>:</td>
                                        {{-- <td> {{ strtoupper($simpanan->detail[0]->jenis) }}</td> --}}
                                        <td> {{ strtoupper($simpanan->produk->nama_produk) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Penempatan</td>
                                        <td>:</td>
                                        <td> {{ date('d M Y', strtotime($simpanan->created_at)) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tangga Jatuh Tempo</td>
                                        <td>:</td>
                                        @php
                                        $created = $simpanan->created_at;
                                        $add_month = '+' . ($simpanan->jangka_waktu - 1) . ' months -1 day';
                                        $tempo = date('d M Y', strtotime($add_month, strtotime($created)));
                                        @endphp
                                        <td> {{ $tempo }} </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-right">
                                            <p>Koperasi Karyawan Mulia Industry</p>
                                            <p>{{ date('d-m-Y', strtotime(today())) }}</p>
                                        </td>
                                    </tr>
                                </tbody>

                            </table>
                        </div>
                    </div>
                    <div id="editor"></div>

                </div>
            </div>
        </div>
    </div>
    @endsection

    @section('footscript')

    <script>
        // var el = document.getElementByClassName('titlely')[0]
        $('#generatePDF').click(function() {
            var el = $('.titlely')
            console.log('halo');
            el.addClass('invisible')
            window.print();
            el.removeClass('invisible')

        });
    </script>
    <style>
        .parsley-errors-list li {
            color: red !important;
            font-style: italic;
        }

        .parsley-errors-list li {
            color: red !important;
            font-style: italic;
        }

        .simulasi td,
        .simulasi th {
            font-size: 10px !important;
            padding: 0.5rem !important;
        }

        .text-right {
            text-align: right !important;
        }
    </style>
    @endsection