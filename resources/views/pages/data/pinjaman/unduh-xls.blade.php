<table class="table table-borderless">
    <thead>
        @php
        // $bungaEfektif = FunctionHelper::bungaEfektif($bunga/100, $bulan, $saldo);
        $bungaEfektif = abs($financial->RATE($bunga / 100, $bulan, $saldo));
        // $margin = ($bungaEfektif / 100) * $saldo;
        $margin = $saldo * ($bunga / 100);
        @endphp
        <tr>
            <th style="width:40%;padding:0.2rem" colspan="4"><b>SIMULASI PINJAMAN</b></th>
        </tr>
        <tr>
            <th style="width:40%;padding:0.2rem" colspan="2">Plafon Pinjaman</th>
            <th style="width:60%;padding:0.2rem" colspan="2">Rp. {{ number_format($saldo, 0, ',', '.') }}</th>
        </tr>
        <tr>
            <th style="width:40%;padding:0.2rem" colspan="2">Margin</th>
            <th style="width:60%;padding:0.2rem" colspan="2">Rp. {{ number_format($margin, 0, ',', '.') }}</th>
        </tr>
        <tr>
            <th style="width:40%;padding:0.2rem" colspan="2">Total</th>
            <th style="width:60%;padding:0.2rem" colspan="2">Rp. {{ number_format($saldo + $margin, 0, ',', '.') }}
            </th>
        </tr>
        {{-- <tr>
            <th style="width:40%;padding:0.2rem">Jenis Pembiayaan</th>
            <th style="width:60%;padding:0.2rem"></th>
        </tr> --}}
        <tr>
            <th style="width:40%;padding:0.2rem" colspan="2">Margin Flat(%)</th>
            <th style="width:60%;padding:0.2rem" colspan="2">{{ number_format($bunga, 3, ',', '.') }}%</th>
        </tr>
        {{-- <tr>
            <th style="width:40%;padding:0.2rem">Bunga P.A(%)</th>
            <th style="width:60%;padding:0.2rem">{{ number_format($bunga,2,',','.') }}%</th>
        </tr> --}}
        <tr>
            <th style="width:40%;padding:0.2rem" colspan="2">Jangka Waktu</th>
            <th style="width:60%;padding:0.2rem" colspan="2">{{ $bulan }} Bulan</th>
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
        @php
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
        @for ($i = 1; $i <= $bulan; $i++) @php $bungaPerBulan=($bunga * $saldoPerBulan) / 100 / 12; $angsuran=round(abs($financial->PPMT($bunga / 100 / $bulan, $i, $bulan, $saldo)));
            $angsuranMargin = round($totalAngsuran - $angsuran);
            @endphp
            <tr>
                <td class="text-center" style="border:1px solid #000000;padding:2px">{{ $i }}</td>
                @if ($i == 1)
                <td style="border:1px solid #000000;padding:2px"></td>
                @else
                <td class="text-center" style="border:1px solid #000000;padding:2px">
                    {{ isset($rangeBulan[0][$i]['bulan']) ? $rangeBulan[0][$i]['bulan'] : '-' }}
                </td>
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

                $selisihAM = abs($margin - ($totalAngsuranMargin + $angsuranMargin));
                $lastAngsuranMargin = $angsuranMargin + $selisihAM;

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
    </tbody>
</table>