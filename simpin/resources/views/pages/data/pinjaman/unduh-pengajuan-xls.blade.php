<table class="table table-borderless">
    <thead>
        @php
            // $bungaEfektif   = FunctionHelper::bungaEfektif($bunga/100, $bulan, $saldo);
            $bungaEfektif = abs($financial->RATE($bunga / 100, $bulan, $saldo));
            // $margin = ($bungaEfektif / 100) * $saldo;
            $margin = $saldo * ($bunga / 100);
            
            $tabPerBulan = $simpas;
            $totaltabPerBulan = 0;
            $saldoPerBulan = 0;
            $saldoPerBulan = $tabPerBulan;
            $totalBunga = 0;
            $sisaHutang = $saldo + $margin;
            $totalAngsuran = round($sisaHutang / $bulan);
            $sisaPokok = $saldo;
            $totalAngsuranPokok = $totalAngsuranMargin = $subTotalAngsuran = 0;
        @endphp
        <tr>
            <th style="width:40%;padding:0.2rem" colspan="4"><b>PENGAJUAN PINJAMAN</b></th>
        </tr>

        <tr></tr>

        <tr>
            <th colspan="2" style="width:40%;padding:0.2rem">NIK</th>
            <th colspan="2" style="width:60%;padding:0.2rem">{{ $anggota->nik ?? '' }}</th>
            <th style="width:40%;padding:0.2rem">Awal Angsuran</th>
            <th style="width:60%;padding:0.2rem">{{ $rangeBulan[0][1]['bulan'] }}</th>
        </tr>
        <tr>
            <th colspan="2" style="width:40%;padding:0.2rem">Nama</th>
            <th colspan="2" style="width:60%;padding:0.2rem">{{ $anggota->nama ?? '' }}</th>
            <th style="width:40%;padding:0.2rem">Akhir Angsuran</th>
            <th style="width:60%;padding:0.2rem">{{ $rangeBulan[0][$bulan]['bulan'] }}</th>
        </tr>
        <tr>
            <th colspan="2" style="width:40%;padding:0.2rem">Plafon Pinjaman</th>
            <th colspan="2" style="width:60%;padding:0.2rem">Rp. {{ number_format($saldo, 0, ',', '.') }}</th>
        </tr>
        <tr>
            <th colspan="2" style="width:40%;padding:0.2rem">Angsuran per Bulan</th>
            <th colspan="2" style="width:60%;padding:0.2rem">Rp.
                {{ number_format($totalAngsuran, 0, ',', '.') }}</th>
        </tr>
        <tr>
            <th colspan="2" style="width:40%;padding:0.2rem">Margin Flat(%)</th>
            <th colspan="2" style="width:60%;padding:0.2rem">{{ $bunga / ($bulan / 12) }}%</th>
        </tr>
        <tr>
            <th colspan="2" style="width:40%;padding:0.2rem">Jangka Waktu</th>
            <th colspan="2" style="width:60%;padding:0.2rem">{{ $bulan }} Bulan</th>
        </tr>


    </thead>
