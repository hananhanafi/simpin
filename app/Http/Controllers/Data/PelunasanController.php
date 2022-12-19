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
use Exception;

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


        return view('pages.data.pelunasan.addPelunasan')
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
            $noTrans = $request->no_anggota . "_" . $request->id_pinjaman . "_" . $request->type . "_" . $request->cicilan;
            list($noRekening, $noAnggota)          = explode('__', $request->no_rekening);
            $jumlahPinjaman = intVal(str_replace('.', '', $request->jumlah_pinjaman));
            $sisaHutang = intVal(str_replace('.', '', $request->sisa_hutang));
            $nilaiTrans = intVal(str_replace('.', '', $request->nilai_trans));
            if($request->type==2){
                $cicilanke = $request->cicilan;
                for ($i = 1; $i <= ($request->jumlah_cicilan); $i++) {
                    $transAmount = $nilaiTrans/$request->jumlah_cicilan;
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
            }
            else{
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
