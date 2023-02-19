<div class="row">
    <div class="col-md-12">
        @if ($anggota == null)
        <h2>Silahkan Pilih Anggota Terlebih Dahulu</h2>
        @elseif ($gajiAnggota == '' || $gajiAnggota == null)
        <h2>Silahkan Isi Gaji Pokok Terlebih Dahulu</h2>
        @else
        <h4>PLAFON PINJAMAN</h4>

        <div class="row">
            <div class="col-md-5">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th style="width:40%;padding:0.2rem">Nama</th>
                            <th style="width:60%;padding:0.2rem">{{ $anggota->nama }}</th>
                        </tr>
                        <tr>
                            <th style="width:40%;padding:0.2rem">NIK</th>
                            <th style="width:60%;padding:0.2rem">{{ $anggota->no_anggota }}</th>
                        </tr>
                        <tr>
                            <th style="width:40%;padding:0.2rem">Masa Kerja</th>
                            <th style="width:60%;padding:0.2rem">{{ $request->masa }} + 1 Tahun</th>
                        </tr>
                        <tr>
                            <th style="width:40%;padding:0.2rem">Usia</th>
                            <th style="width:60%;padding:0.2rem">{{ $anggota->age }} Tahun</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="col-md-4">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th style="width:40%;padding:0.2rem">Gaji Pokok</th>
                            <th style="width:60%;padding:0.2rem">Rp.
                                {{ number_format($gajiAnggota, 0, ',', '.') }}
                            </th>
                        </tr>
                        <tr>
                            <th style="width:40%;padding:0.2rem">40% Gaji Pokok</th>
                            <th style="width:60%;padding:0.2rem">Rp.
                                {{ number_format($gaji40, 0, ',', '.') }}
                                {{-- {{ $gajiAnggota * 40 }} --}}
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="col-md-2 text-right">
                <a href="javascript:unduhSimulasiNew('{{ $anggota->no_anggota }}','{{ $request->masa }}','{{ $gajiAnggota }}','{{ $request->bulan }}','{{ $request->jml_pengajuan_baru }}','{{ $angsuran }}','{{ $nama_produk }}')" class="btn btn-success"><i class="fa fa-download"></i> Unduh Hasil </a>
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
                            <th>Periode Awal</th>
                            <th>Periode Akhir</th>
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
                            <td>
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
                            <td><strong>T O T A L</strong></td>
                            <td><strong>Rp. {{ number_format($totalPinjaman, 0, ',', '.') }}</strong></td>
                            <td></td>
                            <td><strong>Rp. {{ number_format($totalAngsuran, 0, ',', '.') }}</strong></td>
                            <td></td>
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
                            <th>Periode Awal</th>
                            <th>Periode Akhir</th>
                        </tr>
                    </thead>
                    @php
                    $pinj_baru = $request->jml_pengajuan_baru;
                    $bulan_baru = $request->bulan;
                    $nama_produk = $nama_produk;
                    @endphp
                    <tbody>
                        <tr>
                            <td>{{ $nama_produk }}</td>
                            <td>Rp. {{ $pinj_baru ?? 0 }}</td>
                            <td>{{ $bulan_baru ?? 0 }} bulan</td>
                            <td>Rp. {{ number_format($angsuran, 0, ',', '.') }} </td>
                            <td>{{ $rangeBulan[1]['bulan'] ?? '' }}</td>
                            <td>{{ $rangeBulan[$bulan_baru ?? 1]['bulan'] ?? '' }}</td>
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
                            <th>Periode Awal</th>
                            <th>Periode Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $ntotalPinjaman = 0;
                        $ntotalAngsuran = 0;
                        @endphp
                        @foreach ($pinjaman as $p)
                        @php
                        $pinjaman = $p->jml_pinjaman;
                        $angs = $p->detail[0]->total_angsuran;
                        $ntotalPinjaman += $pinjaman;
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
                            <td>
                                {{ date('M-Y', strtotime($p->tanggal_akhir)) }}
                            </td>
                        </tr>
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
                        $ntotalPinjaman += $pnj;
                        $totalAngsuran += $angs;
                        @endphp
                        @endforeach
                        <tr>
                            <td>{{ $nama_produk }}</td>
                            <td>Rp. {{ $pinj_baru ?? 0 }}</td>
                            <td>{{ $bulan_baru ?? 0 }} bulan</td>
                            <td>Rp. {{ number_format($angsuran, 0, ',', '.') }}</td>
                            <td>{{ $rangeBulan[1]['bulan'] ?? '' }}</td>
                            <td>{{ $rangeBulan[$bulan_baru ?? 1]['bulan'] ?? '' }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        @php
                        $ntotalPinjaman += $jml_baru;
                        $ntotalAngsuran += $angsuran;
                        @endphp
                        <tr>
                            <td><strong>T O T A L</strong></td>
                            <td><strong>Rp. {{ number_format($ntotalPinjaman, 0, ',', '.') }}</strong></td>
                            {{-- <td><strong>Rp. {{ $angsuran }}</strong></td> --}}
                            <td></td>
                            <td><strong>Rp. {{ number_format($ntotalAngsuran, 0, ',', '.') }}</strong></td>
                            <td></td>
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
                    $persen = ceil(($ntotalAngsuran / $gajiAnggota) * 100);
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