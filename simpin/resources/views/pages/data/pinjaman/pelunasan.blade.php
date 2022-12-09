@extends('layouts.master')

@section('title')
Pelunasan Pinjaman
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Pelunasan Pinjaman</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Data</a></li>
                    <li class="breadcrumb-item">Pinjaman</li>
                    <li class="breadcrumb-item active">Pelunasan</li>
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
                        <h4 class="card-title">Pelunasan Pinjaman</h4>
                        <p class="card-title-desc">Form Pelunasan Pinjaman.</code>.</p>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('data.pinjaman.index') }}" class="btn btn-info btn-sm" style="float: right"><i class="fa fa-chevron-left"></i> Kembali</a>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="pb-3 col-md-12">
            <div id="pages-simulasi"></div>
        </div>
        {{-- <hr> --}}
        {{-- <div class="row">
                            <div class="col-sm-12 text-center">
                                <button type="submit" class="btn btn-primary btn-sm w-md"><i class="fa fa-save"></i>
                                    Simpan Data</button>
                            </div>
                        </div> --}}
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
<script type="text/javascript" src="{{ asset('js') }}/financial.js"></script>

<style>
    .parsley-errors-list li {
        color: red !important;
        font-style: italic;
    }

    td,
    th {
        font-size: 10px !important;
        padding: 0.30rem !important;
    }

    .text-right {
        text-align: right !important;
    }
</style>
@endsection