<?php

namespace App\Http\Controllers\Data;


use Exception;
use App\Exports\SimulasiSsb;
use App\Models\Data\Anggota;
use Illuminate\Http\Request;
use App\Models\Data\Simpanan;
use App\Models\Master\Produk;
use App\Exports\SimulasiSimpas;
use App\Helpers\FunctionHelper;
use App\Helpers\FinancialHelper;
use App\Models\Data\SimpananTutup;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Data\SimpananSsbDetail;
use Illuminate\Support\Facades\Session;
use App\Models\Data\SimpananSimpasDetail;
use App\Http\Requests\Data\RequestSimpanan;

class SimpananController extends Controller
{
    public function index()
    {
        return view('pages.data.simpanan.index');
    }

    public function create(Request $request)
    {

        $produk = Produk::whereHas('tipePr', function ($qry) {
            $qry->where('tipe_produk', 1);
        })->where('status_produk', 1)->orderBy('kode')->get();
        // return $produk;
        if ($request->jenis == 'simpas') {
            return view('pages.data.simpanan.create-simpas')
                ->with('produk', $produk)
                ->with('request', $request);
        } else {
            return view('pages.data.simpanan.create')
                ->with('produk', $produk)
                ->with('request', $request);
        }
    }

    public function store(RequestSimpanan $request)
    {
        // return $request;
        try {
            DB::beginTransaction();
            list($no_anggota, $nama) = explode('__', $request->no_anggota);

            $anggota    = Anggota::where('no_anggota', $no_anggota)->first();
            if ($anggota) {
                $simpanan   = Simpanan::select(DB::raw('substring(no_rekening,10)+1 as next_norek'))->where('no_anggota', $no_anggota)->orderBy('no_rekening', 'desc')->get();
                if ($simpanan->count() != 0) {
                    // $no_rekening = $simpanan->next_norek;
                    $no_rekening = $anggota->no_anggota . "1" . str_pad(($simpanan->count() + 1), 4, "0", STR_PAD_LEFT);
                } else {
                    $kode_norek = 1;
                    $no_rekening = $anggota->no_anggota . "1" . str_pad($kode_norek, 4, "0", STR_PAD_LEFT);
                }
                // return $no_rekening;
                list($produk_id, $tipe_produk) = explode('__', $request->produk_id);
                $insertSimpanan =  new Simpanan;
                $insertSimpanan->no_rekening        = $no_rekening;
                $insertSimpanan->no_anggota         = $no_anggota;
                $insertSimpanan->produk_id          = $produk_id;
                $insertSimpanan->jumlah_bunga       = $request->jumlah_bunga;
                $insertSimpanan->jumlah_bunga_efektif = $request->jumlah_bunga_efektif;
                $insertSimpanan->saldo_akhir        = str_replace('.', '', $request->saldo_minimal);
                $insertSimpanan->jangka_waktu       = $request->jumlah_bulan;
                $insertSimpanan->setoran_per_bln    = 0;
                $insertSimpanan->status_rekening    = 0;
                $insertSimpanan->created_date       = date('Y-m-d H:i:s');
                $insertSimpanan->created_by         = Auth::user()->id;
                $insertSimpanan->save();


                if (isset($request->simulasi)) {
                    $simulasis = $request->simulasi;
                    if (isset($simulasis['ssb'])) {
                        foreach ($simulasis['ssb'] as $jns => $simulasi) {

                            if (isset($simulasi['blnThn'])) {
                                $blnThn             = $simulasi['blnThn'];
                                $jlhHari            = $simulasi['jlhHari'];
                                $saldo              = $simulasi['saldo'];
                                $bungaHarian        = $simulasi['bungaHarian'];
                                $jlhBunga           = $simulasi['jlhBunga'];
                                $totalHari          = $simulasi['totalHari'];
                                $totalJumlahBunga   = $simulasi['totalJumlahBunga'];
                                $jumlahditerima     = $simulasi['jumlahditerima'];
                                $bungapph           = $simulasi['bungapph'];

                                foreach ($blnThn as $idx => $item) {

                                    list($getBulan, $getTahun) = explode('-', $item);


                                    $detail = new SimpananSsbDetail;
                                    $detail->simpanan_id        = $insertSimpanan->id;
                                    $detail->produk_id          = $produk_id;
                                    $detail->jenis              = $jns;
                                    $detail->bulan              = FunctionHelper::bulanSingkatToIndex($getBulan);
                                    $detail->tahun              = $getTahun;
                                    $detail->jlh_hari           = $jlhHari[$idx];
                                    $detail->saldo              = $saldo[$idx];
                                    $detail->pph                = $bungapph[$idx];
                                    $detail->bunga_dibayar      = $jumlahditerima[$idx];
                                    $detail->bunga_harian       = $bungaHarian[$idx];
                                    $detail->jlh_bunga          = $jlhBunga[$idx];
                                    $detail->total_hari         = $totalHari;
                                    $detail->total_jumlah_bunga = $totalJumlahBunga;
                                    $detail->save();
                                }
                            }
                        }
                    }
                    if (isset($simulasis['simpas'])) {
                        // foreach($simulasis['simpas'] as $jns => $simulasi){
                        // return $simulasis['simpas'];
                        if (isset($simulasis['simpas']['blnThn'])) {
                            $blnThn             = $simulasis['simpas']['blnThn'];
                            $tabunganPerBulan   = $simulasis['simpas']['tabunganPerBulan'];
                            $bungaHarian        = $simulasis['simpas']['bungaHarian'];
                            $saldoPerBulan      = $simulasis['simpas']['saldoPerBulan'];
                            $totalTabungan      = $simulasis['simpas']['totalTabungan'];
                            $totalBunga         = $simulasis['simpas']['totalBunga'];
                            $saldoTotal         = $simulasis['simpas']['saldoTotal'];
                            $saldoPembulatan    = $simulasis['simpas']['saldoPembulatan'];

                            foreach ($blnThn as $idx => $item) {

                                list($getBulan, $getTahun) = explode('-', $item);

                                $detail = new SimpananSimpasDetail;
                                $detail->simpanan_id            = $insertSimpanan->id;
                                $detail->produk_id              = $produk_id;
                                $detail->jenis                  = 'simpas';
                                $detail->bulan                  = FunctionHelper::bulanSingkatToIndex($getBulan);
                                $detail->tahun                  = $getTahun;
                                $detail->jlh_hari               = 0;
                                $detail->tabungan_per_bulan     = $tabunganPerBulan[$idx];
                                $detail->bunga_harian           = $bungaHarian[$idx];
                                $detail->saldo_per_bulan        = $saldoPerBulan[$idx];
                                $detail->total_tabungan         = $totalTabungan;
                                $detail->total_bunga            = $totalBunga;
                                $detail->total_saldo            = $saldoTotal;
                                $detail->total_saldo_pembulatan = $saldoPembulatan;
                                $detail->save();
                            }
                        }

                        // }
                    }
                }

                DB::commit();
                Session::flash('success', 'Simpan Data Simpanan Baru Berhasil dengan nomor Rekening : <b>' . $no_rekening . '</b>');
            } else {
                Session::flash('fail', 'Data Anggota Tidak Di Temukan');
                return redirect()->route('data.simpanan.create');
            }
        } catch (Exception $ex) {
            DB::rollback();
            if (config('app.env') == 'local')
                Session::flash('fail', $ex->getMessage());
            else
                Session::flash('fail', 'Simpan Data Simpanan Baru Tidak Berhasil');
        }
        return redirect()->route('data.simpanan.index');
    }

