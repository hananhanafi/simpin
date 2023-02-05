<?php

namespace App\Http\Controllers\Data;

use App\Exports\PlafonPinjaman;
use Exception;
use Illuminate\Support\Str;
use App\Models\Data\Anggota;
use Illuminate\Http\Request;
use App\Models\Data\Pinjaman;
use App\Models\Data\Simpanan;
use App\Models\Data\Pencairan;
use App\Models\Data\Pelunasan;
use App\Models\Master\Produk;
use App\Helpers\FunctionHelper;
use App\Helpers\FinancialHelper;
use App\Exports\SimulasiPinjaman;
use Illuminate\Support\Facades\DB;
use App\Models\Data\PinjamanDetail;
use App\Http\Controllers\Controller;
use App\Models\Temp\Anggota as TempAnggota;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use App\Imports\ImportExcel;
use App\Models\Data\PembiayaanTransaksi;
use App\Models\Data\SimpananTransaksi;

class HrdController extends Controller
{


    public function show()
    {
        $tahun = date('Y');
        $bulan = date('n');

        return view('pages.data.hrd.show')
        ->with('tahun', $tahun)
        ->with('bulan', $bulan);
    }

    public function upload()
    {

        return view('pages.data.hrd.upload');
    }

    public function importXlsProses(Request $request){

        try{
            $tahun = date('Y');
            $bulan = date('n');
            DB::beginTransaction();
            $file = $request->file('file');
            $nama_file = time().'_'.$file->getClientOriginalName();
            $file->move('file',$nama_file);
            $files = public_path('file/'.$nama_file);
            $array = Excel::toArray(new ImportExcel, $files);

            $count = $already = 0;

            foreach($array[0] as $index => $value)
            {
                $anggota = Anggota::select(DB::raw('*'))
                ->with([
                    'simpananAnggota' => function ($q) use($tahun,$bulan) {
                        $q
                            ->with(['detailSimpas' => function ($q2) use($tahun,$bulan){
                                $q2
                                    ->whereNull('deleted_at')
                                    ->where('tahun',$tahun)
                                    ->where('bulan',$bulan);
                            }])
                            ->where([
                                ['produk_id', '=', 4],
                                ['status_rekening', '=', 1]
                            ]);
                    },
                    'pinjamanAnggota' => function ($q) use($tahun,$bulan) {
                        $q
                            ->with(['detail' => function ($q2) use($tahun,$bulan){
                                $q2
                                    ->whereNull('deleted_at')
                                    ->where('tahun',$tahun)
                                    ->where('bulan',$bulan);
                            }])
                            ->whereIn('status_rekening', [2, 3])
                            ->where('sisa_hutangs', '>', '0');
                    }
                ])
                ->where('no_anggota',$value[1])
                ->first();
                
                $simpananArr = json_decode(json_encode($anggota->simpananAnggota), true);
                $totalAngsuranSimpas = 0;
                if (count($simpananArr)>0 && count($simpananArr[0]['detail_simpas']) > 0) {
                    $detailsimpananArr = array_map(function ($val) {
                        return $val['tabungan_per_bulan'];
                    }, $simpananArr[0]['detail_simpas']);
                    $totalAngsuranSimpas = array_sum($detailsimpananArr);
                }
                $pinjamanArr = json_decode(json_encode($anggota->pinjamanAnggota), true);
                $totalAngsuran = 0;
                if (count($pinjamanArr)>0 && count($pinjamanArr[0]['detail']) > 0) {
                    $detailPinjamanArr = array_map(function ($val) {
                        return $val['total_angsuran'];
                    }, $pinjamanArr[0]['detail']);
                    $totalAngsuran = array_sum($detailPinjamanArr);
                }
                $totalPotongan = $totalAngsuranSimpas + $totalAngsuran;
                

                // dump($totalPotongan);
                // if($value[2]>=$totalPotongan){
                    foreach($pinjamanArr as $indexPinjaman => $pinjaman){
                        $pinjamanUpdate = Pinjaman::find($pinjaman['id']);
                        if($pinjamanUpdate->sisa_hutangs > 0){
                            $cicilan = PembiayaanTransaksi::select(DB::raw('*'))->where('id_pembiayaan',$pinjaman['id'])->get();
                            $cicilanKe = count($cicilan)+1;

                            $noTrans = $anggota->no_anggota . "_" . $pinjaman['id'] . "_PAYROLL_" . strval($cicilanKe);
                            $newPembiayaanTransaksi = new PembiayaanTransaksi();
                            $newPembiayaanTransaksi->no_rekening = $anggota->bank_norek;
                            $newPembiayaanTransaksi->tgl_trans = date('Y-m-d H:i:s');
                            $newPembiayaanTransaksi->no_trans = $noTrans;
                            $newPembiayaanTransaksi->kode_trans = $noTrans;
                            $newPembiayaanTransaksi->tipe_trans = 100;
                            $newPembiayaanTransaksi->cicilan_ke = $cicilanKe;
                            $newPembiayaanTransaksi->nilai_trans = $pinjaman['angsuran'];
                            $newPembiayaanTransaksi->margin_trans = 0;
                            $newPembiayaanTransaksi->keterangan = "PAYROLL";
                            $newPembiayaanTransaksi->user_trans = $anggota->no_anggota;
                            $newPembiayaanTransaksi->date_trans = date('Y-m-d H:i:s');
                            $newPembiayaanTransaksi->created_at = date('Y-m-d H:i:s');
                            $newPembiayaanTransaksi->id_pembiayaan = $pinjaman['id'];
                            $newPembiayaanTransaksi->save();

                            
                            $sisa_hutang =  $pinjamanUpdate->sisa_hutangs - $pinjaman['angsuran'];
                            $pinjamanUpdate->sisa_hutangs = $sisa_hutang;
                            $pinjamanUpdate->status_rekening = 3;
                            $pinjamanUpdate->nilai_pelunasan = $pinjamanUpdate->nilai_pelunasan + $pinjaman['angsuran'];
                            $pinjamanUpdate->save();
                        }
                    }

                    
                    foreach($simpananArr as $indexSimpanan => $simpanan){
                        $cicilan = SimpananTransaksi::select(DB::raw('*'))->where('id_simpanan',$simpanan['id'])->get();
                        $cicilanKe = count($cicilan)+1;
                        if($cicilanKe <= $simpanan['jangka_waktu']) {
                            $noTrans = $anggota->no_anggota . "_" . $simpanan['id'] . strval($cicilanKe);
                            $newSimpananTransaksi = new SimpananTransaksi();
                            $newSimpananTransaksi->no_rekening = $anggota->bank_norek;
                            $newSimpananTransaksi->tgl_trans = date('Y-m-d H:i:s');
                            $newSimpananTransaksi->no_trans = $noTrans;
                            $newSimpananTransaksi->kode_trans = strval($cicilanKe);
                            $newSimpananTransaksi->nilai_trans = $simpanan['setoran_per_bln'];
                            $newSimpananTransaksi->keterangan = "PAYROLL";
                            $newSimpananTransaksi->user_trans = $anggota->no_anggota;
                            $newSimpananTransaksi->date_trans = date('Y-m-d H:i:s');
                            $newSimpananTransaksi->created_at = date('Y-m-d H:i:s');
                            $newSimpananTransaksi->id_simpanan = $simpanan['id'];
                            $newSimpananTransaksi->save();
                        }
                    }
                // }
                $count++;
            }

            DB::commit();
            if($count == 0)
                Session::flash('fail','Import Data Payroll Tidak Berhasil');
            else
                Session::flash('success','Import Data Payroll Berhasil');

            return redirect()->route('data.hrd.upload');
        }
        catch(Exception $ex)
        {
            dd($ex);
            DB::rollback();
            if (config('app.env') == 'local') {
                Session::flash('fail',$ex->getMessage());
            } else {
                Session::flash('fail','Import Data Payroll Tidak Berhasil');
            }
            $message = $ex->getMessage();
            return redirect()->route('data.hrd.upload');
        }
    }
}
