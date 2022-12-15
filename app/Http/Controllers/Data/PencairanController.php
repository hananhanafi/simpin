<?php

namespace App\Http\Controllers\Data;

use App\Models\Data\Shu;
use App\Models\Data\Anggota;
use Illuminate\Http\Request;
use App\Models\Data\Pinjaman;
use App\Models\Data\Simpanan;
use App\Models\Master\Produk;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PencairanController extends Controller
{
    public function show($nomorAnggota)
    {
        $anggota    =   Anggota::leftJoin('p_departemen', 'p_departemen.id', '=', 't_anggota.departement_id')
            ->leftJoin('p_grade', 'p_grade.id', '=', 't_anggota.grade_id')
            ->where('t_anggota.no_anggota', $nomorAnggota)
            ->first();

        $simpanan   =   Simpanan::selectRaw('t_simpanan.id, t_simpanan.no_rekening, t_simpanan.produk_id, p_produk.kode, p_produk.nama_produk, p_produk.tipe_produk, t_simpanan.saldo_akhir, t_simpanan.setoran_per_bln, t_simpanan.created_date, t_simpanan.status_rekening')
            ->leftJoin('p_produk', 't_simpanan.produk_id', '=', 'p_produk.id')
            ->where('t_simpanan.no_anggota', $nomorAnggota)
            ->get();

        $pinjaman   =   Pinjaman::selectRaw('t_pembiayaan.sisa_hutangs,t_pembiayaan.id, t_pembiayaan.no_rekening, t_pembiayaan.produk_id, p_produk.kode, 
                                            p_produk.nama_produk, t_pembiayaan.jml_pinjaman, t_pembiayaan.jml_margin, 
                                            t_pembiayaan.jangka_waktu, t_pembiayaan.margin, t_pembiayaan.saldo_akhir_pokok, 
                                            t_pembiayaan.saldo_akhir_margin, t_pembiayaan.cicilan, t_pembiayaan.tanggal_mulai, 
                                            t_pembiayaan.tanggal_akhir, t_pembiayaan.created_date, t_pembiayaan.status_rekening, t_pembiayaan.nilai_pencairan,
                                            t_pembiayaan.admin_fee, t_pembiayaan.nilai_pelunasan, t_pembiayaan.dana_mengendap, t_pembiayaan.asuransi')
            ->leftJoin('p_produk', 't_pembiayaan.produk_id', '=', 'p_produk.id')
            ->where('t_pembiayaan.no_anggota', $nomorAnggota)
            ->with('detail')
            ->get();

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


        return view('pages.data.pinjaman.showPencairan')
            ->with('simpanan', $simpanan)
            ->with('pinjaman', $pinjaman)
            ->with('total_potongan', $total_potongan)
            ->with('anggota', $anggota);
    }

    public function pencairanApprove(Request $request)
    {
        // $pinjaman = Pinjaman::where('id', '=', "$request->id_pinjaman")->first();
        $pinjaman = Pinjaman::find($request->id_pinjaman);

        // return $pinjaman;
        if ($pinjaman) {


            if ($pinjaman->status_rekening == 4) {

                $pinjaman->status_rekening   = 5;
                $pinjaman->update_by         = Auth::user()->id;
                $pinjaman->update_date       = date('Y-m-d H:i:s');
                $pinjaman->save();

                Session::flash('success', 'Data Pinjaman Telah Di Terminasi');
            } else {
                $pinjaman->status_rekening   = 2;
                $pinjaman->pencairan_by      = Auth::user()->id;
                $pinjaman->pencairan_date    = date('Y-m-d H:i:s');
                $pinjaman->update_by         = Auth::user()->id;
                $pinjaman->update_date       = date('Y-m-d H:i:s');
                $pinjaman->save();

                Session::flash('success', 'Data Pinjaman Telah Dicairkan');

                // if ($pinjaman->approv_by == 1) {
                //     $pinjaman->status_rekening   = 1;
                //     $pinjaman->pencairan_by      = 0;
                //     $pinjaman->update_by         = Auth::user()->id;
                //     $pinjaman->pencairan_date    = '';
                //     $pinjaman->save();

                //     Session::flash('success', 'Data Pinjaman Telah Dicairkan');
                // } else {
                //     $pinjaman->status_rekening   = 1;
                //     $pinjaman->approv_note       = $request->keterangan;
                //     $pinjaman->approv_by         = 1;
                //     $pinjaman->update_by         = Auth::user()->id;
                //     $pinjaman->update_date       = date('Y-m-d H:i:s');
                //     $pinjaman->save();

                //     Session::flash('success', 'Data Pinjaman Telah Dicairkan');
                // }
            }
        } else {
            Session::flash('fail', 'Data Pinjaman Tidak Di Temukan');
        }
        return redirect()->route('data.pencairan.show', $pinjaman->no_anggota);
    }
}
