<div class="row">
    <div class="col-md-12">
        @if ($anggota == null)
        <h2>Silahkan Pilih Anggota Terlebih Dahulu</h2>
        @elseif ($request->gaji == '' || $request->gaji == null)
        <h2>Silahkan Isi Gaji Pokok Terlebih Dahulu</h2>
        @else
        <h3>PLAFON SIMPANAN</h3>

        <div class="row">
            <div class="col-12">
                <table class="table" style="border-collapse: collapse;width:100%">
                    <tbody>
                        <tr>
                            <td style="width:40%;padding-bottom:0.5rem;width: 100%">Nama</td>
                            <td>:</td>
                            <td style="width:60%;padding-bottom:0.5rem;width: 100%">{{ $anggota->nama }}</td>
                            <td style="width: 100%"></td>
                            <td style="width:40%;padding-bottom:0.5rem;width: 100%">Gaji Pokok</td>
                            <td>:</td>
                            <td style="width:60%;padding-bottom:0.5rem;width: 100%">Rp.
                                {{ number_format($request->gaji, 0, ',', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <td style="width:40%;padding-bottom:0.5rem;width: 100%">NIK</td>
                            <td>:</td>
                            <td style="width:60%;padding-bottom:0.5rem;width: 100%">{{ $anggota->no_anggota }}</td>
                            <td style="width: 100%"></td>
                            <td style="width:40%;padding-bottom:0.5rem;width: 100%">40% Gaji Pokok</td>
                            <td>:</td>
                            <td style="width:60%;padding-bottom:0.5rem;width: 100%">Rp.
                                {{ number_format($gaji40, 0, ',', '.') }}
                                {{-- {{ $request->gaji * 40 }} --}}
                            </td>
                        </tr>
                        <tr>
                            <td style="width:40%;padding-bottom:0.5rem;width: 100%">Masa Kerja</td>
                            <td>:</td>
                            <td style="width:60%;padding-bottom:0.5rem;width: 100%">{{ $request->masa }} + 1 Tahun</td>
                            <td style="width: 100%"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td style="width:40%;padding-bottom:0.5rem;width: 100%">Usia</td>
                            <td>:</td>
                            <td style="width:60%;padding-bottom:0.5rem;width: 100%">{{ $anggota->age }} Tahun</td>
                            <td style="width: 100%"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            {{-- <div class="col-md-4">
                <table class="table" style="border-collapse: collapse">
                    <tbody>
                        <tr>
                            <td style="width:40%;padding-bottom:0.5rem;width: 100%border:1px solid black;">Gaji Pokok</td>
                            <td style="width:60%;padding-bottom:0.5rem;width: 100%border:1px solid black;">Rp.
                                {{ number_format($request->gaji, 0, ',', '.') }}
            </td>
            </tr>
            <tr>
                <td style="width:40%;padding-bottom:0.5rem;width: 100%border:1px solid black;">40% Gaji Pokok</td>
                <td style="width:60%;padding-bottom:0.5rem;width: 100%border:1px solid black;">Rp.
                    {{ number_format($gaji40, 0, ',', '.') }}
                </td>
            </tr>
            </tbody>
            </table>
        </div> --}}
    </div>

    <hr>
    <h4>ANGSURAN YANG SUDAH ADA</h4>
    <div class="row">
        <div class="col-12">
            <table class="table" style="border-collapse: collapse;width:100%">
                {{-- <thead>
                        <tr>
                            <th style="border-bottom: 1px solid black">Produk</th>
                            <th style="border-bottom: 1px solid black">Jumlah</th>
                            <th style="border-bottom: 1px solid black">Masa</th>
                            <th style="border-bottom: 1px solid black">Angsuran</th>
                            <th style="border-bottom: 1px solid black">Periode Awal</th>
                        </tr>
                    </thead> --}}
                <tbody>
                    <tr>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem">Produk</td>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem">Jumlah</td>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem">Masa</td>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem">Angsuran</td>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem">Periode Awal</td>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem">Periode Akhir</td>
                    </tr>
                    @php
                    $totalPinjaman = 0;
                    $ntotalAngsuran = 0;
                    $totalAngsuran = 0;
                    @endphp
                    @foreach ($pinjaman as $pinjam)
                    @php
                    $pnj = $pinjam->jml_pinjaman;
                    $angs = $pinjam->detail[0]->total_angsuran;
                    @endphp
                    <tr>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem">{{ $pinjam->namaproduks }}</td>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem">Rp. {{ number_format($pnj, 0, ',', '.') }}</td>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem">{{ $pinjam->jangka_waktu ?? '-' }} bulan</td>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem">Rp.
                            {{ number_format($angs ?? '0', 0, ',', '.') }}
                        </td>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem">
                            {{ date('M-Y', strtotime($pinjam->tanggal_mulai)) ?? '-' }}
                        </td>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem">
                            {{ date('M-Y', strtotime($pinjam->tanggal_akhir)) ?? '-' }}
                        </td>
                    </tr>
                    @php
                    $totalPinjaman += $pnj;
                    $totalAngsuran += $angs;
                    @endphp
                    @endforeach

                    @foreach ($simpanan as $sim)
                    @php
                    $pnj = $sim->saldo_akhir;
                    if($sim->produk_id == 3){
                    if(count($sim->detail) > 0){
                    $angs = $sim->detail[0]->saldo;
                    }else {
                    $angs = 0;
                    }
                    }else {
                    if(count($sim->detailsimpas) > 0){
                    $angs = $sim->detailsimpas[0]->tabungan_per_bulan;
                    }else {
                    $angs = 0;
                    }
                    }
                    @endphp
                    <tr>
                        <td>{{ $sim->jenis_simpanan }}</td>
                        <td>Rp. {{ number_format($pnj, 0, ',', '.') }}</td>
                        <td>{{ $sim->jangka_waktu ?? '-' }} bulan</td>
                        <td>Rp.
                            {{ number_format($angs ?? '0', 0, ',', '.') }}
                        </td>
                        <td>
                            {{ date('M-Y', strtotime($sim->created_date)) ?? '-' }}
                        </td>
                        <td>
                            {{ $sim->tgl_jatuh_tempo }}
                        </td>
                    </tr>
                    @php
                    $totalPinjaman += $pnj;
                    $totalAngsuran += $angs;
                    @endphp
                    @endforeach

                    <tr>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem"><strong>T O T A L</strong></td>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem"><strong>Rp. {{ number_format($totalPinjaman, 0, ',', '.') }}</strong></td>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem"></td>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem"><strong>Rp. {{ number_format($totalAngsuran, 0, ',', '.') }}</strong></td>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem"></td>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem"></td>
                    </tr>
                </tbody>

            </table>
        </div>
    </div>

    {{-- <hr> --}}
    <h4>SIMPANAN BARU</h4>
    <div class="row">
        <div class="col-12">
            <table class="table" style="border-collapse: collapse;width:100%">
                {{-- <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Masa</th>
                            <th>Angsuran</th>
                        </tr>
                    </thead> --}}
                @php
                $pinj_baru = $request->jml_pengajuan_baru;
                $bulan_baru = $request->bulan;
                // $angsuran_baru = $request->angsuran;
                @endphp
                <tbody>
                    <tr>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem">Produk</td>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem">Jumlah</td>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem">Masa</td>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem">Angsuran</td>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem">Periode Awal</td>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem">Periode Akhir</td>
                    </tr>
                    <tr>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem">SIMPANAN PASTI</td>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem">Rp. {{ $pinj_baru ?? 0 }}</td>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem">{{ $bulan_baru ?? 0 }} bulan</td>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem">Rp. {{ number_format($angsuran, 0, ',', '.') }} </td>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem">{{ $rangeBulan[1]['bulan'] ?? '' }}</td>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem">{{ $rangeBulan[$bulan_baru ?? 1]['bulan'] ?? '' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- <hr> --}}
    <h4>ANGSURAN SETELAH PERMOHONAN</h4>
    <div class="row">
        <div class="col-12">
            <table class="table" style="border-collapse: collapse;width:100%">
                {{-- <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Masa</th>
                            <th>Angsuran</th>
                            <th>Periode Awal</th>
                        </tr>
                    </thead> --}}
                <tbody>
                    <tr>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem">Produk</td>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem">Jumlah</td>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem">Masa</td>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem">Angsuran</td>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem">Periode Awal</td>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem">Periode Akhir</td>
                    </tr>
                    @php
                    $ntotalAngsuran = 0;
                    @endphp
                    @foreach ($pinjaman as $p)
                    @php
                    $pinjaman = $p->jml_pinjaman;
                    $angs = $p->detail[0]->total_angsuran;
                    $ntotalAngsuran += $angs;
                    @endphp
                    <tr>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem">{{ $p->namaproduks }}</td>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem">Rp. {{ number_format($pinjaman, 0, ',', '.') }}</td>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem">{{ $p->jangka_waktu }} bulan</td>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem">Rp.
                            {{ number_format($angs, 0, ',', '.') }}
                        </td>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem">
                            {{ date('M-Y', strtotime($p->tanggal_mulai)) }}
                        </td>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem">
                            {{ date('M-Y', strtotime($p->tanggal_akhir)) }}
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem">SIMPANAN PASTI</td>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem">Rp. {{ $pinj_baru ?? 0 }}</td>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem">{{ $bulan_baru ?? 0 }} bulan</td>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem">Rp. {{ number_format($angsuran, 0, ',', '.') }}</td>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem">{{ $rangeBulan[1]['bulan'] ?? '' }}</td>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem">{{ $rangeBulan[$bulan_baru ?? 1]['bulan'] ?? '' }}</td>
                    </tr>
                </tbody>
                <tfoot>
                    @php
                    $totalPinjaman += $jml_baru;
                    $ntotalAngsuran += $angsuran;
                    @endphp
                    <tr>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem"><strong>T O T A L</strong></td>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem"><strong>Rp. {{ number_format($totalPinjaman, 0, ',', '.') }}</strong></td>
                        {{-- <td style="border-bottom: .2px solid black;padding-bottom:.5rem"><strong>Rp. {{ $angsuran }}</strong></td> --}}
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem"></td>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem"><strong>Rp. {{ number_format($ntotalAngsuran, 0, ',', '.') }}</strong></td>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem"></td>
                        <td style="border-bottom: .2px solid black;padding-bottom:.5rem"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- <hr> --}}
    <div class="row">
        <div class="col-12">
            <table class="table" style="border-collapse: collapse;width:100%">
                @php
                $persen = ceil(($ntotalAngsuran / $request->gaji) * 100);
                @endphp
                <tbody>
                    <tr>
                        <td colspan="3">
                            <h4>PRESENTASE DARI GAJI</h4>
                        </td>
                        <td>
                            <h4>{{ number_format($persen, 2) }}%
                                {{-- {!! $ntotalAngsuran < $totalAngsuran
                                            ? '<span class="text-success">DISETUJUI</span>'
                                            : '<span class="text-danger">DITOLAK</span>' !!} --}}
                            </h4>
                            {{-- @if ($ntotalAngsuran < $totalAngsuran)
                                        <p class="text-success">DISETUJUI</p>
                                    @endif --}}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


    {{-- --}}
    @endif
</div>
</div>