</table>
<table class="table table-bordered table-striped simulasi">
    <thead>
        <tr>
            <th class="text-center" style="border:1px solid #000000;background-color:#dddddd;padding:2px">Ke</th>
            <th class="text-center" style="border:1px solid #000000;background-color:#dddddd;padding:2px">Bulan Angsuran
            </th>
            {{-- <th class="text-center">Sisa Hutang</th> --}}
            <th class="text-center" style="border:1px solid #000000;background-color:#dddddd;padding:2px">Sisa Pokok
            </th>
            <th class="text-center" style="border:1px solid #000000;background-color:#dddddd;padding:2px">Angsuran Pokok
            </th>
            <th class="text-center" style="border:1px solid #000000;background-color:#dddddd;padding:2px">Angsuran
                Margin</th>
            <th class="text-center" style="border:1px solid #000000;background-color:#dddddd;padding:2px">Total Angsuran
            </th>
        </tr>
    </thead>
    <tbody>

        @for ($i = 1; $i <= $bulan; $i++)
            @php
                $bungaPerBulan = ($bunga * $saldoPerBulan) / 100 / 12;
                $angsuran = round(abs($financial->PPMT($bunga / 100 / $bulan, $i, $bulan, $saldo)));
                $angsuranMargin = round($totalAngsuran - $angsuran);
            @endphp
            <tr>
                <td class="text-center" style="border:1px solid #000000;padding:2px">{{ $i }}</td>
                @if ($i == 1)
                    <td style="border:1px solid #000000;padding:2px"></td>
                @else
                    <td class="text-center" style="border:1px solid #000000;padding:2px">
                        {{ isset($rangeBulan[0][$i]['bulan']) ? $rangeBulan[0][$i]['bulan'] : '-' }}</td>
                @endif
                {{-- <td class="text-center">
                    <b>Rp. {{ number_format($sisaHutang,0,',','.') }}</b>
                </td> --}}
                <td class="text-center" style="border:1px solid #000000;padding:2px">
                    {{ $sisaPokok }}
                </td>

                @if ($i == $bulan)
                    @php
                        $angsuranPokok = $totalAngsuranPokok + $angsuran;
                        $selisihA = abs($saldo - $angsuranPokok);
                        
                        if ($saldo > $angsuranPokok) {
                            $lastAngsuran = $angsuran + $selisihA;
                        } else {
                            $lastAngsuran = $angsuran - $selisihA;
                        }
                        
                        $angsuranM = $totalAngsuranMargin + $angsuranMargin;
                        $selisihAM = abs($margin - $angsuranM);
                        
                        if ($margin > $angsuranM) {
                            $lastAngsuranMargin = $angsuranMargin + $selisihAM;
                        } else {
                            $lastAngsuranMargin = $angsuranMargin - $selisihAM;
                        }
                        
                        $TotalAngsuran = $saldo + $margin;
                        $lastTAngsuran = abs($TotalAngsuran - $subTotalAngsuran);
                        
                    @endphp

                    <td class="text-center" style="border:1px solid #000000;padding:2px">
                        {{ $lastAngsuran }}
                    </td>
                    <td class="text-center" style="border:1px solid #000000;padding:2px">
                        {{ $lastAngsuranMargin }}
                    </td>

                    <td class="text-center" style="border:1px solid #000000;padding:2px">
                        {{ $lastTAngsuran }}
                    </td>
                @else
                    <td class="text-center" style="border:1px solid #000000;padding:2px">
                        {{ $angsuran }}
                    </td>
                    <td class="text-center" style="border:1px solid #000000;padding:2px">
                        {{ $angsuranMargin }}
                    </td>

                    <td class="text-center" style="border:1px solid #000000;padding:2px">
                        {{ $totalAngsuran }}
                    </td>
                @endif
            </tr>
            @php
                $sisaPokok -= $angsuran;
                $sisaHutang -= $totalAngsuran;
                $subTotalAngsuran += $totalAngsuran;
                $totalAngsuranPokok += $angsuran;
                $totalAngsuranMargin += $angsuranMargin;
            @endphp
        @endfor
        <tr>

        </tr>
        <tr>
            <th class="text-right" colspan="3" style="border:1px solid #000000;padding:2px">J U M L A H</th>
            <th class="text-center" style="border:1px solid #000000;padding:2px">{{ $saldo }}</th>
            <th class="text-center" style="border:1px solid #000000;padding:2px">{{ $margin }}</th>
            <th class="text-center" style="border:1px solid #000000;padding:2px">{{ $TotalAngsuran }}</th>
        </tr>
        <tr> </tr>
        <tr> </tr>
        <tr>
            <td></td>
            <td colspan="2">NIK</td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2">Nama</td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2">Tanggal</td>
        </tr>
    </tbody>
</table>
