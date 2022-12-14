<div class="row">
    <div class="col-md-12">
        @if ($saldo == '')
            <h2>Silahkan Masukan Jumlah Simpanan Terlebih Dahulu</h2>
        @else
            <h4>SIMULASI PINJAMAN</h4>
            {{-- <div class="row">
                <div class="col-md-12">Target Dana Pasti <B><u>{{ $bulan }} Bulan</u> Rp. {{ number_format($saldo,0,',','.') }}</B> </div>
            </div> --}}

            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <thead>
                            @php
                                // $bungaEfektif   = FunctionHelper::bungaEfektif($bunga/100, $bulan, $saldo);
                                $bungaEfektif = abs($financial->RATE($bunga / 100, $bulan, $saldo));
                                // $margin = ($bungaEfektif / 100) * $saldo;
                                $margin = $saldo * ($bunga / 100);
                            @endphp
                            <tr>
                                <th style="width:40%;padding:0.2rem">Plafon Pinjaman</th>
                                <th style="width:60%;padding:0.2rem">Rp. {{ number_format($saldo, 0, ',', '.') }}</th>
                            </tr>
                            <tr>
                                <th style="width:40%;padding:0.2rem">Margin</th>
                                <th style="width:60%;padding:0.2rem">Rp. {{ number_format($margin, 0, ',', '.') }}</th>
                            </tr>
                            <tr>
                                <th style="width:40%;padding:0.2rem">Total</th>
                                <th style="width:60%;padding:0.2rem">Rp.
                                    {{ number_format($saldo + $margin, 0, ',', '.') }}
                                </th>
                            </tr>
                            {{-- <tr>
                                <th style="width:40%;padding:0.2rem">Jenis Pembiayaan</th>
                                <th style="width:60%;padding:0.2rem"></th>
                            </tr> --}}
                            <tr>
                                <th style="width:40%;padding:0.2rem">Margin Flat(%)</th>
                                <th style="width:60%;padding:0.2rem">{{ number_format($bunga, 3, ',', '.') }}%</th>
                            </tr>
                            {{-- <tr>
                                <th style="width:40%;padding:0.2rem">Bunga P.A(%)</th>
                                <th style="width:60%;padding:0.2rem">{{ number_format($bunga,2,',','.') }}%</th>
                            </tr> --}}
                            <tr>
                                <th style="width:40%;padding:0.2rem">Jangka Waktu</th>
                                <th style="width:60%;padding:0.2rem">{{ $bulan }} Bulan</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="col-md-6 text-right">
                    <a href="javascript:unduhSimulasi('{{ $request->produk_id }}','{{ $request->bunga }}','{{ $request->bulan }}','{{ $request->saldo }}','{{ $request->bunga_efektif }}')"
                        class="btn btn-success"><i class="fa fa-download"></i> Unduh Hasil Simulasi</a>
                </div>
            </div>


            <table class="table table-bordered table-striped simulasi">
                <thead>
                    <tr>
                        <th class="text-center">Ke</th>
                        <th class="text-center">Bulan Angsuran</th>
                        {{-- <th class="text-center">Sisa Hutang</th> --}}
                        <th class="text-center">Sisa Pokok</th>
                        <th class="text-center">Angsuran Pokok</th>
                        <th class="text-center">Angsuran Margin</th>
                        <th class="text-center">Total Angsuran</th>
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

                    @for ($i = 1; $i <= $bulan; $i++)
                        @php
                            $bungaPerBulan = ($bunga * $saldoPerBulan) / 100 / 12;
                            $angsuran = round(abs($financial->PPMT($bunga / 100 / $bulan, $i, $bulan, $saldo)));
                            $angsuranMargin = round($totalAngsuran - $angsuran);
                        @endphp
                        <tr>
                            <td class="text-center">{{ $i }}</td>
                            @if ($i == 1)
                                <td></td>
                            @else
                                <td class="text-center">
                                    {{ isset($rangeBulan[0][$i]['bulan']) ? $rangeBulan[0][$i]['bulan'] : '-' }}</td>
                            @endif
                            {{-- <td class="text-center">
                                <b>Rp. {{ number_format($sisaHutang,0,',','.') }}</b>
                            </td> --}}
                            <td class="text-center">
                                <b>Rp. {{ number_format($sisaPokok, 0, ',', '.') }}</b>
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
                                <td class="text-center">
                                    <b>Rp.
                                        {{ number_format($lastAngsuran, 0, ',', '.') }}</b>
                                </td>
                                <td class="text-center">
                                    <b>Rp.
                                        {{ number_format($lastAngsuranMargin, 0, ',', '.') }}</b>
                                </td>
                                <td class="text-center">
                                    <b>Rp.
                                        {{ number_format($lastTAngsuran, 0, ',', '.') }}</b>
                                </td>
                            @else
                                <td class="text-center">
                                    <b>Rp.
                                        {{ number_format($angsuran, 0, ',', '.') }}</b>
                                </td>
                                <td class="text-center">
                                    <b>Rp. {{ number_format($angsuranMargin, 0, ',', '.') }}</b>
                                </td>
                                <td class="text-center">
                                    <b>Rp. {{ number_format($totalAngsuran, 0, ',', '.') }}</b>
                                </td>
                            @endif
                        </tr>
                        @php
                            $sisaPokok -= $angsuran;
                            $sisaHutang -= $totalAngsuran;
                            $subTotalAngsuran += $totalAngsuran;
                            $totalAngsuranMargin += $angsuranMargin;
                            $totalAngsuranPokok += $angsuran;
                        @endphp
                    @endfor

                    <tr>
                        <th class="text-right" colspan="3">J U M L A H</th>
                        <th class="text-center">Rp. {{ number_format($saldo, 0, ',', '.') }}</th>
                        <th class="text-center">Rp. {{ number_format($margin, 0, ',', '.') }}</th>
                        <th class="text-center">Rp. {{ number_format($TotalAngsuran, 0, ',', '.') }}</th>
                    </tr>

                </tbody>
            </table>
        @endif
    </div>
</div>
