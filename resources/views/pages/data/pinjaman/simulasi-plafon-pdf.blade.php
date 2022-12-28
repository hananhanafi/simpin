<div class="row">
    <div class="col-md-12">
        @if ($anggota == null)
        <h2>Silahkan Pilih Anggota Terlebih Dahulu</h2>
        @elseif ($request->gaji == '' || $request->gaji == null)
        <h2>Silahkan Isi Gaji Pokok Terlebih Dahulu</h2>
        @else
        <h4>PLAFON PINJAMAN</h4>

        <div class="row">
            <div class="col-md-5">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th style="width:40%;padding:0.2rem;">Nama</th>
                            <th style="width:60%;padding:0.2rem;">{{ $anggota->nama }}</th>
                        </tr>
                        <tr>
                            <th style="width:40%;padding:0.2rem;">NIK</th>
                            <th style="width:60%;padding:0.2rem;">{{ $anggota->nik }}</th>
                        </tr>
                        <tr>
                            <th style="width:40%;padding:0.2rem;">Masa Kerja</th>
                            <th style="width:60%;padding:0.2rem;">{{ $request->masa }} + 1 Tahun</th>
                        </tr>
                        <tr>
                            <th style="width:40%;padding:0.2rem;">Usia</th>
                            <th style="width:60%;padding:0.2rem;">{{ $anggota->age }} Tahun</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="col-md-4">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th style="width:40%;padding:0.2rem;">Gaji Pokok</th>
                            <th style="width:60%;padding:0.2rem;">Rp.
                                {{ number_format($request->gaji, 0, ',', '.') }}
                            </th>
                        </tr>
                        <tr>
                            <th style="width:40%;padding:0.2rem;">40% Gaji Pokok</th>
                            <th style="width:60%;padding:0.2rem;">Rp.
                                {{ number_format($gaji40, 0, ',', '.') }}
                                {{-- {{ $request->gaji * 40 }} --}}
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

        <hr>
        <h6>ANGSURAN YANG SUDAH ADA</h6>
        <div class="row">
            <div class="col-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Masa</th>
                            <th>Angsuran</th>
                            <th>Tanggal Mulai</th>
                        </tr>
                    </thead>
                    <tbody>
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
                            <td>{{ $pinjam->namaproduks }}</td>
                            <td>Rp. {{ number_format($pnj, 0, ',', '.') }}</td>
                            <td>{{ $pinjam->jangka_waktu ?? '-' }} bulan</td>
                            <td>Rp.
                                {{ number_format($angs ?? '0', 0, ',', '.') }}
                            </td>
                            <td>
                                {{ date('M-Y', strtotime($pinjam->tanggal_mulai)) ?? '-' }}
                            </td>
                        </tr>
                        @php
                        $totalPinjaman += $pnj;
                        $totalAngsuran += $angs;
                        @endphp
                        @endforeach
                        <tr>
                            <td><strong>T O T A L</strong></td>
                            <td><strong>Rp. {{ number_format($totalPinjaman, 0, ',', '.') }}</strong></td>
                            <td></td>
                            <td><strong>Rp. {{ number_format($totalAngsuran, 0, ',', '.') }}</strong></td>
                            <td></td>
                        </tr>
                    </tbody>

                </table>
            </div>
        </div>

        <hr>
        <h6>PINJAMAN BARU</h6>
        <div class="row">
            <div class="col-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Masa</th>
                            <th>Angsuran</th>
                        </tr>
                    </thead>
                    @php
                    $pinj_baru = $request->jml_pengajuan_baru;
                    $bulan_baru = $request->bulan;
                    // $angsuran_baru = $request->angsuran;
                    @endphp
                    <tbody>
                        <tr>
                            <td>Pinjaman Baru</td>
                            <td>Rp. {{ $pinj_baru ?? 0 }}</td>
                            <td>{{ $bulan_baru ?? 0 }} bulan</td>
                            <td>Rp. {{ number_format($angsuran, 0, ',', '.') }} </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <hr>
        <h6>ANGSURAN SETELAH PERMOHONAN</h6>
        <div class="row">
            <div class="col-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Masa</th>
                            <th>Angsuran</th>
                            <th>Tanggal Mulai</th>
                        </tr>
                    </thead>
                    <tbody>
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
                            <td>{{ $p->namaproduks }}</td>
                            <td>Rp. {{ number_format($pinjaman, 0, ',', '.') }}</td>
                            <td>{{ $p->jangka_waktu }} bulan</td>
                            <td>Rp.
                                {{ number_format($angs, 0, ',', '.') }}
                            </td>
                            <td>
                                {{ date('M-Y', strtotime($p->tanggal_mulai)) }}
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td>Pinjaman Baru</td>
                            <td>Rp. {{ $pinj_baru ?? 0 }}</td>
                            <td>{{ $bulan_baru ?? 0 }} bulan</td>
                            <td>Rp. {{ number_format($angsuran, 0, ',', '.') }}</td>
                            <td></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        @php
                        $totalPinjaman += $jml_baru;
                        $ntotalAngsuran += $angsuran;
                        @endphp
                        <tr>
                            <td><strong>T O T A L</strong></td>
                            <td><strong>Rp. {{ number_format($totalPinjaman, 0, ',', '.') }}</strong></td>
                            {{-- <td><strong>Rp. {{ $angsuran }}</strong></td> --}}
                            <td></td>
                            <td><strong>Rp. {{ number_format($ntotalAngsuran, 0, ',', '.') }}</strong></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <hr>
        <div class="row">
            <div class="col-12">
                <table class="table table-borderless">
                    @php
                    $persen = ceil(($ntotalAngsuran / $request->gaji) * 100);
                    @endphp
                    <thead>
                        <tr>
                            <th colspan="3">
                                <h6>PRESENTASE DARI GAJI</h6>
                            </th>
                            <th>
                                <h6>{{ number_format($persen, 2) }}%
                                    {{-- {!! $ntotalAngsuran < $totalAngsuran
                                            ? '<span class="text-success">DISETUJUI</span>'
                                            : '<span class="text-danger">DITOLAK</span>' !!} --}}
                                </h6>
                                {{-- @if ($ntotalAngsuran < $totalAngsuran)
                                        <p class="text-success">DISETUJUI</p>
                                    @endif --}}
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>


        {{-- --}}
        @endif
    </div>
</div>