    public function show($id)
    {

        // return $simpanan;
        $simpanan     = Simpanan::where('id', $id)->with(['produk', 'anggota', 'detail', 'detailsimpas'])->first();
        return view('pages.data.simpanan.show')
            ->with('id', $id)
            ->with('simpanan', $simpanan);
    }

    public function penutupan(Request $request)
    {
        // return $request;
        try {
            DB::beginTransaction();
            $simpanan     = Simpanan::where('id', $request->id_simpanan)->first();
            if ($simpanan) {

                $simpanan->status_rekening  = 4;
                $simpanan->delete_note      = $request->keterangan;
                $simpanan->update_date      = date('Y-m-d H:i:s');
                $simpanan->update_by        = Auth::user()->id;
                $simpanan->saldo_akhir        = $request->saldo - ($request->pinalti + $request->pph);
                $simpanan->save();

                $anggota = Anggota::where('no_anggota', $request->no_anggota)->first();

                $tutup = new SimpananTutup;
                $tutup->simpanan_id     = $simpanan->id;
                $tutup->id_anggota      = $anggota->id;
                $tutup->no_rekening     = $request->no_rekening;
                $tutup->no_anggota      = $request->no_anggota;
                $tutup->nama            = $request->nama;
                $tutup->jenis_simpanan  = $request->jenis_simpanan;
                $tutup->tgl_pembukaan   = $request->tgl_pembukaan;
                // $tutup->saldo           = $request->saldo;
                $simpanan->saldo        = $request->saldo - ($request->pinalti + $request->pph);
                $tutup->pinalti         = $request->pinalti;
                $tutup->pph             = $request->pph;
                $tutup->keterangan      = $request->keterangan;
                $tutup->save();

                Session::flash('success', 'Data Penutupan Simpanan Berhasil Dilakukan, Akan menuggu Approval');
            } else {
                Session::flash('error', 'Data Simpanan Tidak Ditemukan');
            }
            DB::commit();
        } catch (Exception $ex) {
            DB::rollback();
            Session::flash('error', 'Terjadi Kesalahan');
        }
        return redirect()->route('data.simpanan.index');
    }

