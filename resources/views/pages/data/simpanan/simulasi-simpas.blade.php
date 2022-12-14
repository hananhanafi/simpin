<div class="row">
    <div class="col-md-10 text-right">
        <a href="javascript:PlafonSimulasi('{{ $request->no_anggota }}','{{ $request->saldo }}','{{ $request->bulan }}','{{ $request->totalAngsuran }}' )" class=" btn btn-success"><i class="fa fa-download"></i> Plafon SIMPAS </a>
    </div>
    <div class="col-md-2 text-right">
        <a href="javascript:unduhSimulasi('{{ $request->produk_id }}','{{ $request->bunga }}','{{ $request->bulan }}','{{ $request->saldo }}','{{ $request->bunga_efektif }}')" class="btn btn-success"><i class="fa fa-download"></i> Unduh Hasil Simulasi</a>
    </div>

    <div class="col-md-12">
        @if ($saldo == '')
        <h2>Silahkan Masukan Jumlah Simpanan Terlebih Dahulu</h2>
        @else
        <div class="row">
            <div class="col-md-12">Target Dana Pasti <strong><u>{{ $bulan }} Bulan</u> Rp.
                    {{ number_format($saldo, 0, ',', '.') }}</strong> </div>
        </div>

        <table class="table table-bordered table-striped simulasi">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Akhir</th>
                    <th class="text-center">Saldo Awal</th>
                    <th class="text-center">Angsuran</th>
                    <th class="text-center">Bunga ({{ $bunga }}%)</th>
                    <th class="text-center">Saldo Akhir</th>
                </tr>
            </thead>
            <tbody>
                @php
                // $tabPerBulan = $simpas;
                $totaltabPerBulan = 0;
                $totalAngsuran = 0;
                $saldoPerBulan = 0;

                $totalBunga = 0;
                $getTabungan = FunctionHelper::tabunganPerbulan($bunga, $bulan, $saldo);
                // dd($tabunganPerBulan);
                $tabPerBulan = $getTabungan['tabunganPerBulan'];
                $bungaEfektif = $getTabungan['bungaEfektif'];
                $tabunganEfektif = $getTabungan['tabunganEfektif'];
                $angsuran = $getTabungan['angsuran'];
                $saldoPerBulan = $tabPerBulan;
                $bungaPerBulan = 0;
                @endphp
                @for ($i = 1; $i <= $bulan; $i++) <tr>
                    <td class="text-center">{{ $i }}</td>
                    <td class="text-center">
                        <input type="hidden" name="simulasi[simpas][blnThn][{{ $i }}]" value="{{ $rangeBulan[0][$i]['bulan'] }}">
                        {{ isset($rangeBulan[0][$i]['bulan']) ? $rangeBulan[0][$i]['bulan'] : '-' }}
                    </td>

                    <td class="text-center">
                        <input type="hidden" name="simulasi[simpas][saldoPerBulan][{{ $i }}]" value="{{ $totaltabPerBulan }}">
                        Rp. {{ number_format($totaltabPerBulan, 0, ',', '.') }}
                    </td>
                    <td class="text-center">
                        @if ($i == $bulan + 1)
                        @php
                        $tabPerBulan = 0;
                        @endphp
                        <input type="hidden" name="simulasi[simpas][tabunganPerBulan][{{ $i }}]" value="{{ $tabPerBulan }}">
                        @else
                        <input type="hidden" name="simulasi[simpas][tabunganPerBulan][{{ $i }}]" value="{{ $tabPerBulan }}">
                        Rp. {{ number_format($tabPerBulan, 0, ',', '.') }}
                        @endif
                    </td>
                    @php
                    // if ($i> 1) {
                    // // $totaltabPerBulan += $tabPerBulan + $bungaPerBulan;
                    // $totaltabPerBulan += $tabPerBulan + $bungaPerBulan;
                    // $tempBungaPerbulan = $bungaPerBulan;
                    // $bungaPerBulan = ($bunga * $totaltabPerBulan) / 100 / 12;
                    // $totaltabPerBulan = $totaltabPerBulan - $tempBungaPerbulan + $bungaPerBulan;

                    // }else {
                    // // $totaltabPerBulan += $tabPerBulan;
                    // $bungaPerBulan = ($bunga * $tabPerBulan) / 100 / 12;
                    // $totaltabPerBulan = $tabPerBulan + $bungaPerBulan;
                    // $bungaPerBulan = ($bunga * $totaltabPerBulan) / 100 / 12;
                    // $totaltabPerBulan = $tabPerBulan + $bungaPerBulan;
                    // }

                    $bungaPerBulan = ($bunga * $totaltabPerBulan) / 100 / 12;

                    @endphp
                    <td class="text-center">
                        {{-- @if ($i == 1)
                            <input type="hidden" name="simulasi[simpas][bungaHarian][{{ $i }}]" value="0"> --}}
                        {{-- @elseif ($i==($bulan+1))
                                    <input type="hidden" name="simulasi[simpas][bungaHarian][{{ $i }}]" value="0">
                        Rp. {{ number_format(($saldo - $saldoPerBulan),0,',','.') }} --}}
                        {{-- @else
                            <input type="hidden" name="simulasi[simpas][bungaHarian][{{ $i }}]" value="{{ $bungaPerBulan }}">
                        Rp. {{ number_format($bungaPerBulan, 0, ',', '.') }}
                        @endif --}}
                        <input type="hidden" name="simulasi[simpas][bungaHarian][{{ $i }}]" value="{{ $bungaPerBulan }}">
                        Rp. {{ number_format($bungaPerBulan, 0, ',', '.') }}
                    </td>
                    <td class="text-center">
                        @php
                        // if ($i != 1) {
                        // if ($i == $bulan + 1) {
                        // $totalBunga += $saldo - $saldoPerBulan;
                        // $saldoPerBulan = $saldo;
                        // } else {
                        // $saldoPerBulan += $tabPerBulan + $bungaPerBulan;
                        // $totalBunga += $bungaPerBulan;
                        // }
                        // }

                        // if ($i == $bulan + 1) {
                        // $totalBunga += $saldo - $saldoPerBulan;
                        // // $saldoPerBulan = $saldo;
                        // } else {
                        // // $saldoPerBulan += $tabPerBulan + $bungaPerBulan;
                        // $totalBunga += $bungaPerBulan;
                        // }
                        // if ($i < $bulan + 1) { $totaltabPerBulan +=$tabPerBulan; } 
                        $totalBunga +=$bungaPerBulan; 
                        $totaltabPerBulan +=$tabPerBulan + $bungaPerBulan; 
                        $totalAngsuran +=$tabPerBulan; 
                        @endphp 
                        <input type="hidden" name="simulasi[simpas][totaltabPerBulan][{{ $i }}]" value="{{ $totaltabPerBulan }}">
                            Rp. {{ number_format($totaltabPerBulan, 0, ',', '.') }}
                    </td>
                    </tr>
                    @endfor

                    <tr>
                        <th class="text-center"></th>
                        <th class="text-center"></th>
                        <th class="text-center">Rp. {{ number_format($totaltabPerBulan, 0, ',', '.') }}</th>
                        <th class="text-center">Rp. {{ number_format($totalAngsuran, 0, ',', '.') }}</th>
                        <th class="text-center">Rp. {{ number_format($totalBunga, 0, ',', '.') }}</th>
                        <th class="text-center">Rp. {{ number_format($totaltabPerBulan, 0, ',', '.') }}</th>
                        <input type="hidden" name="simulasi[simpas][totalSaldoAwal]" value="{{ $totaltabPerBulan }}">
                        <input type="hidden" name="simulasi[simpas][totalTabungan]" value="{{ $totalAngsuran }}">
                        <input type="hidden" name="simulasi[simpas][totalBunga]" value="{{ $totalBunga }}">
                        <input type="hidden" name="simulasi[simpas][saldoTotal]" value="{{ $totaltabPerBulan }}">
                        <input type="hidden" name="simulasi[simpas][saldoPembulatan]" value="{{ FunctionHelper::roundUpToAny($totaltabPerBulan) }}">
                    </tr>
                    {{-- <tr>
                        <th class="text-right" colspan="4">Dibulatkan >>>>>>> </th>
                        <th class="text-right">Rp. {{ number_format(FunctionHelper::roundUpToAny($saldoPerBulan),0,',','.') }}</th>
                    <input type="hidden" name="simulasi[simpas][saldoPembulatan]" value="{{ FunctionHelper::roundUpToAny($saldoPerBulan) }}">
                    </tr> --}}
            </tbody>
        </table>

        @endif
    </div>
</div>
<script>
    function PlafonSimulasi(no_anggota, saldo, bulan, totalAngsuran) {
        var totalAngsuran = <?php echo $totalAngsuran ?>;
        var angsuran = <?php echo $angsuran ?>;
        var request = '';

        request += 'no_anggota=' + no_anggota + '&'
        request += 'bulan=' + bulan + '&'
        request += 'saldo=' + parseInt(saldo.replaceAll('.', '')) + '&'
        request += 'totalAngsuran=' + totalAngsuran + '&'
        request += 'angsuran=' + angsuran

        window.open(
            "{{ route('data.simpanan.plafon') }}?" + request, '_blank');
    }
</script>