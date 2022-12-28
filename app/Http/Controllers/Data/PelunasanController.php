<?php

namespace App\Http\Controllers\Data;

use App\Models\Data\Shu;
use App\Models\Data\Anggota;
use Illuminate\Http\Request;
use App\Models\Data\Pinjaman;
use App\Models\Data\Simpanan;
use App\Models\Master\Produk;
use App\Http\Controllers\Controller;
use App\Models\Data\PembiayaanTransaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Helpers\FinancialHelper;
use App\Helpers\FunctionHelper;
use Exception;
use App\Models\Data\PinjamanDetail;
use Illuminate\Support\Str;

class PelunasanController extends Controller
{
    public function index()
    {
        return view('pages.data.pinjaman.pelunasan');
    }
    public function addPelunasan(Request $request)
    {
        $pinjamanDetail   =   Pinjaman::selectRaw('t_pembiayaan.sisa_hutangs,t_pembiayaan.id, t_pembiayaan.no_anggota, t_pembiayaan.no_rekening, t_pembiayaan.produk_id, p_produk.kode, 
                                            p_produk.nama_produk, t_pembiayaan.jml_pinjaman, t_pembiayaan.jml_margin, 
                                            t_pembiayaan.jangka_waktu, t_pembiayaan.margin, t_pembiayaan.saldo_akhir_pokok, 
                                            t_pembiayaan.saldo_akhir_margin, t_pembiayaan.cicilan, t_pembiayaan.tanggal_mulai, 
                                            t_pembiayaan.tanggal_akhir, t_pembiayaan.created_date, t_pembiayaan.status_rekening, t_pembiayaan.nilai_pencairan,
                                            t_pembiayaan.admin_fee, t_pembiayaan.nilai_pelunasan, t_pembiayaan.dana_mengendap, t_pembiayaan.asuransi,t_pembiayaan.angsuran')
            ->leftJoin('p_produk', 't_pembiayaan.produk_id', '=', 'p_produk.id')
            ->where('t_pembiayaan.id', $request->idPinjaman)
            ->with('detail')
            ->firstOrFail();

        $pinjaman   =   Pinjaman::selectRaw('t_pembiayaan.sisa_hutangs,t_pembiayaan.id, t_pembiayaan.no_rekening, t_pembiayaan.produk_id, p_produk.kode, 
                p_produk.nama_produk, t_pembiayaan.jml_pinjaman, t_pembiayaan.jml_margin, 
                t_pembiayaan.jangka_waktu, t_pembiayaan.margin, t_pembiayaan.saldo_akhir_pokok, 
                t_pembiayaan.saldo_akhir_margin, t_pembiayaan.cicilan, t_pembiayaan.tanggal_mulai, 
                t_pembiayaan.tanggal_akhir, t_pembiayaan.created_date, t_pembiayaan.status_rekening, t_pembiayaan.nilai_pencairan,
                t_pembiayaan.admin_fee, t_pembiayaan.nilai_pelunasan, t_pembiayaan.dana_mengendap, t_pembiayaan.asuransi,t_pembiayaan.angsuran')
            ->leftJoin('p_produk', 't_pembiayaan.produk_id', '=', 'p_produk.id')
            ->where('t_pembiayaan.no_anggota', $pinjamanDetail->no_anggota)
            ->with('detail')
            ->get();

        $anggota    =   Anggota::leftJoin('p_departemen', 'p_departemen.id', '=', 't_anggota.departement_id')
            ->leftJoin('p_grade', 'p_grade.id', '=', 't_anggota.grade_id')
            ->where('t_anggota.no_anggota', $pinjamanDetail->no_anggota)
            ->first();

        $simpanan   =   Simpanan::selectRaw('t_simpanan.id, t_simpanan.no_rekening, t_simpanan.produk_id, p_produk.kode, p_produk.nama_produk, p_produk.tipe_produk, t_simpanan.saldo_akhir, t_simpanan.setoran_per_bln, t_simpanan.created_date, t_simpanan.status_rekening')
            ->leftJoin('p_produk', 't_simpanan.produk_id', '=', 'p_produk.id')
            ->where('t_simpanan.no_anggota', $pinjamanDetail->no_anggota)
            ->get();

        $pelunasan = PembiayaanTransaksi::selectRaw('*')
            ->where('t_pembiayaan_transaksi.id_pembiayaan', $request->idPinjaman)
            ->get();

        $getCicilan = PembiayaanTransaksi::selectRaw('max(cicilan_ke) as cicilan')
            ->where('t_pembiayaan_transaksi.id_pembiayaan', $request->idPinjaman)
            ->first();

        $cicilan = $getCicilan ? $getCicilan->cicilan + 1 : 1;
        $type_label = $request->type == 2 ? 'Pelunasan Dipercepat' : ($request->type == 3 ? 'Pelunasan Topup' : 'Pelunasan Sesuai Cicilan');

        // print($pinjaman);

        // return $pinjaman;
        $total_potongan = 0;
        // $total_pinjaman = array_sum(array_map(function($e){
        //     return is_object($e) ? $e->jml_pinjaman : $e['jml_pinjaman'];
        // },$pinjaman)); 

        // $total_pinjaman = array_column(array_map(function($o){return (array)$o;},$pinjaman),'jml_pinjaman');

        // $total_pinjaman = array_reduce( $pinjaman, function ($sum, $entry) {
        //     $sum += $entry->jml_pinjaman;
        //     return $sum;
        //   }, 0);

        // dump($pinjaman[0]->jml_pinjaman);
        // $pinjamanArr = (array) $pinjaman;
        $pinjamanArr = json_decode(json_encode($pinjaman), true);
        // dd($pinjamanArr);

        $total_pinjaman = array_sum(array_column($pinjamanArr, 'jml_pinjaman'));
        $total_pencairan = array_sum(array_column($pinjamanArr, 'nilai_pencairan'));
        $total_admin = array_sum(array_column($pinjamanArr, 'admin_fee'));
        $total_asuransi = array_sum(array_column($pinjamanArr, 'asuransi'));
        $total_pelunasan = array_sum(array_column($pinjamanArr, 'nilai_pelunasan'));
        $total_dana_mengendap = array_sum(array_column($pinjamanArr, 'dana_mengendap'));
        $anggota->total_pinjaman = $total_pinjaman;
        $anggota->total_pencairan = $total_pencairan;
        $anggota->total_admin = $total_admin;
        $anggota->total_asuransi = $total_asuransi;
        $anggota->total_pelunasan = $total_pelunasan;
        $anggota->total_dana_mengendap = $total_dana_mengendap;


        $produk     = Produk::whereHas('tipePr', function ($qry) {
            $qry->where('tipe_produk', 2);
        })->where('status_produk', 1)->orderBy('kode')->get();


        return view('pages.data.pelunasan.addPelunasan')
            ->with('produk', $produk)
            ->with('simpanan', $simpanan)
            ->with('pinjaman', $pinjaman)
            ->with('pelunasan', $pelunasan)
            ->with('pinjamanDetail', $pinjamanDetail)
            ->with('total_potongan', $total_potongan)
            ->with('request', $request)
            ->with('type_label', $type_label)
            ->with('cicilan', $cicilan)
            ->with('anggota', $anggota);
    }

    public function pelunasanCicilan(Request $request)
    {
        // dd($request);

        // return $pinjaman;
        try {
            // return $request;
            DB::beginTransaction();
            $pinjaman = Pinjaman::find($request->id_pinjaman);
            if ($request->type == 2) {
                $cicilanke = $request->cicilan;
                for ($i = 1; $i <= ($request->jumlah_cicilan); $i++) {

                    list($noRekening, $noAnggota)          = explode('__', $request->no_rekening);
                    $jumlahPinjaman = intVal(str_replace('.', '', $request->jumlah_pinjaman));
                    $sisaHutang = intVal(str_replace('.', '', $request->sisa_hutang));
                    $nilaiTrans = intVal(str_replace('.', '', $request->nilai_trans));

                    $transAmount = $nilaiTrans / $request->jumlah_cicilan;
                    $noTrans = $request->no_anggota . "_" . $request->id_pinjaman . "_" . $request->type . "_" . $cicilanke;
                    $newPembiayaanTransaksi = new PembiayaanTransaksi();
                    $newPembiayaanTransaksi->no_rekening = $noRekening;
                    $newPembiayaanTransaksi->tgl_trans = $request->tgl_trans;
                    $newPembiayaanTransaksi->no_trans = $noTrans;
                    $newPembiayaanTransaksi->kode_trans = $noTrans;
                    $newPembiayaanTransaksi->tipe_trans = $request->type;
                    $newPembiayaanTransaksi->cicilan_ke = $cicilanke;
                    $newPembiayaanTransaksi->nilai_trans = $transAmount;
                    $newPembiayaanTransaksi->margin_trans = 0;
                    $newPembiayaanTransaksi->keterangan = "";
                    $newPembiayaanTransaksi->user_trans = $noAnggota;
                    $newPembiayaanTransaksi->date_trans = $request->tgl_trans;
                    $newPembiayaanTransaksi->created_at = date('Y-m-d H:i:s');
                    $newPembiayaanTransaksi->id_pembiayaan = $request->id_pinjaman;
                    $newPembiayaanTransaksi->save();
                    $cicilanke++;
                }
            } else if ($request->type == 3) {
                // dd($request->pinjaman['produk_id']);
                $cicilanke = $request->cicilan_ke;
                // $jumlahCicilan = (intVal($request->jangka_waktu) - intVal($cicilanke)-1);
                $nilaiTrans = intVal(str_replace('.', '', $request->total_pelunasan));
                $jumlahPinjaman = intVal(str_replace('.', '', $request->pinjaman['jumlah_pinjaman']));
                $nilaiPelunasanHutangLama = intVal(str_replace('.', '', $request->total_pelunasan));
                $asuransi = intVal(str_replace('.', '', $request->pinjaman['asuransi']));
                $adminFee = intVal(str_replace('.', '', $request->pinjaman['admin_bank']));
                $bulan          = $request->pinjaman['jumlah_bulan'];
                $bunga          = $request->pinjaman['jumlah_bunga'];
                $margin         = $bunga / 100 * $jumlahPinjaman;
                $sisaHutang         = $jumlahPinjaman + $margin;
                $totalAngsuran      = $sisaHutang / $bulan;
                if ($bulan >= 12) {
                    $danaditahan = $totalAngsuran;
                } else {
                    $danaditahan = 0;
                }
                $nilaiPencairan = $jumlahPinjaman - ($asuransi + $adminFee + $danaditahan + $nilaiPelunasanHutangLama);

                // dd($nilaiPencairan);

                if ($nilaiPencairan < 0) {
                    DB::rollback();
                    Session::flash('fail', 'Jumlah pencairan tidak boleh lebih kecil dari sisa hutang');
                    return back();
                }

                for ($i = $cicilanke; $i <= ($request->jangka_waktu); $i++) {

                    $angsuran = intVal(str_replace('.', '', $request->angsuran));
                    // $transAmount = $request->jumlah_cicilan;
                    $noTrans = $request->no_anggota . "_" . $request->id_pinjaman . "_" . $request->type . "_" . $i;
                    $newPembiayaanTransaksi = new PembiayaanTransaksi();
                    $newPembiayaanTransaksi->no_rekening = $request->anggota_no_rekening;
                    $newPembiayaanTransaksi->tgl_trans = date('Y-m-d H:i:s');
                    $newPembiayaanTransaksi->no_trans = $noTrans;
                    $newPembiayaanTransaksi->kode_trans = $noTrans;
                    $newPembiayaanTransaksi->tipe_trans = $request->type;
                    $newPembiayaanTransaksi->cicilan_ke = $i;
                    $newPembiayaanTransaksi->nilai_trans = $angsuran;
                    $newPembiayaanTransaksi->margin_trans = 0;
                    $newPembiayaanTransaksi->keterangan = "";
                    $newPembiayaanTransaksi->user_trans = $request->no_anggota;
                    $newPembiayaanTransaksi->date_trans = date('Y-m-d H:i:s');
                    $newPembiayaanTransaksi->created_at = date('Y-m-d H:i:s');
                    $newPembiayaanTransaksi->id_pembiayaan = $request->id_pinjaman;
                    $newPembiayaanTransaksi->save();
                }


                list($idProduk, $tipeProduk, $namaProduk) = explode('__', $request->pinjaman['produk_id']);
                $rekening       = Simpanan::where('no_anggota', $request->no_anggota)->first();
                // $jumlahPinjamanBaru = intVal(str_replace('.', '', $request->pinjaman['jumlah_pinjaman_baru']));
                $totalPinjaman  = $margin + $jumlahPinjaman;
                $sisaPokok          = $jumlahPinjaman;
                $totalAngsuranPokok = $totalAngsuranMargin = $subTotalAngsuran = 0;


                $newPinjaman                    = new Pinjaman();
                $newPinjaman->no_rekening       = $request->anggota_no_rekening;
                $newPinjaman->no_anggota        = $request->no_anggota;
                $newPinjaman->produk_id         = $idProduk;
                $newPinjaman->norek_simpanan    = ($rekening) ? $rekening->no_rekening : '';
                $newPinjaman->jml_pinjaman      = $jumlahPinjaman;
                $newPinjaman->jml_margin        = $margin;
                $newPinjaman->total_pinjaman    = $totalPinjaman;
                $newPinjaman->sisa_hutangs    = $sisaHutang;
                $newPinjaman->jangka_waktu      = $request->pinjaman['jumlah_bulan'];
                $newPinjaman->margin            = $request->pinjaman['jumlah_bunga_efektif'];
                $newPinjaman->asuransi          = $asuransi;
                $newPinjaman->admin_fee          = $adminFee;
                $newPinjaman->saldo_akhir_pokok = $sisaPokok;
                $newPinjaman->saldo_akhir_margin = 0;
                $newPinjaman->cicilan           = 0;
                $newPinjaman->rev_margin        = 0;
                $newPinjaman->status_rekening   = 1;
                $newPinjaman->nilai_pelunasan   = 0;
                $newPinjaman->pelunasan_note    = '-';
                $newPinjaman->penutupan_note    = '-';
                $newPinjaman->tanggal_mulai     = date('Y-m-d H:i:s');
                $newPinjaman->tanggal_akhir     = date('Y-m-d H:i:s');
                $newPinjaman->created_date      = date('Y-m-d H:i:s');
                // $newPinjaman->update_date       = date('Y-m-d');
                // $newPinjaman->pencairan_date    = date('Y-m-d');
                // $newPinjaman->approv_date       = date('Y-m-d');
                // $newPinjaman->approv_lunas_date = date('Y-m-d');
                // $newPinjaman->delete_date       = date('Y-m-d');
                $newPinjaman->created_by        = Auth::user()->id;
                $newPinjaman->update_by         = 0;
                $newPinjaman->approv_by         = 0;
                $newPinjaman->pencairan_by      = 0;
                $newPinjaman->approv_note       = '-';
                $newPinjaman->approv_lunas_by   = 0;
                $newPinjaman->delete_by         = 0;

                $newPinjaman->status_rekening   = 1;
                $newPinjaman->approv_note       = "PELUNASAN TOPUP";
                $newPinjaman->approv_by         = 1;
                $newPinjaman->update_by         = Auth::user()->id;
                $newPinjaman->update_date       = date('Y-m-d H:i:s');

                // $newPinjaman->save();


                // $newPinjaman->angsuran         = $totalAngsuran;
                $newPinjaman->angsuran        = $totalAngsuran;
                $newPinjaman->dana_mengendap        = $danaditahan;
                $newPinjaman->nilai_pencairan   = $nilaiPencairan;
                $newPinjaman->save();

                $financial          = new FinancialHelper;
                $startBulan         = date('n');
                $startTahun         = date('Y');
                $rangeBulan = FunctionHelper::rangeBulan($startBulan, $startTahun, $bulan + 1);
                $bungaEfektif   = $request->pinjaman['jumlah_bunga_efektif'];
                $saldo              = $jumlahPinjaman;
                $idPinjaman = $newPinjaman->id;

                for ($i = 1; $i <= ($request->pinjaman['jumlah_bulan']); $i++) {
                    $angsuran       = round(abs($financial->PPMT(($bungaEfektif / 100) / $bulan, $i, $bulan, $saldo)));
                    $angsuranMargin = $totalAngsuran - $angsuran;

                    $pinjamanDetail                 = new PinjamanDetail();
                    $pinjamanDetail->uuid           = Str::uuid();
                    $pinjamanDetail->tabungan_id    = $idPinjaman;
                    $pinjamanDetail->bulan          = isset($rangeBulan[0][$i]['bln']) ? $rangeBulan[0][$i]['bln'] : 0;
                    $pinjamanDetail->tahun          = isset($rangeBulan[0][$i]['thn']) ? $rangeBulan[0][$i]['thn'] : 0;;
                    $pinjamanDetail->jlh_hari       = isset($rangeBulan[0][$i]['jlh_hari']) ? $rangeBulan[0][$i]['jlh_hari'] : 0;
                    $pinjamanDetail->bunga_flat     = $bungaEfektif;
                    $pinjamanDetail->bunga_pa       = $bunga;
                    $pinjamanDetail->sisa_hutang    = $sisaHutang;
                    $pinjamanDetail->sisa_pokok     = $sisaPokok;
                    $pinjamanDetail->angsuran_pokok = $angsuran;
                    $pinjamanDetail->angsuran_margin = $angsuranMargin;
                    $pinjamanDetail->total_angsuran = $totalAngsuran;
                    $pinjamanDetail->save();

                    $sisaPokok -= $angsuran;
                    $sisaHutang -= $totalAngsuran;
                    $subTotalAngsuran += $totalAngsuran;
                    $totalAngsuranPokok += $angsuran;
                    $totalAngsuranMargin += $angsuranMargin;
                }
            } else {

                $noTrans = $request->no_anggota . "_" . $request->id_pinjaman . "_" . $request->type . "_" . $request->cicilan;
                list($noRekening, $noAnggota)          = explode('__', $request->no_rekening);
                $jumlahPinjaman = intVal(str_replace('.', '', $request->jumlah_pinjaman));
                $sisaHutang = intVal(str_replace('.', '', $request->sisa_hutang));
                $nilaiTrans = intVal(str_replace('.', '', $request->nilai_trans));

                $newPembiayaanTransaksi = new PembiayaanTransaksi();
                $newPembiayaanTransaksi->no_rekening = $noRekening;
                $newPembiayaanTransaksi->tgl_trans = $request->tgl_trans;
                $newPembiayaanTransaksi->no_trans = $noTrans;
                $newPembiayaanTransaksi->kode_trans = $noTrans;
                $newPembiayaanTransaksi->tipe_trans = $request->type;
                $newPembiayaanTransaksi->cicilan_ke = $request->cicilan;
                $newPembiayaanTransaksi->nilai_trans = $nilaiTrans;
                $newPembiayaanTransaksi->margin_trans = 0;
                $newPembiayaanTransaksi->keterangan = "";
                $newPembiayaanTransaksi->user_trans = $noAnggota;
                $newPembiayaanTransaksi->date_trans = $request->tgl_trans;
                $newPembiayaanTransaksi->created_at = date('Y-m-d H:i:s');
                $newPembiayaanTransaksi->id_pembiayaan = $request->id_pinjaman;
                $newPembiayaanTransaksi->save();
            }
            $sisa_hutang =  $pinjaman->sisa_hutangs - $nilaiTrans;
            $pinjaman->sisa_hutangs = $sisa_hutang;
            $pinjaman->status_rekening = 3;
            $pinjaman->nilai_pelunasan = $pinjaman->nilai_pelunasan + $nilaiTrans;
            $pinjaman->save();


            DB::commit();
            Session::flash('success', 'Simpan Data Pelunasan Baru Berhasil');
            return redirect()->route('data.pelunasan.index');
        } catch (Exception $er) {
            DB::rollback();
            if (config('app.env') == 'local')
                Session::flash('fail', $er->getMessage() . ', Baris: ' . $er->getLine());
            else
                Session::flash('fail', 'Simpan Data Pelunasan Baru Tidak Berhasil');

            return redirect()->route('data.pelunasan.index');
        }
        return redirect()->route('data.pelunasan.index');
    }
}
