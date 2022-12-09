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
        $shu_pengurus_persen = $request->shu_pengurus_persen !== 'undefined' ? $request->shu_pengurus_persen : 20;
        $pengurus_persen = $request->pengurus_persen !== 'undefined' ? $request->pengurus_persen : 4;
        $pengawas_persen = $request->pengawas_persen !== 'undefined' ? $request->pengawas_persen : 1;
        $karyawan_persen = $request->karyawan_persen !== 'undefined' ? $request->karyawan_persen : 8;
        $pendidikan_persen = $request->pendidikan_persen !== 'undefined' ? $request->pendidikan_persen : 7;

        $shu_anggota_persen = $request->shu_anggota_persen !== 'undefined' ? $request->shu_anggota_persen : 80;
        $anggota_usipa = $request->anggota_usipa !== 'undefined' ? $request->anggota_usipa : 49;
        $anggota_angkutan = $request->anggota_angkutan !== 'undefined' ? $request->anggota_angkutan : 18;
        $anggota_s_toko = $request->anggota_s_toko !== 'undefined' ? $request->anggota_s_toko : 9;
        $anggota_toko = $request->anggota_toko !== 'undefined' ? $request->anggota_toko : 3;
        $anggota_rat_simpan = $request->anggota_rat_simpan !== 'undefined' ? $request->anggota_rat_simpan : 21;

        $pengurus = ($pengurus_persen * $alokasi_shu) / 100;
        $pengawas = ($pengawas_persen * $alokasi_shu) / 100;
        $karyawan = ($karyawan_persen * $alokasi_shu) / 100;
        $pendidikan = ($pendidikan_persen * $alokasi_shu) / 100;
        $shu_pengurus = ($shu_pengurus_persen * $alokasi_shu) / 100;

        $shu_anggota = ($shu_anggota_persen * $alokasi_shu) / 100;
        $usipa = ($anggota_usipa * $shu_anggota) / 100;
        $angkutan = ($anggota_angkutan * $shu_anggota) / 100;
        $s_toko = ($anggota_s_toko * $shu_anggota) / 100;
        $toko = ($anggota_toko * $shu_anggota) / 100;
        $rat_simpan = ($anggota_rat_simpan * $shu_anggota) / 100;

        @endphp
        {{-- PENGURUS --}}
        <tr style="background: #ccfff4">
            <th>SHU Bagian Pengurus</th>
            <th class="text-center">
                <input type="text" name="shu_pengurus_persen" class="form-control total-persen-anggota" style="width:120px;text-align:center" value="{{ $shu_pengurus_persen }}" onkeyup="pageSimulasi()">
            </th>
            <th class="text-center">
                <input type="text" name="shu_pengurus" class="form-control" readonly value="{{ number_format($shu_pengurus, 0, ',', '.') }}">
            </th>
        </tr>
        <tr>
            <td>Pengurus</td>
            <td class="text-center">
                <input type="text" name="ppengurus_persen[pengurus]" id="pengurus_persen" class="form-control persen-anggota" style="width:120px;text-align:center" value="{{ $pengurus_persen }}" onkeyup="pageSimulasi()">
            </td>
            <td class="text-center">
                <input type="text" name="pengurus[pengurus]" class="form-control" readonly value="{{ number_format($pengurus, 0, ',', '.') }}">
            </td>
        </tr>
        <tr>
            <td>Pengawas/Penasihat</td>
            <td class="text-center">
                <input type="text" name="ppengurus_persen[pengawas]" id="pengawas_persen" class="form-control persen-anggota" style="width:120px;text-align:center" value="{{ $pengawas_persen }}" onkeyup="pageSimulasi()">
            </td>
            <td class="text-center">
                <input type="text" name="pengurus[pengawas]" class="form-control" readonly value="{{ number_format($pengawas, 0, ',', '.') }}">
            </td>
        </tr>
        <tr>
            <td>Karyawan Koperasi</td>
            <td class="text-center">
                <input type="text" name="ppengurus_persen[karyawan]" id="karyawan_persen" class="form-control persen-anggota" style="width:120px;text-align:center" value="{{ $karyawan_persen }}" onkeyup="pageSimulasi()">
            </td>
            <td class="text-center">
                <input type="text" name="pengurus[karyawan]" class="form-control" readonly value="{{ number_format($karyawan, 0, ',', '.') }}">
            </td>
        </tr>
        <tr>
            <td>Pendidikan</td>
            <td class="text-center">
                <input type="text" name="ppengurus_persen[pendidikan]" id="pendidikan_persen" class="form-control persen-anggota" style="width:120px;text-align:center" value="{{ $pendidikan_persen }}" onkeyup="pageSimulasi()">
            </td>
            <td class="text-center">
                <input type="text" name="pengurus[pendidikan]" class="form-control" readonly value="{{ number_format($pendidikan, 0, ',', '.') }}">
            </td>
        </tr>

        <tr>
            <td colspan="3" style="height:50px"></td>
        </tr>

        {{-- ANGGOTA --}}
        <tr style="background: #ccfff4 !important">
            <th style="background: #ccfff4 !important">SHU Bagian Anggota</th>
            <th style="background: #ccfff4 !important">
                <input type="text" name="shu_anggota_persen" class="form-control" style="width:120px;text-align:center" value="{{ $shu_anggota_persen }}" onkeyup="pageSimulasi()">
            </th>
            <th style="background: #ccfff4 !important">
                <input type="text" name="shu_anggota" class="form-control" readonly value="{{ number_format($shu_anggota, 0, ',', '.') }}">
            </th>
        </tr>
        <tr>
            <td colspan="3">Alokasi SHU untuk anggota berdasarkan produk:</td>
        </tr>
        <tr>
            <td>Usipa (Pinjaman) </td>
            <td class="text-center">
                <input type="text" name="panggota[usipa]" id="anggota_usipa" class="form-control persen-anggota" style="width:120px;text-align:center" value="{{ $anggota_usipa }}" onkeyup="pageSimulasi()">
            </td>
            <td class="text-center">
                <input type="text" name="anggota[usipa]" class="form-control" readonly value="{{ number_format($usipa, 0, ',', '.') }}">
            </td>
        </tr>
        <tr>
            <td>Angkutan (Simpanan) </td>
            <td class="text-center">
                <input type="text" name="panggota[angkutan]" id="anggota_angkutan" class="form-control persen-anggota" style="width:120px;text-align:center" value="{{ $anggota_angkutan }}" onkeyup="pageSimulasi()">
            </td>
            <td class="text-center">
                <input type="text" name="anggota[angkutan]" class="form-control" readonly value="{{ number_format($angkutan, 0, ',', '.') }}">
            </td>
        </tr>
        <tr>
            <td>Selain Toko </td>
            <td class="text-center">
                <input type="text" name="panggota[s_toko]" id="anggota_s_toko" class="form-control persen-anggota" style="width:120px;text-align:center" value="{{ $anggota_s_toko }}" onkeyup="pageSimulasi()">
            </td>
            <td class="text-center">
                <input type="text" name="anggota[s_toko]" class="form-control" readonly value="{{ number_format($s_toko, 0, ',', '.') }}">
            </td>
        </tr>
        <tr>
            <td>Toko </td>
            <td class="text-center">
                <input type="text" name="panggota[toko]" id="anggota_toko" class="form-control persen-anggota" style="width:120px;text-align:center" value="{{ $anggota_toko }}" onkeyup="pageSimulasi()">
            </td>
            <td class="text-center">
                <input type="text" name="anggota[toko]" class="form-control" readonly value="{{ number_format($toko, 0, ',', '.') }}">
            </td>
        </tr>
        <tr>
            <td>Ratio Simpanan </td>
            <td class="text-center">
                <input type="text" name="panggota[rat_simpan]" id="anggota_rat_simpan" class="form-control persen-anggota" style="width:120px;text-align:center" value="{{ $anggota_rat_simpan }}" onkeyup="pageSimulasi()">
            </td>
            <td class="text-center">
                <input type="text" name="anggota[rat_simpan]" class="form-control" readonly value="{{ number_format($rat_simpan, 0, ',', '.') }}">
            </td>
        </tr>
    </tbody>
</table>
@endif
</div>
</div>