@extends('layouts.master')

@section('title')
    Detail Data Anggota
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18"> Data Anggota</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Data</a></li>
                    <li class="breadcrumb-item">Anggota</li>
                    <li class="breadcrumb-item active">{{ $anggota->nama }}</li>
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
                        <h4 class="card-title">Detail Data Anggota</h4>
                        <p class="card-title-desc">Data berasal dari Sumber yang tersimpan dalam database</code>.</p>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('data.anggota.index') }}" class="btn btn-info btn-sm" style="float: right;margin-left:5px;"><i class="fa fa-chevron-left"></i> Kembali</a>
                        <a href="{{ route('data.anggota.edit', $id) }}" class="btn btn-primary btn-sm" style="float: right;margin-left:5px;"><i class="fa fa-edit"></i> Edit</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @include('includes.alert')
                    <div class="row">
                        <div class="pb-3 col-md-6">
                            <h4>Info Anggota</h4>
                            <table id="table" class="table table-striped table-bordered no-wrap">
                                <tbody>
                                    <tr>
                                        <td width="30%">No Anggota</td>
                                        <td width="70%"><?php echo $anggota->no_anggota; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="30%">Nama Anggota</td>
                                        <td width="70%"><?php echo $anggota->nama;?></td>
                                    </tr>
                                    <tr>
                                        <td width="30%">Agama</td>
                                        <td width="70%"><?php echo ($anggota->agama != 0 ? $anggota->agama : '-');?></td>
                                    </tr>
                                    <tr>
                                        <td width="30%">Golongan Darah</td>
                                        <td width="70%"><?php echo ($anggota->goldar != 0 ? $anggota->goldar : '-');?></td>
                                    </tr>
                                    <tr>
                                        <td width="30%">NIK / KTP</td>
                                        <td width="70%"><?php echo $anggota->nik;?></td>
                                    </tr>
                                    <tr>
                                        <td width="30%">NO KK</td>
                                        <td width="70%"><?php echo $anggota->no_kk;?></td>
                                    </tr>
                                    <tr>
                                        <td width="30%">NOKA BPJS</td>
                                        <td width="70%"><?php echo $anggota->noka_bpjs;?></td>
                                    </tr>
                                    <tr>
                                        <td width="30%">Grade</td>
                                        <td width="70%"><?php echo $anggota->grade_nama; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="30%">Departemen / Unit Kerja</td>
                                        <td width="70%"><?php echo $anggota->departemen_nama; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="30%">Profit Center</td>
                                        <td width="70%"><?php echo $anggota->profit_nama; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="30%">Status</td>
                                        <td width="70%"><?php echo $anggota->status; ?></td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                        <div class="pb-3 col-md-6">
                                <h4>Sub Departemen</h4>
                                <table id="table" class="table table-striped table-bordered no-wrap">
                                    <tbody>
                                        <tr>
                                            <td width="30%">Nama Bank</td>
                                            <td width="70%"><?php echo $anggota->bank_nama; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="30%">Nomor Rekening</td>
                                            <td width="70%"><?php echo $anggota->bank_code; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="30%">Atas Nama</td>
                                            <td width="70%"><?php echo $anggota->bank_norek; ?></td>
                                        </tr>

                                    </tbody>
                                </table>
                                <div class="table-responsive">
                                    <table id="table" class="table table-striped table-bordered no-wrap">
                                        @php
                                            $total_potongan = 0;
                                        @endphp
                                        <tbody>
                                            <tr>
                                                <td width="30%">Plafon</td>
                                                <td width="70%"></td>
                                            </tr>
                                            <tr>
                                                <td width="30%">Gaji</td>
                                                <td width="70%"><?php echo "Rp. " . number_format($anggota->gaji); ?></td>
                                            </tr>
                                            <tr>
                                                <td width="30%">Total Potongan</td>
                                                <td width="70%"><?php echo "Rp. " . number_format($total_potongan); ?></td>
                                            </tr>

                                            <?php
                                            if ($anggota->gaji>0) {
                                                    $persen = $total_potongan/$anggota->gaji*100;
                                                    $warna = "";
                                                    if ($persen>50) {
                                                        $warna = "#FF0000";
                                                    }
                                                    else if ($persen>40) {
                                                        $warna = "#baae06";
                                                    }
                                                    else {
                                                        $warna = "#7c8798";
                                                    }

                                                ?>
                                            <tr>
                                                <td width="30%">Persentase Potongan</td>
                                                <td width="70%">
                                                    <font color="<?php echo $warna; ?>">
                                                        <?php echo number_format($persen,2) . " %"; ?>
                                                    </font>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>

                    </div>
                    <hr>
                    <div class="col-md-12">
                        <h4>Data Simpanan</h4>
                        <table id="table" class="table table-striped table-bordered no-wrap">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Sertifikat</th>
                                    <th>Jenis Simpanan</th>
                                    <th>Saldo</th>
                                    <th>Setoran / bln</th>
                                    <th>Status</th>
                                    <th>Tgl Aktivasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($anggota->simpananAnggota) == 0)
                                    <tr>
                                        <td colspan="7" class="text-center"><i>Data Simpanan Belum Tersedia</i></td>
                                    </tr>
                                @else
                                    @foreach ($anggota->simpananAnggota as $no => $item)
                                        <tr>
                                            <td class="text-center">{{ ($no+1) }}</td>
                                            <td class="text-center">{{ $item->no_rekening }}</td>
                                            <td class="text-center">{{ $item->jenis_pembiayaan }}</td>
                                            <td class="text-right">Rp. {{ number_format($item->saldo_akhir,0,',','.') }}</td>
                                            <td class="text-right">Rp. {{ number_format($item->setoran_per_bln,0,',','.') }}</td>
                                            <td class="text-center">{!! $item->status !!}</td>
                                            <td class="text-center">{!! date('d-m-Y', strtotime($item->created_date)) !!}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <div class="col-md-12">
                        <h4>Data Pembiayaan</h4>
                        <table id="table" class="table table-striped table-bordered no-wrap">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Pembiayaan</th>
                                    <th>Jenis Pembiayaan</th>
                                    <th>Saldo Pokok</th>
                                    <th>Cicilan / bln</th>
                                    <th>Status</th>
                                    <th>Tgl Aktivasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($anggota->pembiayaanAnggota) == 0)
                                    <tr>
                                        <td colspan="7" class="text-center"><i>Data Pembiayaan Belum Tersedia</i></td>
                                    </tr>
                                @else
                                    @foreach ($anggota->pembiayaanAnggota as $no => $item)
                                        <tr>
                                            <td class="text-center">{{ ($no+1) }}</td>
                                            <td class="text-center">{{ $item->no_rekening }}</td>
                                            <td class="text-center">{{ $item->jenis_pembiayaan }}</td>
                                            <td class="text-right">Rp. {{ number_format($item->saldo_akhir_pokok,0,',','.') }}</td>
                                            <td class="text-right">Rp. {{ number_format($item->cicilan,0,',','.') }}</td>
                                            <td class="text-center">{!! $item->status !!}</td>
                                            <td class="text-center">{!! date('d-m-Y', strtotime($item->created_date)) !!}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footscript')
<style>
    .parsley-errors-list li{
        color : red !important;
        font-style: italic;
    }
</style>
@endsection
