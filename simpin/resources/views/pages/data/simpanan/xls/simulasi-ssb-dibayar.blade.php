
            <table class="table table-bordered table-striped simulasi">
                    <tr>
                        <th style="border:0px solid #ffffff;background:#ffffff;padding:2px;" colspan="8">
                            <b>SSB (SIMPANAN SUKARELA BERJANGKA)</b>
                        </th>
                    </tr>
                    <tr>
                        <th style="border:0px solid #ffffff;background:#ffffff;padding:2px;" colspan="8">
                            <b>BUNGA DIBAYAR</b>
                        </th>
                    </tr>
                    <tr>
                        <th class="text-center" style="border:1px solid #000000;background:#dddddd;padding:2px;">Bulan Ke</th>
                        <th class="text-center" style="border:1px solid #000000;background:#dddddd;padding:2px;"></th>
                        <th class="text-center" style="border:1px solid #000000;background:#dddddd;padding:2px;">Jumlah Hari</th>
                        <th class="text-center" style="border:1px solid #000000;background:#dddddd;padding:2px;">Nominal</th>
                        <th class="text-center" style="border:1px solid #000000;background:#dddddd;padding:2px;">Bunga Harian</th>
                        <th class="text-center" style="border:1px solid #000000;background:#dddddd;padding:2px;">Jumlah Bunga</th>
                        <th class="text-center" style="border:1px solid #000000;background:#dddddd;padding:2px;">PPh 10%</th>
                        <th class="text-center" style="border:1px solid #000000;background:#dddddd;padding:2px;">Bunga Di Terima</th>
                    </tr>
                    @php
                        $totalJumlahBunga = 0;
                        $totalTerima      = 0;
                    @endphp
                    @for ($i=1;$i<=$bulan;$i++)
                        <tr>
                            <td class="text-center" style="border:1px solid #000000;padding:2px;">
                                {{ $i }}
                            </td>
                            <td class="text-center" style="border:1px solid #000000;padding:2px;">
                                {{ isset($rangeBulan[0][$i]['bulan']) ? $rangeBulan[0][$i]['bulan'] : '-' }}
                            </td>
                            <td class="text-center" style="border:1px solid #000000;padding:2px;">
                                {{ isset($rangeBulan[0][$i]['jlh_hari']) ? $rangeBulan[0][$i]['jlh_hari'] : '-' }}
                            </td>
                            <td class="text-right">
                                {{ $saldo }}
                            </td>
                            <td class="text-center" style="border:1px solid #000000;padding:2px;">
                                {{ $bunga }}%
                            </td>
                            @php
                                $totalHari = $rangeBulan['totalHari'];
                                $jlhBunga = FunctionHelper::jumlahBungaSSB($rangeBulan[0][$i]['bln'], $rangeBulan[0][$i]['thn'], $saldo, $bunga,$totalHari);
                                // $saldoBunga = $saldo;
                                // $saldo += $jlhBunga;
                                $totalJumlahBunga += $jlhBunga;
                                $jlhBungaPph    = 10/100 * $jlhBunga;
                                if($jlhBunga <= 240000){
                                    $jlhBungaPph       = 0;
                                    $jlhDiterima    = $jlhBunga - $jlhBungaPph;
                                } else {
                                    $jlhDiterima    = $jlhBunga - $jlhBungaPph;
                                }
                                $totalTerima += $jlhDiterima;
                            @endphp
                            <td class="text-right" style="border:1px solid #000000;padding:2px;">
                                {{ $jlhBunga }}
                            </td>
                            <td class="text-right" style="border:1px solid #000000;padding:2px;">
                                {{ $jlhBungaPph }}
                            </td>
                            <td class="text-right" style="border:1px solid #000000;padding:2px;">
                                {{ $jlhDiterima }}
                            </td>
                        </tr>
                    @endfor
                    <tr>
                        <th class="text-center" style="border:1px solid #000000;padding:2px;"></th>
                        <th class="text-center" style="border:1px solid #000000;padding:2px;"></th>
                        <th class="text-center" style="border:1px solid #000000;padding:2px;">{{ $totalHari }}</th>
                        <th class="text-center" style="border:1px solid #000000;padding:2px;"></th>
                        <th class="text-center" style="border:1px solid #000000;padding:2px;"></th>
                        <th class="text-right">{{ $totalJumlahBunga }}</th>
                        <th class="text-right"></th>
                        <th class="text-right">{{ $totalTerima }}</th>
                    </tr>
            </table>