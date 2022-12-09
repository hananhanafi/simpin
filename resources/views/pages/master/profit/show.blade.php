@extends('layouts.master')

@section('title')
    Detail Data Master Profit Center
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Master Data Profit Center</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Master</a></li>
                    <li class="breadcrumb-item">Profit Center</li>
                    <li class="breadcrumb-item active">{{ $profit->profit }}</li>
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
                        <h4 class="card-title">Detail Data Profit Center {{ $profit->profit }}</h4>
                        <p class="card-title-desc">Data berasal dari Sumber yang tersimpan dalam database</code>.</p>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('master.profit.index') }}" class="btn btn-info btn-sm" style="float: right;margin-left:5px;"><i class="fa fa-chevron-left"></i> Kembali</a>
                        <a href="{{ route('master.profit.edit', $id) }}" class="btn btn-primary btn-sm" style="float: right;margin-left:5px;"><i class="fa fa-edit"></i> Edit</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @include('includes.alert')
                    <div class="row">
                        <div class="pb-3 col-md-7">
                            <h4>Info Profit Center</h4>
                            <table class="table" id="dynamic-form">
                                <tbody>
                                    <tr>
                                        <td style="width:200px;">Kode Profit Center</td>
                                        <td><b>{{ $profit->kode }}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Keterangan</td>
                                        <td><b>{!! $profit->desc !!}</b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
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
