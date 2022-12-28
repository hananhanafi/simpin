<div class="row">
    <div class="col-md-12 text-right">
        <a href="javascript:unduhSimulasi('{{ $request->produk_id }}','{{ $request->bunga }}','{{ $request->bulan }}','{{ $request->saldo }}','{{ $request->bunga_efektif }}')" class="btn btn-success"><i class="fa fa-download"></i> Unduh Hasil Simulasi</a>
    </div>
    @if ($saldo == '')
    <h2>Silahkan Masukan Jumlah Simpanan Terlebih Dahulu</h2>
    @else
    @php
    if ($jenis_ssb == 'rollover') {
    $hiderollover = 'display:block;';
    $hidedibayar = 'display:none;';
    } elseif ($jenis_ssb == 'dibayar') {
    $hiderollover = 'display:none;';
    $hidedibayar = 'display:block;';
    } else {
    $hiderollover = 'display:none;';
    $hidedibayar = 'display:none;';
    }
    @endphp

    <div class="col-md-12" style="{{ $hiderollover }}">
        <h4>SSB (SIMPANAN SUKARELA BERJANGKA)</h4>
        <h5>MAJEMUK</h5>
        <table class="table table-bordered table-striped simulasi">
            <thead>
                <tr>
                    <th class="text-center">Bulan Ke</th>
                    <th class="text-center"></th>
                    <th class="text-center">Jumlah Hari</th>
                    <th class="text-center">Nominal</th>
                    <th class="text-center">Bunga Harian</th>
                    <th class="text-center">Jumlah Bunga</th>
                    <th class="text-center">PPh 10%</th>
                    <th class="text-center">Bunga Di Terima</th>
                </tr>
            </thead>
            <tbody>
                @php
                $totalHari = 0;
                $totalJumlahBunga = 0;
                $totalJumlahBungaPph = 0;
                $saldoBunga = $saldo;
                $totalTerima = 0;
                @endphp
                @for ($i = 1; $i <= $bulan; $i++) 
                <tr>
                    <td class="text-center">{{ $i }}</td>
                    <td class="text-center">
                        <input type="hidden" name="simulasi[ssb][rollover][blnThn][{{ $i }}]" value="{{ $rangeBulan[0][$i]['bulan'] }}">
                        {{ isset($rangeBulan[0][$i]['bulan']) ? $rangeBulan[0][$i]['bulan'] : '-' }}
                    </td>
                    <td class="text-center">
                        <input type="hidden" name="simulasi[ssb][rollover][jlhHari][{{ $i }}]" value="{{ $rangeBulan[0][$i]['jlh_hari'] }}">
                        {{ isset($rangeBulan[0][$i]['jlh_hari']) ? $rangeBulan[0][$i]['jlh_hari'] : '-' }}
                    </td>
                    <td class="text-right">
                        <input type="hidden" name="simulasi[ssb][rollover][saldo][{{ $i }}]" value="{{ $saldoBunga }}">
                        {{ number_format($saldoBunga, 0, ',', '.') }}
                    </td>
                    <td class="text-center">
                        <input type="hidden" name="simulasi[ssb][rollover][bungaHarian][{{ $i }}]" value="{{ $bunga }}">
                        {{ $bunga }}%
                    </td>
                    @php
                    $totalHari = $rangeBulan['totalHari'];
                    $jlhBunga = FunctionHelper::jumlahBungaSSB($rangeBulan[0][$i]['bln'], $rangeBulan[0][$i]['thn'], $saldoBunga, $bunga, $totalHari);

                    $saldoBunga += $jlhBunga;
                    $totalJumlahBunga += $jlhBunga;

                    $jlhBungaPph = (10 / 100) * $jlhBunga;
                    if ($jlhBunga <= 240000) { $jlhBungaPph=0; $jlhDiterima=$jlhBunga - $jlhBungaPph; } 
                    else { $jlhDiterima=$jlhBunga - $jlhBungaPph; } 
                    $totalTerima +=$jlhDiterima; 
                    $totalJumlahBungaPph += $jlhBungaPph;
                    @endphp 
                    <td class="text-right">
                        <input type="hidden" name="simulasi[ssb][rollover][jlhBunga][{{ $i }}]" value="{{ $jlhBunga }}">
                        {{ number_format($jlhBunga, 0, ',', '.') }}
                    </td>
                    <td class="text-right">
                        <input type="hidden" name="simulasi[ssb][rollover][bungapph][{{ $i }}]" value="{{ $jlhBungaPph }}">
                        {{ number_format($jlhBungaPph, 0, ',', '.') }}
                    </td>
                    <td class="text-right">
                        <input type="hidden" name="simulasi[ssb][rollover][jumlahditerima][{{ $i }}]" value="{{ $jlhDiterima }}">
                        {{ number_format($jlhDiterima, 0, ',', '.') }}
                    </td>
                </tr>
                @endfor
                <tr>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                    <th class="text-center">{{ $totalHari }}</th>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                    <th class="text-right">{{ number_format($totalJumlahBunga, 0, ',', '.') }}</th>
                    <th class="text-right">{{ number_format($totalJumlahBungaPph, 0, ',', '.') }}</th>
                    <th class="text-right">{{ number_format($totalTerima, 0, ',', '.') }}</th>
                    <input type="hidden" name="simulasi[ssb][rollover][totalHari]" value="{{ $totalHari }}">
                    <input type="hidden" name="simulasi[ssb][rollover][totalJumlahBunga]" value="{{ $totalJumlahBunga }}">
                    <input type="hidden" name="simulasi[ssb][rollover][totalJumlahBungaPph]" value="{{ $totalJumlahBungaPph }}">
                </tr>
            </tbody>
        </table>

    </div>

    <div class="col-md-12" style="{{ $hidedibayar }}">
        <h4>SSB (SIMPANAN SUKARELA BERJANGKA)</h4>
        <h5>DIBAYAR</h5>
        <table class="table table-bordered table-striped simulasi">
            <thead>
                <tr>
                    <th class="text-center">Bulan Ke</th>
                    <th class="text-center"></th>
                    <th class="text-center">Jumlah Hari</th>
                    <th class="text-center">Nominal</th>
                    <th class="text-center">Bunga Harian</th>
                    <th class="text-center">Jumlah Bunga</th>
                    <th class="text-center">PPh 10%</th>
                    <th class="text-center">Bunga Di Terima</th>
                </tr>
            </thead>
            <tbody>
                @php
                $totalJumlahBunga = 0;
                $totalJumlahBungaPph = 0;
                $totalTerima = 0;
                @endphp
                @for ($i = 1; $i <= $bulan; $i++) 
                <tr>
                    <td class="text-center">
                        {{ $i }}
                    </td>
                    <td class="text-center">
                        {{ isset($rangeBulan[0][$i]['bulan']) ? $rangeBulan[0][$i]['bulan'] : '-' }}
                        <input type="hidden" name="simulasi[ssb][dibayar][blnThn][{{ $i }}]" value="{{ $rangeBulan[0][$i]['bulan'] }}">
                    </td>
                    <td class="text-center">
                        {{ isset($rangeBulan[0][$i]['jlh_hari']) ? $rangeBulan[0][$i]['jlh_hari'] : '-' }}
                        <input type="hidden" name="simulasi[ssb][dibayar][jlhHari][{{ $i }}]" value="{{ $rangeBulan[0][$i]['jlh_hari'] }}">
                    </td>
                    <td class="text-right">
                        {{ number_format($saldo, 0, ',', '.') }}
                        <input type="hidden" name="simulasi[ssb][dibayar][saldo][{{ $i }}]" value="{{ $saldo }}">
                    </td>
                    <td class="text-center">
                        {{ $bunga }}%
                        <input type="hidden" name="simulasi[ssb][dibayar][bungaHarian][{{ $i }}]" value="{{ $bunga }}">
                    </td>
                    @php
                        $totalHari = $rangeBulan['totalHari'];
                        $jlhBunga = FunctionHelper::jumlahBungaSSB($rangeBulan[0][$i]['bln'], $rangeBulan[0][$i]['thn'], $saldo, $bunga, $totalHari);
                        // $saldoBunga = $saldo;
                        // $saldo += $jlhBunga;
                        $totalJumlahBunga += $jlhBunga;
                        $jlhBungaPph = (10 / 100) * $jlhBunga;
                        if ($jlhBunga <= 240000) { $jlhBungaPph=0; $jlhDiterima=$jlhBunga - $jlhBungaPph; } 
                        else { $jlhDiterima=$jlhBunga - $jlhBungaPph; } 
                        $totalTerima +=$jlhDiterima; 
                        $totalJumlahBungaPph += $jlhBungaPph;
                    @endphp 
                    <td class="text-right">
                        {{ number_format($jlhBunga, 0, ',', '.') }}
                        <input type="hidden" name="simulasi[ssb][dibayar][jlhBunga][{{ $i }}]" value="{{ $jlhBunga }}">
                    </td>
                    <td class="text-right">
                        <input type="hidden" name="simulasi[ssb][dibayar][bungapph][{{ $i }}]" value="{{ $jlhBungaPph }}">
                        {{ number_format($jlhBungaPph, 0, ',', '.') }}
                    </td>
                    <td class="text-right">
                        <input type="hidden" name="simulasi[ssb][dibayar][jumlahditerima][{{ $i }}]" value="{{ $jlhDiterima }}">
                        {{ number_format($jlhDiterima, 0, ',', '.') }}
                    </td>
                </tr>
                @endfor
                        <tr>
                            <th class="text-center"></th>
                            <th class="text-center"></th>
                            <th class="text-center">{{ $totalHari }}</th>
                            <th class="text-center"></th>
                            <th class="text-center"></th>
                            <th class="text-right">{{ number_format($totalJumlahBunga, 0, ',', '.') }}</th>
                            <th class="text-right"></th>
                            <th class="text-right">{{ number_format($totalTerima, 0, ',', '.') }}</th>
                            <input type="hidden" name="simulasi[ssb][dibayar][totalHari]" value="{{ $totalHari }}">
                            <input type="hidden" name="simulasi[ssb][dibayar][totalJumlahBunga]" value="{{ $totalJumlahBunga }}">

                        </tr>
            </tbody>
        </table>

    </div>
    @endif

    @if ($jenis_ssb == '')
    <h2>Silahkan Pilih Jenis SSB Terlebih Dahulu</h2>
    @endif
</div>