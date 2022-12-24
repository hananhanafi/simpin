@extends('layouts.master')

@section('title')
Info Pencairan Pinjaman
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18"> Data Pencairan</h4>

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
                        <a href="{{ route('data.pinjaman.pencairan') }}" class="btn btn-info btn-sm" style="float: right;margin-left:5px;"><i class="fa fa-chevron-left"></i> Kembali</a>
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
                                <tr>
                                    <td width="40%">Total Pinjaman</td>
                                    <td width="60%"><?php echo (number_format($anggota->total_pinjaman, '0', ',', '.')); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="pb-3 col-md-6">
                        <table id="table" class="table table-striped table-bordered no-wrap">
                            <tbody>
                                <tr>
                                    <td width="40%">Pengajuan Pinjaman</td>
                                    <td width="60%">
                                        <input type="hidden" name="jml_pinjaman" id="jml_pinjaman" value="{{ number_format($pinjamanDetail->jml_pinjaman, '0', ',', '.') }}">
                                        Rp. <?php echo (number_format($pinjamanDetail->jml_pinjaman, '0', ',', '.')); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="40%">Biaya Administrasi</td>
                                    <td width="60%">
                                        Rp. <?php echo (number_format($pinjamanDetail->admin_fee, '0', ',', '.')); ?>
                                        {{--<div style="display: flex;width:100%; align-items:center">
                                            <span style="margin-right: 8px">Rp. </span><input type="text" name="admin_fee" class="form-control" id="admin_fee" placeholder="Biaya Administrasi" required data-parsley-required-message="Biaya Administrasi harus diisi" value="{{ number_format($pinjamanDetail->admin_fee, '0', ',', '.') }}">
                    </div>--}}
                    </td>
                    </tr>
                    <tr>
                        <td width="40%">Biaya Asuransi</td>
                        <td width="60%">
                            Rp. <?php echo (number_format($pinjamanDetail->asuransi, '0', ',', '.')); ?>
                            {{--<div style="display: flex;width:100%; align-items:center">
                                            <span style="margin-right: 8px">Rp. </span><input type="text" name="asuransi" class="form-control" id="asuransi" placeholder="Biaya Administrasi" required data-parsley-required-message="Biaya Administrasi harus diisi" value="{{ number_format($pinjamanDetail->asuransi, '0', ',', '.') }}">
                </div> --}}
                {{-- <input type='text' value='Rp. <?php echo (number_format($pinjamanDetail->asuransi, '0', ',', '.')); ?>' />  --}}
                </td>
                </tr>
                <tr>
                    <td width="40%">Pelunasan Hutang</td>
                    <td width="60%">Rp. <?php echo (number_format($pinjamanDetail->nilai_pelunasan, '0', ',', '.')); ?></td>
                </tr>
                <tr>
                    <td width="40%">Dana Mengendap</td>
                    <td width="60%">
                        <input type="hidden" name="dana_mengendap" id="dana_mengendap" value="{{ number_format($pinjamanDetail->dana_mengendap, '0', ',', '.') }}">
                        Rp. <?php echo (number_format($pinjamanDetail->dana_mengendap, '0', ',', '.')); ?>
                    </td>
                </tr>
                <tr>
                    <td width="40%">Jumlah Pencairan</td>
                    <td width="60%">
                        Rp. <span id="nilai_pencairan_label"><?php echo (number_format($pinjamanDetail->nilai_pencairan, '0', ',', '.')); ?></span>
                    </td>
                </tr>
                </tbody>
                </table>
            </div>
            <div class="pb-3 col-md-12 table-responsive">
                <h4>Data Pinjaman</h4>
                <table id="table" class="table table-striped table-bordered no-wrap">
                    <thead>
                        <tr>
                            {{-- <th>No</th> --}}
                            <th class="text-center">No Pinjaman</th>
                            <th class="text-center">Jenis Pinjaman</th>
                            <th class="text-center">Sisa Pinjaman</th>
                            <th class="text-center">Cicilan/Bln</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Tgl Aktivasi</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @php
                                $saldo = $cicilan = 0;
                                @endphp
                                @foreach ($pinjaman as $no => $item) --}}
                        <tr>
                            {{-- <td>{{ ($no+1) }}</td> --}}
                            <td class="text-center">{{ $pinjamanDetail->no_rekening }}</td>
                            <td class="text-center">{{ $pinjamanDetail->kode }} - {{ $pinjamanDetail->nama_produk }}</td>
                            <td class="text-center">Rp.{{ number_format($pinjamanDetail->sisa_hutangs,0,',','.') }}</td>
                            <td class="text-center"">Rp.{{ number_format($pinjamanDetail->detail[0]->total_angsuran,0,',','.') }}</td>
                            <td class=" text-center">{!! $pinjamanDetail->xstatus !!}</td>
                            @if ($pinjamanDetail->status_rekening == 0)
                            <td></td>
                            @else
                            <td class="text-center">{{ date('d-m-Y',strtotime($pinjamanDetail->created_date)) }}</td>
                            @endif

                            <td class="text-center">
                                {{-- <a href="{{ route('data.pinjaman.mutasi',['no_rekening'=>$pinjamanDetail->no_rekening]) }}" class="btn btn-warning btn-circle edit_anggota"><i class="fa fa-info"></i></a> --}}
                                <button type="button" class="btn btn-primary btn-sm" onclick="cairkan(<?php echo $pinjamanDetail->id; ?>,<?php echo $pinjamanDetail->status_rekening; ?>)">Cairkan</button>
                            </td>
                        </tr>
                        {{-- @php
                                $saldo += $item->sisa_hutangs;
                                $cicilan += $item->cicilan;
                                @endphp
                                @endforeach --}}
                        {{-- <tr>
                                    <td colspan="3" class="text-right">JUMLAH</td>
                                    <td class="text-right">Rp.{{ number_format($saldo,0,',','.') }}</td>
                        <td class="text-right">Rp.{{ number_format($cicilan,0,',','.') }}</td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        </tr> --}}
                    </tbody>
                </table>

            </div>

        </div>
    </div>
