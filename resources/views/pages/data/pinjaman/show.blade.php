@extends('layouts.master')

@section('title')
Info Pinjaman Anggota
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18"> Data Pinjaman</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Data</a></li>
                    <li class="breadcrumb-item">Pinjaman</li>
                    <li class="breadcrumb-item active">Info</li>
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
                        <h4 class="card-title">Detail Info Pinjaman</h4>
                        <p class="card-title-desc">Data berasal dari Sumber yang tersimpan dalam database</code>.</p>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('data.pinjaman.index') }}" class="btn btn-info btn-sm" style="float: right;margin-left:5px;"><i class="fa fa-chevron-left"></i> Kembali</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @include('includes.alert')
                <div class="row">
                    <div class="pb-3 col-md-6">
                        <table id="table" class="table table-striped table-bordered no-wrap">
                            <tbody>
                                <tr>
                                    <td width="40%">No Anggota</td>
                                    <td width="60%"><?php echo $anggota->no_anggota; ?></td>
                                </tr>
                                <tr>
                                    <td width="40%">Nama Anggota</td>
                                    <td width="60%"><?php echo $anggota->nama; ?></td>
                                </tr>
                                <tr>
                                    <td width="40%">Grade</td>
                                    <td width="60%"><?php echo ($anggota->grade_name); ?></td>
                                </tr>
                                <tr>
                                    <td width="40%">Departemen/Unit Kerja</td>
                                    <td width="60%"><?php echo ($anggota->lokasi_kerja); ?></td>
                                </tr>
                                <tr>
                                    <td width="40%">Profit Center</td>
                                    <td width="60%"><?php echo ($anggota->departemen); ?></td>
                                </tr>
                                <tr>
                                    <td width="40%">Status Anggota</td>
                                    <td width="60%"><?php echo ($anggota->status); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="pb-3 col-md-6">
                        <table id="table" class="table table-striped table-bordered no-wrap">
                            <tbody>
                                <tr>
                                    <td width="40%">Plafon</td>
                                    <td width="60%"></td>
                                </tr>
                                <tr>
                                    <td width="40%">Gaji</td>
                                    <td width="60%">Rp. <?php echo ($anggota->gaji); ?></td>
                                </tr>
                                <tr>
                                    <td width="40%">Total Potongan</td>
                                    <td width="60%">Rp. <?php echo ($total_potongan); ?></td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                    <div class="pb-3 col-md-12 table-responsive">
                        <h4>Data Pinjaman</h4>
                        <table id="table" class="table table-striped table-bordered no-wrap">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Pinjaman</th>
                                    <th>Jenis Pinjaman</th>
                                    <th>Sisa Hutang</th>
                                    <th>Cicilan/Bln</th>
                                    <th>Status</th>
                                    <th>Tgl Aktivasi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $saldo = $cicilan = 0;
                                @endphp
                                @foreach ($pinjaman as $no => $item)
                                <tr>
                                    {{-- <?php dd($pinjaman); ?> --}}
                                    <td>{{ ($no+1) }}</td>
                                    <td>{{ $item->no_rekening }}</td>
                                    <td>{{ $item->kode }} - {{ $item->nama_produk }}</td>
                                    <td class="text-center">Rp.{{ number_format($item->sisa_hutangs,0,',','.') }}</td>
                                    <td class="text-center">Rp.{{ number_format($item->detail[0]->total_angsuran,0,',','.') }}</td>
                                    <td class="text-center">{!! $item->xstatus !!}</td>
                                    @if ($item->status_rekening == 0)
                                    <td></td>
                                    @else
                                    <td class="text-center">{{ date('d-m-Y',strtotime($item->created_date)) }}</td>
                                    @endif

                                    <td class="text-center">
                                        <a href="{{ route('data.pinjaman.mutasi',['no_rekening'=>$item->no_rekening]) }}" class="btn btn-warning btn-circle edit_anggota"><i class="fa fa-info"></i></a>
                                    </td>
                                </tr>
                                @php
                                $saldo += $item->sisa_hutangs;
                                $cicilan += $item->cicilan;
                                @endphp
                                @endforeach
                                <tr>
                                    <td colspan="3" class="text-center">JUMLAH</td>
                                    <td class="text-center">Rp.{{ number_format($saldo,0,',','.') }}</td>
                                    <td class="text-center">Rp.{{ number_format($cicilan,0,',','.') }}</td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                </tr>
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
        .parsley-errors-list li {
            color: red !important;
            font-style: italic;
        }

        .text-right {
            text-align: right;
        }
    </style>
    @endsection