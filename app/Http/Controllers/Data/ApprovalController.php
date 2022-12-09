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

class ApprovalController extends Controller
{
    public function produk()
    {
        return view('pages.approval.produk');
    }
    public function produkApprove(Request $request)
    {

        $produk = Produk::find($request->id_produk);

        if ($produk) {

            if (isset($request->keterangan)) {

                $produk->status_produk  = 1;
                $produk->approv_note    = $request->keterangan;
                $produk->approv_by      = Auth::user()->id;
                $produk->approv_date    = date('Y-m-d H:i:s');
                $produk->updated_by      = Auth::user()->id;
                $produk->updated_date    = date('Y-m-d H:i:s');
                $produk->save();

                Session::flash('success', 'Data Produk Telah Di Setujui');
            } else {
                $produk->status_produk  = 5;
                $produk->updated_by      = Auth::user()->id;
                $produk->updated_date    = date('Y-m-d H:i:s');
                $produk->save();
                Session::flash('success', 'Data Produk Telah Di Tolak');
            }
        } else {
            Session::flash('fail', 'Data Produk Tidak Di Temukan');
        }
        return redirect()->route('approval.produk');
    }

    ///ANGGOTA
    public function anggota()
    {
        return view('pages.approval.anggota');
    }
    public function anggotaApprove(Request $request)
    {
        // return $request;
        $anggota = Anggota::find($request->id_anggota);

        // return $anggota;
        if ($anggota) {


            if (isset($request->keterangan)) {




                if ($anggota->status_anggota == 4) {

                    $anggota->status_anggota  = 5;
                    $anggota->terminate_by    = Auth::user()->id;
                    $anggota->update_by       = Auth::user()->id;
                    $anggota->catatan           = $request->keterangan;
                    $anggota->terminate_date  = date('Y-m-d H:i:s');
                    $anggota->update_date     = date('Y-m-d H:i:s');
                    $anggota->save();

                    Session::flash('success', 'Data Anggota Telah Di Terminasi');
                } else {
                    $anggota->status_anggota    = 1;
                    $anggota->catatan           = $request->keterangan;
                    $anggota->update_by         = Auth::user()->id;
                    $anggota->update_date       = date('Y-m-d H:i:s');
                    $anggota->save();

                    Session::flash('success', 'Data Anggota Telah Di Aktivasi');
                }
            } else {
                $anggota->status_anggota  = 5;
                $anggota->update_by      = Auth::user()->id;
                $anggota->update_date    = date('Y-m-d H:i:s');
                $anggota->save();

                Session::flash('success', 'Data Anggota Telah Di Tolak');
            }
        } else {
            Session::flash('fail', 'Data Anggota Tidak Di Temukan');
        }
        return redirect()->route('approval.anggota');
    }


    ///ANGGOTA
    public function simpanan()
    {
        return view('pages.approval.simpanan');
    }
    public function simpananApprove(Request $request)
    {
        // return $request;
        $simpanan = Simpanan::find($request->id_simpanan);

        // return $anggota;
        if ($simpanan) {

            if (isset($request->keterangan)) {

                if ($simpanan->status_rekening == 4) {

                    $simpanan->status_rekening   = 5;
                    $simpanan->approv_note       = $request->keterangan;
                    $simpanan->update_by         = Auth::user()->id;
                    $simpanan->update_date       = date('Y-m-d H:i:s');
                    $simpanan->save();

                    Session::flash('success', 'Data Simpanan Telah Di Terminasi');
                } else {
                    $simpanan->status_rekening   = 1;
                    $simpanan->approv_note       = $request->keterangan;
                    $simpanan->update_by         = Auth::user()->id;
                    $simpanan->update_date       = date('Y-m-d H:i:s');
                    $simpanan->save();

                    Session::flash('success', 'Data Simpanan Telah Di Aktivasi');
                }
            } else {
                $simpanan->status_rekening  = 5;
                $simpanan->update_by      = Auth::user()->id;
                $simpanan->update_date    = date('Y-m-d H:i:s');
                $simpanan->save();

                Session::flash('success', 'Data Simpanan Tidak Di Approve');
            }
        } else {
            Session::flash('fail', 'Data Simpanan Tidak Di Temukan');
        }
        return redirect()->route('approval.simpanan');
    }

    ///PINJAMAN
    public function pinjaman()
    {
        return view('pages.approval.pinjaman');
    }
    public function pinjamanApprove(Request $request)
    {
        $pinjaman = Pinjaman::where('no_anggota', 'like', "%$request->no_anggota%")->first();


        // return $pinjaman;
        if ($pinjaman) {

            if (isset($request->keterangan)) {

                if ($pinjaman->status_rekening == 4) {

                    $pinjaman->status_rekening   = 5;
                    $pinjaman->approv_note       = $request->keterangan;
                    $pinjaman->update_by         = Auth::user()->id;
                    $pinjaman->update_date       = date('Y-m-d H:i:s');
                    $pinjaman->save();

                    Session::flash('success', 'Data Pinjaman Telah Di Terminasi');
                } else {
                    if ($pinjaman->approv_by == 1) {
                        $pinjaman->status_rekening   = 1;
                        $pinjaman->pencairan_by      = 0;
                        $pinjaman->update_by         = Auth::user()->id;
                        $pinjaman->pencairan_date    = '';
                        $pinjaman->save();

                        Session::flash('success', 'Data Pinjaman Telah Di Aktivasi');
                    } else {
                        $pinjaman->status_rekening   = 1;
                        $pinjaman->approv_note       = $request->keterangan;
                        $pinjaman->approv_by         = 1;
                        $pinjaman->update_by         = Auth::user()->id;
                        $pinjaman->update_date       = date('Y-m-d H:i:s');
                        $pinjaman->save();

                        Session::flash('success', 'Data Pinjaman Telah Di Aktivasi');
                    }
                }
            } else {
                $pinjaman->status_rekening  = 5;
                $pinjaman->update_by      = Auth::user()->id;
                $pinjaman->update_date    = date('Y-m-d H:i:s');
                $pinjaman->save();

                Session::flash('success', 'Data Pinjaman Tidak Di Approve');
            }
        } else {
            Session::flash('fail', 'Data Pinjaman Tidak Di Temukan');
        }
        return redirect()->route('approval.pinjaman');
    }

    ///SHU
    public function shu()
    {
        return view('pages.approval.shu');
    }
    public function shuApprove(Request $request)
    {
        // return $request;
        $Shu = Shu::where('uuid', 'like', "%$request->uuid%")->first();

        // return $pinjaman;
        if ($Shu) {

            if (isset($request->keterangan)) {

                $Shu->status   = 1;
                $Shu->approve_note       = $request->keterangan;
                $Shu->save();

                Session::flash('success', 'Data SHU Telah Di Aktivasi');
            } else {
                $Shu->status  = 5;
                $Shu->save();

                Session::flash('success', 'Data Pinjaman Tidak Di Approve');
            }
        } else {
            Session::flash('fail', 'Data Pinjaman Tidak Di Temukan');
        }
        return redirect()->route('approval.shu');
    }
}
