<table class="table table-borderless">
    <thead>
        <tr>
            <th style="width:40%;padding:0.2rem" colspan="4"><b>PLAFON PINJAMAN</b></th>
        </tr>

        <tr></tr>

        <tr>
            <th style="width:40%;padding:0.2rem">Nama</th>
            <th style="width:60%;padding:0.2rem">{{ $anggota->nama }}</th>
            <th></th>
            <th style="width:40%;padding:0.2rem">Gaji Pokok</th>
            <th style="width:60%;padding:0.2rem">Rp.
                {{ number_format($data['gaji'], 0, ',', '.') }}</th>
        </tr>
        <tr>
            <th style="width:40%;padding:0.2rem">NIK</th>
            <th style="width:60%;padding:0.2rem">{{ $anggota->nik }}</th>
            <th></th>
            <th style="width:60%;padding:0.2rem">Rp. {{ number_format($gaji40, 0, ',', '.') }} </th>
        </tr>
        <tr>
            <th style="width:40%;padding:0.2rem">Masa Kerja</th>
            <th style="width:60%;padding:0.2rem">{{ $data['masa'] }} + 1 Tahun</th>
        </tr>
        <tr>
            <th style="width:40%;padding:0.2rem">Usia</th>
            <th style="width:60%;padding:0.2rem">{{ $anggota->age }} Tahun</th>
        </tr>


    </thead>
</table>
<table class="table table-bordered table-striped simulasi">
    <thead>
        <tr>
            <th>ANGSURAN YANG SUDAH ADA</th>
        </tr>
        <tr></tr>
    </thead>
    <tbody>
        <tr>
            <th>Produk</th>
            <th>Jumlah</th>
            <th>Masa</th>
            <th>Angsuran</th>
            <th>Tanggal Mulai</th>
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

<table class="table">
    <thead>
        <tr>
            <th>PINJAMAN BARU</th>
        </tr>

        <tr>
            <th>Produk</th>
            <th>Jumlah</th>
            <th>Masa</th>
            <th>Angsuran</th>
        </tr>
    </thead>
    @php
        $pinj_baru = $jml_baru;
        $bulan_baru = $data['bulan'];
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

<table class="table">
    <thead>
        <tr>
            <th>ANGSURAN SETELAH PERMOHONAN</th>
        </tr>

        <tr>
            <th>Produk</th>
            <th>Jumlah</th>
            <th>Masa</th>
            <th>Angsuran</th>
            <th>Tanggal Mulai</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pinjaman as $p)
            @php
                $pinjaman = $p->jml_pinjaman;
                $angs = $p->detail[0]->total_angsuran;
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
            <td></td>
            <td><strong>Rp. {{ number_format($ntotalAngsuran, 0, ',', '.') }}</strong></td>
            <td></td>
        </tr>
    </tfoot>
</table>

<table class="table table-borderless">
    @php
        $persen = ($ntotalAngsuran / $data['gaji']) * 100;
    @endphp
    <thead>
        <tr>
            <th colspan="3">
                <h6>PRESENTASE DARI GAJI</h6>
            </th>
            <th>
                <h6>{{ number_format($persen, 2) }}%
                </h6>
            </th>
        </tr>
    </thead>
</table>
