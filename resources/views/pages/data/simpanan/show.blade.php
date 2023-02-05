@extends('layouts.master')

@section('title')
Detail Data Simpanan
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18"> Data Simpanan</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Data</a></li>
                    <li class="breadcrumb-item">Simpanan</li>
                    <li class="breadcrumb-item active">{{ $simpanan->anggota->nama }}</li>
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
                        <h4 class="card-title">Detail Data Simpanan</h4>
                        <p class="card-title-desc">Data berasal dari Sumber yang tersimpan dalam database</code>.</p>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('data.simpanan.index') }}" class="btn btn-info btn-sm" style="float: right;margin-left:5px;"><i class="fa fa-chevron-left"></i> Kembali</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @include('includes.alert')
                <div class="row">
                    <div class="pb-3 col-md-5">
                        <h4>Info Data Simpanan</h4>
                        <table id="table" class="table table-striped table-bordered no-wrap">
                            <tbody>
                                <tr>
                                    <td width="30%">No Anggota</td>
                                    <td width="70%"><?php echo $simpanan->anggota->no_anggota; ?></td>
                                </tr>
                                <tr>
                                    <td width="30%">Nama Anggota</td>
                                    <td width="70%"><?php echo $simpanan->anggota->nama; ?></td>
                                </tr>
                                <tr>
                                    <td width="30%">No Rekening</td>
                                    <td width="70%"><?php echo $simpanan->no_rekening; ?></td>
                                </tr>
                                <tr>
                                    <td width="30%">Jenis Simpanan</td>
                                    <td width="70%"><?php echo $simpanan->produk->nama_produk; ?></td>
                                </tr>
                                <tr>
                                    <td width="30%">Jangka Waktu</td>
                                    <td width="70%"><?php echo $simpanan->jangka_waktu; ?></td>
                                </tr>
                                <tr>
                                    <td width="30%">Bunga P.A</td>
                                    <td width="70%"><?php echo $simpanan->jumlah_bunga; ?> %</td>
                                </tr>
                                @if ($simpanan->produk->nama_produk == 'SIMPANAN PASTI')
                                <tr>
                                    <td width="30%">Bunga Efektif</td>
                                    <td width="70%"><?php echo $simpanan->jumlah_bunga_efektif; ?> %</td>
                                </tr>
                                @endif
                                <tr>
                                    <td width="30%">Status Rekening</td>
                                    <td width="70%"><?php echo $simpanan->status; ?></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="pb-3 col-md-7">

                        @if ($simpanan->produk->nama_produk == 'SIMPANAN SUKARELA BERJANGKA')
                        <div class="row">
                            <div class="col-md-12">
                                <h4>SIMULAI SSB (SIMPANAN SUKARELA BERJANGKA)</h4>
                                <h5>BUNGA MAJEMUK</h5>
                                <table class="table table-bordered table-striped simulasi">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Bulan Ke</th>
                                            <th class="text-center"></th>
                                            <th class="text-center">Jumlah Hari</th>
                                            <th class="text-center">Nominal</th>
                                            <th class="text-center">Bunga Harian</th>
                                            <th class="text-center">Jumlah Bunga</th>
                                            <th class="text-center">PpPPh(10%)h</th>
                                            <th class="text-center">Bunga Dibayar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $totalHari = 0;
                                        $totalJumlahBunga = 0;
                                        // dd($simpanan->rollover());
                                        @endphp
                                        @foreach ($simpanan->detail as $i => $item)
                                        @if ($item->jenis == 'rollover')
                                        <tr>
                                            <td class="text-center">{{ $i + 1 }}</td>
                                            <td class="text-center">
                                                {{ FunctionHelper::bulanSingkat($item->bulan) }}-{{ $item->tahun }}
                                            </td>
                                            <td class="text-center">
                                                {{ $item->jlh_hari }}
                                            </td>
                                            <td class="text-right">
                                                {{ number_format($item->saldo, 0, ',', '.') }}
                                            </td>
                                            <td class="text-center">
                                                {{ $item->bunga_harian }}%
                                            </td>
                                            <td class="text-right">
                                                {{ number_format($item->jlh_bunga, 0, ',', '.') }}
                                            </td>
                                            <td class="text-right">
                                                {{ number_format($item->pph, 0, ',', '.') }}
                                            </td>
                                            <td class="text-right">
                                                {{ number_format($item->bunga_dibayar, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                        @php
                                        $totalHari = $item->total_hari;
                                        $totalJumlahBunga = $item->total_jumlah_bunga;
                                        @endphp
                                        @endif
                                        @endforeach
                                        <tr>
                                            <th class="text-center"></th>
                                            <th class="text-center"></th>
                                            <th class="text-center">{{ $totalHari }}</th>
                                            <th class="text-center"></th>
                                            <th class="text-center"></th>
                                            <th class="text-right">{{ number_format($totalJumlahBunga, 0, ',', '.') }}
                                            </th>
                                            <th class="text-right"></th>
                                            <th class="text-right">{{ number_format($totalJumlahBunga, 0, ',', '.') }}
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                            <div class="col-md-12">
                                <h4>SIMULASI SSB (SIMPANAN SUKARELA BERJANGKA)</h4>
                                <h5>BUNGA DIBAYAR</h5>
                                <table class="table table-bordered table-striped simulasi">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Bulan Ke</th>
                                            <th class="text-center"></th>
                                            <th class="text-center">Jumlah Hari</th>
                                            <th class="text-center">Nominal</th>
                                            <th class="text-center">Bunga Harian</th>
                                            <th class="text-center">Jumlah Bunga</th>
                                            <th class="text-center">PpPPh(10%)h</th>
                                            <th class="text-center">Bunga Dibayar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $totalHari = 0;
                                        $totalJumlahBunga = 0;
                                        // dd($simpanan->rollover());
                                        @endphp
                                        @foreach ($simpanan->detail as $i => $item)
                                        @if ($item->jenis == 'dibayar')
                                        <tr>
                                            <td class="text-center">{{ $i + 1 }}</td>
                                            <td class="text-center">
                                                {{ FunctionHelper::bulanSingkat($item->bulan) }}-{{ $item->tahun }}
                                            </td>
                                            <td class="text-center">
                                                {{ $item->jlh_hari }}
                                            </td>
                                            <td class="text-right">
                                                {{ number_format($item->saldo, 0, ',', '.') }}
                                            </td>
                                            <td class="text-center">
                                                {{ $item->bunga_harian }}%
                                            </td>
                                            <td class="text-right">
                                                {{ number_format($item->bunga_dibayar, 0, ',', '.') }}
                                            </td>
                                            <td class="text-right">
                                                {{ number_format($item->pph, 0, ',', '.') }}
                                            </td>
                                            <td class="text-right">
                                                {{ number_format($item->jlh_bunga, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                        @php
                                        $totalHari = $item->total_hari;
                                        $totalJumlahBunga = $item->total_jumlah_bunga;
                                        @endphp
                                        @endif
                                        @endforeach
                                        <tr>
                                            <th class="text-center"></th>
                                            <th class="text-center"></th>
                                            <th class="text-center">{{ $totalHari }}</th>
                                            <th class="text-center"></th>
                                            <th class="text-center"></th>
                                            <th class="text-center">{{ number_format($totalJumlahBunga, 0, ',', '.') }}
                                            </th>
                                            <th class="text-center"></th>
                                            <th class="text-center">{{ number_format($totalJumlahBunga, 0, ',', '.') }}
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                        @elseif ($simpanan->produk->nama_produk == 'SIMPANAN PASTI')
                        <div class="row">
                            <div class="col-md-12">
                                <h4>SIMPAS (SIMPANAN PASTI)</h4>
                                <div class="row">
                                    <div class="col-md-12">Target Dana Pasti
                                        <B><u>{{ count($simpanan->detailsimpas) - 1 }} Bulan</u> Rp.
                                            {{ number_format($simpanan->detailsimpas[0]->total_saldo_pembulatan, 0, ',', '.') }}</B>
                                    </div>
                                </div>

                                <table class="table table-bordered table-striped simulasi">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Akhir</th>
                                            <th class="text-center">Tabungan Per Bulan</th>
                                            <th class="text-center">Bunga ({{ $simpanan->jumlah_bunga }}%)</th>
                                            <th class="text-center">Saldo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $totalBunga = 0;
                                        @endphp
                                        @foreach ($simpanan->detailsimpas as $i => $item)
                                        <tr>
                                            <td class="text-center">{{ $i + 1 }}</td>
                                            <td class="text-center">
                                                {{ FunctionHelper::bulanSingkat($item->bulan) }}-{{ $item->tahun }}
                                            </td>
                                            <td class="text-center">
                                                Rp. {{ number_format($item->tabungan_per_bulan, 0, ',', '.') }}
                                            </td>
                                            <td class="text-center">
                                                @php
                                                $totalBunga += $item->bunga_harian;
                                                @endphp

                                                @if (count($simpanan->detailsimpas) - 1 == $i)
                                                Rp.
                                                {{ number_format($simpanan->detailsimpas[0]->total_bunga - $totalBunga, 0, ',', '.') }}
                                                @else
                                                Rp. {{ number_format($item->bunga_harian, 0, ',', '.') }}.
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                Rp. {{ number_format($item->saldo_per_bulan, 0, ',', '.') }}
                                            </td>

                                        </tr>
                                        @endforeach
                                        <tr>
                                            <th class="text-center"></th>
                                            <th class="text-center"></th>
                                            <th class="text-center">Rp.
                                                {{ number_format($simpanan->detailsimpas[0]->total_tabungan, 0, ',', '.') }}
                                            </th>
                                            <th class="text-center">Rp.
                                                {{ number_format($simpanan->detailsimpas[0]->total_bunga, 0, ',', '.') }}
                                            </th>
                                            <th class="text-center">Rp.
                                                {{ number_format($simpanan->detailsimpas[0]->total_saldo, 0, ',', '.') }}
                                            </th>
                                        </tr>
                                        <tr>
                                            <th class="text-center" colspan="4">Dibulatkan</th>
                                            <th class="text-center">Rp.
                                                {{ number_format($simpanan->detailsimpas[0]->total_saldo_pembulatan, 0, ',', '.') }}
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="pb-3 col-12 table-responsive">
    <h4>Data Pelunasan</h4>
    <table id="table" class="table">
        <div class="col-md-12 text-right">
            <a href="" class=" btn btn-success"><i class="fa fa-download"></i> Cetak Data Angsuran </a>
        </div>
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
                    <td> {{ $item->keterangan }}</td>
                    <td>{{ ($no+1) }}</td>
                    <td>Rp. {{ number_format($item->nilai_trans, 0, ',', '.') }}</td>
                    <td>{{ $item->tgl_trans }}</td>
                </tr>
            @endforeach

        </tbody>
    </table>

</div>
@endsection

@section('footscript')
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