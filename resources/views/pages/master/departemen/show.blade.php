@extends('layouts.master')

@section('title')
    Detail Data Master Departemen
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Master Data Departemen</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Master</a></li>
                    <li class="breadcrumb-item">Departemen</li>
                    <li class="breadcrumb-item active">{{ $departemen->departemen }}</li>
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
                        <h4 class="card-title">Detail Data Departemen {{ $departemen->departemen }}</h4>
                        <p class="card-title-desc">Data berasal dari Sumber yang tersimpan dalam database</code>.</p>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('master.departemen.index') }}" class="btn btn-info btn-sm" style="float: right;margin-left:5px;"><i class="fa fa-chevron-left"></i> Kembali</a>
                        <a href="{{ route('master.departemen.edit', $id) }}" class="btn btn-primary btn-sm" style="float: right;margin-left:5px;"><i class="fa fa-edit"></i> Edit</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @include('includes.alert')
                    <div class="row">
                        <div class="pb-3 col-md-6">
                            <h4>Info Departemen</h4>
                            <table class="table" id="dynamic-form">
                                <tbody>
                                    <tr>
                                        <td>Kode Departemen</td>
                                        <td><b>{{ $departemen->kode }}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Departemen</td>
                                        <td><b>{{ $departemen->departemen }}</b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                            <div class="pb-3 col-md-6">
                                <h4>Sub Departemen</h4>
                                <table class="table" id="dynamic-form">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode</th>
                                            <th>Departemen</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($departemen->sub_departemen as $item)
                                            <tr id="row{{ $item->id }}">
                                                <td class="text-center">{{ $no }}</td>
                                                <td class="text-center">
                                                    <b>{{ $item->kode }}</b>
                                                </td>
                                                <td class="text-center">
                                                    <b>{{ $item->departemen }} %</b>
                                                </td>
                                            </tr>
                                            @php
                                                $no++;
                                            @endphp
                                        @endforeach
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