    public function pencairanApprove(Request $request)
    {
        $simpanan = Simpanan::find($request->id_simpanan);

        if ($simpanan) {
            if ($simpanan->status_rekening == 4) {

                $simpanan->status_rekening   = 5;
                $simpanan->update_by         = Auth::user()->id;
                $simpanan->update_date       = date('Y-m-d H:i:s');
                $simpanan->save();

                Session::flash('success', 'Data Pinjaman Telah Di Terminasi');
            } else {
                $simpanan->status_rekening   = 2;
                $simpanan->pencairan_by      = Auth::user()->id;
                $simpanan->pencairan_date    = date('Y-m-d H:i:s');
                $simpanan->update_by         = Auth::user()->id;
                $simpanan->update_date       = date('Y-m-d H:i:s');
                $simpanan->save();

                Session::flash('success', 'Data Pinjaman Telah Dicairkan');
            }
        } else {
            Session::flash('fail', 'Data Pinjaman Tidak Di Temukan');
        }
        return redirect()->route('data.pencairan.show', $simpanan->id);
    }

    public function detail($id)
    {

        $simpanan     = Simpanan::where('id', $id)->with(['produk', 'anggota', 'detail', 'detailsimpas'])->first();
        return $simpanan;
    }

    public function destroy($id)
    {
        $simpanan    = Simpanan::find($id);
        $simpanan->delete_date    = date('Y-m-d H:i:s');
        $simpanan->delete_by    = Auth::user()->id;
        $simpanan->delete();
        Session::flash('success', 'Hapus Data Simpanan Berhasil');
        return redirect()->route('data.simpanan.index');
    }
    

    public function plafon(Request $request)
    {

        $anggota = Anggota::where('no_anggota', '=', $request->no_anggota)->firstOrFail();
        $today = Date('Y-m-d H:i:s');
        // dd(gettype($anggota->masukkerja_date));
        // $interval = $anggota->masukkerja_date ? ($today->diff($today))->y : 0;
        // $workDateEpoch = strtotime($anggota->masukkerja_date);
        // $workDate = Date($workDateEpoch);
        // dd(gettype($today));
        // $interval = $anggota->masukkerja_date ? ($anggota->masukkerja_date->diff($today))->y : 0;
        $masa_kerja = $anggota->masukkerja_date ? date_diff(date_create($anggota->masukkerja_date), date_create())->y : 0;
        return view('pages.data.simpanan.plafon')
            ->with('anggota', $anggota)
            ->with('masa_kerja', $masa_kerja)
            ->with('request', $request);
    }

    public function simpasSimulasiXls(Request $request)
    {
        $saldo = str_replace('.', '', $request->saldo);
        $financial = new FinancialHelper;
        $bungaEfektif = abs($financial->RATE($request->bunga / 100, $request->bulan, $saldo));
        return Excel::download(new SimulasiSimpas($request->produk_id, $request->bunga, $request->bulan, $request->saldo, $bungaEfektif), 'SimulasiSimpas.xlsx');
    }

    public function ssbSimulasiXls(Request $request)
    {
        // return $request;
        $saldo = str_replace('.', '', $request->saldo);
        $financial = new FinancialHelper;
        $bungaEfektif = abs($financial->RATE($request->bunga / 100, $request->bulan, $saldo));
        // return $bungaEfektif;
        return Excel::download(new SimulasiSsb($request->produk_id, $request->bunga, $request->bulan, $request->saldo, $bungaEfektif), 'SimulasiSSB.xlsx');
    }

    public function sertif()
    {
        return view('pages.data.simpanan.sertif');
    }

    public function sertifPdf($id)
    {
        $simpanan     = Simpanan::where('id', $id)->with(['produk', 'anggota', 'detail', 'detailsimpas'])->first();
        // $produk     = Produk::where('id', $id)->with(['produk', 'anggota', 'detail', 'detailsimpas'])->first();
        // dd($simpanan->detail);
        return view('pages.data.simpanan.sertif-print')
            ->with('id', $id)
            ->with('simpanan', $simpanan);
    }
}