</div>
</div>

<form id="aproval-form" method="post">
    @csrf
    <input type="hidden" name="id_pinjaman">
</form>
<form id="update-form" action="{{ route('data.pencairan.updateJumlahPencairan') }}" method="post">
    @csrf
    <input type="hidden" name="id" value="{{$pinjamanDetail->id}}">
    <input type="hidden" name="asuransi_new">
    <input type="hidden" name="admin_fee_new">
    <input type="hidden" name="dana_mengendap_new">
    <input type="hidden" name="nilai_pencairan_new">
</form>
{{-- <form id="cairkan-form-<?php echo $item->id; ?>" action="{{ route('data.pencairan.approve') }}" method="POST" class="d-none">
@csrf
<input type="hidden" name="id_pinjaman" value="{{ $anggota->id }}">
</form> --}}
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

<link rel="stylesheet" href="{{ asset('assets') }}/sweetalert/sweetalert.css">
<script type="text/javascript" charset="utf8" src="{{ asset('assets') }}/sweetalert/sweetalert.min.js"></script>
<script src="{{ asset('assets') }}/libs/jquery/jquery.min.js"></script>
<script type="text/javascript" src="{{ asset('js') }}/parsley.min.js"></script>
<script type="text/javascript" src="{{ asset('js') }}/currency.js"></script>
<script type="text/javascript" src="{{ asset('js') }}/financial.js"></script>
<script>
    var isUpdated = false;
    $(document).ready(function() {
        $('#asuransi,#admin_fee').on({
            keyup: function() {
                let input_val = $(this).val();
                input_val = numberToCurrency(input_val);
                $(this).val(input_val);
                isUpdated = true;
                updateJumlahPencairan();
            },
            blur: function() {
                let input_val = $(this).val();
                input_val = numberToCurrency(input_val, true, true);
                $(this).val(input_val);
            },
            change: function() {
                let input_val = $(this).val();
                input_val = numberToCurrency(input_val, true, true);
                $(this).val(input_val);
            },
        });

        function updateJumlahPencairan() {
            const admin_fee_new = parseInt($('#admin_fee').val().replaceAll('.', ''));
            const asuransi_new = parseInt($('#asuransi').val().replaceAll('.', ''));

            const dana_mengendap = parseInt($('#dana_mengendap').val().replaceAll('.', ''));
            const jml_pinjaman = parseInt($('#jml_pinjaman').val().replaceAll('.', ''));

            $("input[name='admin_fee_new']").val(admin_fee_new);
            $("input[name='asuransi_new']").val(asuransi_new);
            $("input[name='dana_mengendap_new']").val(dana_mengendap);
            nilai_pencairan_new = jml_pinjaman - (admin_fee_new + asuransi_new + dana_mengendap)

            $("input[name='nilai_pencairan']").val(nilai_pencairan_new);
            $("input[name='nilai_pencairan_new']").val(nilai_pencairan_new);
            $('#nilai_pencairan_label').text(numberToCurrency(nilai_pencairan_new))

        }

    });

    function updateJumlahPencairanPost() {

        if ($("input[name='nilai_pencairan_new']").val() < 0) {
            alert('Jumlah pencairan tidak boleh minus atau kurang dari 0')
            return;
        }
        if (isUpdated) {
            $('#update-form').submit();
        } else {
            alert("Silahkan perbarui biaya administrasi atau asuransi terlebih dahulu")
        }
    }

    function cairkan(id, status) {
        if (status == 1) {
            var url = "{{ route('data.pencairan.approve') }}";
            $('#aproval-form').attr('action', url);
            $("input[name='id_pinjaman']").val(id);
            swal({
                    title: "Apakah Anda Yakin !",
                    text: "Ingin Mencairkan Pinjaman Ini ?.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#802d34",
                    confirmButtonText: "Iya",
                    cancelButtonText: "Cancel",
                    closeOnConfirm: false,
                    closeOnCancel: true
                },
                function(isConfirm) {
                    if (isConfirm) {
                        $('#aproval-form').submit();
                    }
                });
        } else {
            alert("Pinjaman sudah dicairkan")
        }
    };
</script>