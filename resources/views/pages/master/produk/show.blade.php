@extends('layouts.master')

@section('title')
    Detail Data Master Produk
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
                            <h4 class="card-title">Detail Data Produk Simpanan dan Pinjaman</h4>
                            <p class="card-title-desc">Data berasal dari Sumber yang tersimpan dalam database</code>.</p>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('master.produk.index') }}" class="btn btn-info btn-sm"
                                style="float: right;margin-left:5px;"><i class="fa fa-chevron-left"></i> Kembali</a>
                            <a href="{{ route('master.produk.edit', $id) }}" class="btn btn-primary btn-sm"
                                style="float: right;margin-left:5px;"><i class="fa fa-edit"></i> Edit</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('includes.alert')
                    <div class="row">
                        <div class="pb-3 col-md-6">
                            <h4>Info Produk</h4>
                            <table class="table" id="dynamic-form">
                                <tbody>
                                    <tr>
                                        <td>Produk</td>
                                        <td><b>{!! $produk->nama_produk !!}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Tipe Produk</td>
                                        <td><b>{!! $produk->tipe !!}</b></td>
                                    </tr>
                                    @if ($produk->nama_produk != 'SIMPANAN PASTI')
                                        <tr>
                                            <td>Tipe Margin</td>
                                            <td><b>{!! $produk->tipe_margins !!}</b></td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td>Admin Fee</td>
                                        <td><b>Rp. {{ number_format($produk->admin_fee, 0, ',', '.') }}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td><b>{!! $produk->status_produks !!}</b></td>
                                    </tr>
                                    {{-- @if ($produk->nama_produk == 'SIMPANAN PASTI')
                                        <tr>
                                            <td>Asuransi</td>
                                            <td><b>Rp. {!! number_format($produk->asuransi,0,',','.') !!}</b></td>
                                        </tr>    
                                    @endif --}}

                                </tbody>
                            </table>
                        </div>
                        @if (count($produk->margin) != 0)
                            <div class="pb-3 col-md-6">
                                <h4>Margin</h4>
                                <table class="table" id="dynamic-form">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Jangka Waktu</th>
                                            <th>Bunga P.A</th>
                                            <th>Margin Flat</th>
                                            <th>Asuransi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($produk->margin as $item)
                                            <tr id="row{{ $item->id }}">
                                                <td class="text-center">{{ $no }}</td>
                                                <td class="text-center">
                                                    <b>{{ $item->jangka_waktu }}</b>
                                                </td>
                                                <td class="text-center">
                                                    <b>{{ $item->margin }} %</b>
                                                </td>
                                                <td class="text-center">
                                                    <b>{{ number_format(FunctionHelper::bungaEfektif($item->margin / 100, $item->jangka_waktu, 1), 3) }}
                                                        %</b>
                                                </td>
                                                <td class="text-center">
                                                    <b>{{ $item->asuransi }} %</b>
                                                </td>
                                            </tr>
                                            @php
                                                $no++;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif

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
    </style>
@endsection
