<table class="table table-bordered table-striped simulasi">
    <tr>
        <th style="border:0px solid #ffffff;background:#ffffff;padding:2px;" colspan="5">
            <strong>Target Dana Pasti {{ $bulan }} Bulan: Rp. {{ number_format($saldo, 0) }}</strong>
        </th>
    </tr>
    <tr>
        <th style="border:1px solid #000000;background:#dddddd;padding:2px;">Ke</th>
        <th style="border:1px solid #000000;background:#dddddd;padding:2px;">Akhir</th>
        <th style="border:1px solid #000000;background:#dddddd;padding:2px;">Tabungan Per Bulan</th>
        <th style="border:1px solid #000000;background:#dddddd;padding:2px;">Bunga ({{ $bunga }}%)</th>
        <th style="border:1px solid #000000;background:#dddddd;padding:2px;">Saldo</th>
    </tr>

    @php
        // $tabPerBulan = $simpas;
        $totaltabPerBulan = 0;
        $saldoPerBulan = 0;
        
        $totalBunga = 0;
        $getTabungan = FunctionHelper::tabunganPerbulan($bunga, $bulan, $saldo);
        // dd($getTabungan);
        $tabPerBulan = $getTabungan['tabunganPerBulan'];
        $bungaEfektif = $getTabungan['bungaEfektif'];
        $tabunganEfektif = $getTabungan['tabunganEfektif'];
        $angsuran = $getTabungan['angsuran'];
        $saldoPerBulan = $tabPerBulan;
    @endphp
    @for ($i = 1; $i <= $bulan; $i++)
        @php
            if ($i > 1) {
                $bungaPerBulan = ($bunga * $saldoPerBulan) / 100 / 12;
            }
        @endphp
        <tr>
            <td style="border:1px solid #000000;padding:2px;">{{ $i }}</td>
            <td style="border:1px solid #000000;padding:2px;">
                <input type="hidden" name="simulasi[simpas][blnThn][{{ $i }}]"
                    value="{{ $rangeBulan[0][$i]['bulan'] }}">
                {{ isset($rangeBulan[0][$i]['bulan']) ? $rangeBulan[0][$i]['bulan'] : '-' }}
            </td>
            <td style="border:1px solid #000000;padding:2px;">
                @if ($i == $bulan + 1)
                    @php
                        $tabPerBulan = 0;
                    @endphp
                    <input type="hidden" name="simulasi[simpas][tabunganPerBulan][{{ $i }}]"
                        value="{{ $tabPerBulan }}">
                @else
                    <input type="hidden" name="simulasi[simpas][tabunganPerBulan][{{ $i }}]"
                        value="{{ $tabPerBulan }}">
                    {{ $tabPerBulan }}
                @endif
            </td>
            <td style="border:1px solid #000000;padding:2px;">
                @if ($i == 1)
                    <input type="hidden" name="simulasi[simpas][bungaHarian][{{ $i }}]" value="0">
                    {{-- @elseif ($i==($bulan+1))
                        <input type="hidden" name="simulasi[simpas][bungaHarian][{{ $i }}]" value="0">
                        {{ ($saldo - $saldoPerBulan) }} --}}
                @else
                    <input type="hidden" name="simulasi[simpas][bungaHarian][{{ $i }}]"
                        value="{{ $bungaPerBulan }}">
                    {{ $bungaPerBulan }}
                @endif
            </td>
            <td style="border:1px solid #000000;padding:2px;">
                @php
                    if ($i != 1) {
                        if ($i == $bulan + 1) {
                            $totalBunga += $saldo - $saldoPerBulan;
                            $saldoPerBulan = $saldo;
                        } else {
                            $saldoPerBulan += $tabPerBulan + $bungaPerBulan;
                            $totalBunga += $bungaPerBulan;
                        }
                    }
                    if ($i < $bulan + 1) {
                        $totaltabPerBulan += $tabPerBulan;
                    }
                @endphp
                <input type="hidden" name="simulasi[simpas][saldoPerBulan][{{ $i }}]"
                    value="{{ $saldoPerBulan }}">
                {{ $saldoPerBulan }}
            </td>

        </tr>
    @endfor
    <tr>
        <th style="border:1px solid #000000;padding:2px;"></th>
        <th style="border:1px solid #000000;padding:2px;"></th>
        <th style="border:1px solid #000000;padding:2px;">{{ $totaltabPerBulan }}</th>
        <th style="border:1px solid #000000;padding:2px;">{{ $totalBunga }}</th>
        <th style="border:1px solid #000000;padding:2px;">{{ $saldoPerBulan }}</th>
    </tr>

</table>
