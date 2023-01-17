<div class="row">
    <div class="col-md-12">
        @if ($alokasi_shu == '')
        <h2>Silahkan Masukan Jumlah Alokasi SHU Terlebih Dahulu</h2>
        @else
        <h4>SIMULASI SHU</h4>
        {{-- <div class="row">
                <div class="col-md-12">Target Dana Pasti <B><u>{{ $bulan }} Bulan</u> Rp. {{ number_format($saldo,0,',','.') }}</B>
    </div>
</div> --}}

<div class="row mb-3">
    <div class="col-md-6">

    </div>
    <div class="col-md-6 text-right">
        {{-- <a href="" class="btn btn-success"><i class="fa fa-download"></i> Unduh Hasil Simulasi</a> --}}
    </div>
</div>


<table class="table table-bordered simulasi mt-5">
    <thead>
        <tr style="">
            <th style="text-align:center">
                Kategori
            </th>
            <th style="text-align:center;width:120px">
                %
            </th>
            <th style="text-align:center">
                Nominal
            </th>
        </tr>
    </thead>
    <tbody>
        @php
        $shu_anggota_persen = $request->shu_anggota_persen !== 'undefined' ? $request->shu_anggota_persen : 80;
        $pengurus_persen = $request->pengurus_persen !== 'undefined' ? $request->pengurus_persen : 4;
        $pengawas_persen = $request->pengawas_persen !== 'undefined' ? $request->pengawas_persen : 1;
        $karyawan_persen = $request->karyawan_persen !== 'undefined' ? $request->karyawan_persen : 8;
        $pendidikan_persen = $request->pendidikan_persen !== 'undefined' ? $request->pendidikan_persen : 7;
        $shu_pengurus_persen = $request->shu_pengurus_persen !== 'undefined' ? $request->shu_pengurus_persen : 20;

        $shu_anggota = $shu_anggota_persen * $alokasi_shu / 100;
        $pengurus = $pengurus_persen * $alokasi_shu / 100;
        $pengawas = $pengawas_persen * $alokasi_shu / 100;
        $karyawan = $karyawan_persen * $alokasi_shu / 100;
        $pendidikan = $pendidikan_persen * $alokasi_shu / 100;
        $shu_pengurus = $shu_pengurus_persen * $alokasi_shu / 100;
        @endphp
        <tr style="background: #ccfff4 !important">
            <th style="background: #ccfff4 !important">SHU Bagian Anggota</th>
            <th style="background: #ccfff4 !important">
                <input type="text" name="shu_anggota_persen" class="form-control" style="width:120px;text-align:center" value="{{ $shu_anggota_persen }}" onkeyup="pageSimulasi()">
            </th>
            <th style="background: #ccfff4 !important">
                <input type="text" name="shu_anggota" class="form-control" readonly value="{{ number_format($shu_anggota,2,',','.') }}">
            </th>
        </tr>
        <tr>
            <td>Pengurus</td>
            <td class="text-center">
                <input type="text" name="ppengurus_persen[pengurus]" id="pengurus_persen" class="form-control persen-anggota" style="width:120px;text-align:center" value="{{ $pengurus_persen }}" onkeyup="pageSimulasi()">
            </td>
            <td class="text-center">
                <input type="text" name="pengurus[pengurus]" class="form-control" readonly value="{{ number_format($pengurus,2,',','.') }}">
            </td>
        </tr>
        <tr>
            <td>Pengawas/Penasihat</td>
            <td class="text-center">
                <input type="text" name="ppengurus_persen[pengawas]" id="pengawas_persen" class="form-control persen-anggota" style="width:120px;text-align:center" value="{{ $pengawas_persen }}" onkeyup="pageSimulasi()">
            </td>
            <td class="text-center">
                <input type="text" name="pengurus[pengawas]" class="form-control" readonly value="{{ number_format($pengawas,2,',','.') }}">
            </td>
        </tr>
        <tr>
            <td>Karyawan Koperasi</td>
            <td class="text-center">
                <input type="text" name="ppengurus_persen[karyawan]" id="karyawan_persen" class="form-control persen-anggota" style="width:120px;text-align:center" value="{{ $karyawan_persen }}" onkeyup="pageSimulasi()">
            </td>
            <td class="text-center">
                <input type="text" name="pengurus[karyawan]" class="form-control" readonly value="{{ number_format($karyawan,2,',','.') }}">
            </td>
        </tr>
        <tr>
            <td>Pendidikan</td>
            <td class="text-center">
                <input type="text" name="ppengurus_persen[pendidikan]" id="pendidikan_persen" class="form-control persen-anggota" style="width:120px;text-align:center" value="{{ $pendidikan_persen }}" onkeyup="pageSimulasi()">
            </td>
            <td class="text-center">
                <input type="text" name="pengurus[pendidikan]" class="form-control" readonly value="{{ number_format($pendidikan,2,',','.') }}">
            </td>
        </tr>
        <tr style="background: #ccfff4">
            <th>SHU Bagian Pengurus</th>
            <th class="text-center">
                <input type="text" name="shu_pengurus_persen" class="form-control total-persen-anggota" style="width:120px;text-align:center" value="{{ $shu_pengurus_persen }}" onkeyup="pageSimulasi()">
            </th>
            <th class="text-center">
                <input type="text" name="shu_pengurus" class="form-control" readonly value="{{ number_format($shu_pengurus,2,',','.') }}">
            </th>
        </tr>
    </tbody>
</table>
@endif
</div>
</div>