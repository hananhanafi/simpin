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

class PinjamanController extends Controller
{
    public function index()
    {
        return view('pages.data.pinjaman.index');
    }
    public function show($idPinjaman)
    {
        $pinjamanAnggota = Pinjaman::find($idPinjaman);


        $anggota    =   Anggota::leftJoin('p_departemen', 'p_departemen.id', '=', 't_anggota.departement_id')
            ->leftJoin('p_grade', 'p_grade.id', '=', 't_anggota.grade_id')
            ->where('t_anggota.no_anggota', $pinjamanAnggota->no_anggota)
            ->first();

        $simpanan   =   Simpanan::selectRaw('t_simpanan.id, t_simpanan.no_rekening, t_simpanan.produk_id, p_produk.kode, p_produk.nama_produk, p_produk.tipe_produk, t_simpanan.saldo_akhir, t_simpanan.setoran_per_bln, t_simpanan.created_date, t_simpanan.status_rekening')
            ->leftJoin('p_produk', 't_simpanan.produk_id', '=', 'p_produk.id')
            ->where('t_simpanan.no_anggota',  $pinjamanAnggota->no_anggota)
            ->get();
            
        $pinjaman   =   Pinjaman::selectRaw('t_pembiayaan.sisa_hutangs,t_pembiayaan.id, t_pembiayaan.no_rekening, t_pembiayaan.produk_id, p_produk.kode, 
            p_produk.nama_produk, t_pembiayaan.jml_pinjaman, t_pembiayaan.jml_margin, 
            t_pembiayaan.jangka_waktu, t_pembiayaan.margin, t_pembiayaan.saldo_akhir_pokok, 
            t_pembiayaan.saldo_akhir_margin, t_pembiayaan.cicilan, t_pembiayaan.tanggal_mulai, 
            t_pembiayaan.tanggal_akhir, t_pembiayaan.created_date, t_pembiayaan.status_rekening')
            ->leftJoin('p_produk', 't_pembiayaan.produk_id', '=', 'p_produk.id')
            ->where('t_pembiayaan.no_anggota', $pinjamanAnggota->no_anggota)
            ->with('detail')
            ->get();

        // return $pinjaman;
        $total_potongan = 0;
        return view('pages.data.pinjaman.show')
            ->with('simpanan', $simpanan)
            ->with('pinjaman', $pinjaman)
            ->with('total_potongan', $total_potongan)
            ->with('anggota', $anggota);
    }

    public function showPencairan($nomorAnggota)
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
                                            t_pembiayaan.tanggal_akhir, t_pembiayaan.created_date, t_pembiayaan.status_rekening')
            ->leftJoin('p_produk', 't_pembiayaan.produk_id', '=', 'p_produk.id')
            ->where('t_pembiayaan.no_anggota', $nomorAnggota)
            ->with('detail')
            ->get();

        // return $pinjaman;
        $total_potongan = 0;
        return view('pages.data.pinjaman.showPencairan')
            ->with('simpanan', $simpanan)
            ->with('pinjaman', $pinjaman)
            ->with('total_potongan', $total_potongan)
            ->with('anggota', $anggota);
    }

    public function create(Request $request)
    {
        $produk     = Produk::whereHas('tipePr', function ($qry) {
            $qry->where('tipe_produk', 2);
        })->where('status_produk', 1)->orderBy('kode')->get();
        return view('pages.data.pinjaman.create')
            ->with('produk', $produk)
            ->with('request', $request);
    }

    public function addPencairan(Request $request)
    {
        $produk     = Produk::whereHas('tipePr', function ($qry) {
            $qry->where('tipe_produk', 2);
        })->where('status_produk', 1)->orderBy('kode')->get();
        return view('pages.data.pinjaman.addPencairan')
            ->with('produk', $produk)
            ->with('request', $request);
    }

    public function addPelunasan(Request $request)
    {
        $produk     = Produk::whereHas('tipePr', function ($qry) {
            $qry->where('tipe_produk', 2);
        })->where('status_produk', 1)->orderBy('kode')->get();
        return view('pages.data.pinjaman.addPelunasan')
            ->with('produk', $produk)
            ->with('request', $request);
    }

    public function store(Request $request)
    {
        try {
            // return $request;
            DB::beginTransaction();
            list($noAnggota, $namaAnggota)          = explode('__', $request->no_anggota);
            list($idProduk, $tipeProduk, $namaProduk) = explode('__', $request->produk_id);

            $getPinjaman   = Pinjaman::select(DB::raw('substring(no_rekening,10)+1 as next_norek'))->where('no_anggota', $noAnggota)->orderBy('no_rekening', 'desc')->get();
            if ($getPinjaman->count() != 0) {
                // $no_rekening = $simpanan->next_norek;
                $no_rekening = $noAnggota . "2" . str_pad(($getPinjaman->count() + 1), 4, "0", STR_PAD_LEFT);
            } else {
                $kode_norek = 1;
                $no_rekening = $noAnggota . "2" . str_pad($kode_norek, 4, "0", STR_PAD_LEFT);
            }

            $rekening       = Simpanan::where('no_anggota', $noAnggota)->first();


            $bungaEfektif   = $request->jumlah_bunga_efektif;
            
            $jumlahPinjaman = intVal(str_replace('.', '', $request->jumlah_pinjaman));
            $asuransi = intVal(str_replace('.', '', $request->asuransi));
            $adminFee = intVal(str_replace('.', '', $request->admin_bank));
            $nilaiPencairan = $jumlahPinjaman - ($asuransi + $adminFee);

            $margin         = $bungaEfektif / 100 * $jumlahPinjaman;
            $totalPinjaman  = $margin + $jumlahPinjaman;
            $bulan          = $request->jumlah_bulan;
            $bunga          = $request->jumlah_bunga;
            $bunga_efektif  = $bungaEfektif;

            $saldo              = $jumlahPinjaman;
            $tabPerBulan        = FunctionHelper::hitungSimpas($bulan, $bunga_efektif, $bunga, $jumlahPinjaman);
            $saldoPerBulan      = 0;
            $saldoPerBulan      = $tabPerBulan;
            $totalBunga         = 0;
            $sisaHutang         = $jumlahPinjaman + $margin;
            $totalAngsuran      = $sisaHutang / $bulan;
            $sisaPokok          = $jumlahPinjaman;
            $totalAngsuranPokok = $totalAngsuranMargin = $subTotalAngsuran = 0;

            $newPinjaman                    = new Pinjaman();
            $newPinjaman->no_rekening       = $no_rekening;
            $newPinjaman->no_anggota        = $noAnggota;
            $newPinjaman->produk_id         = $idProduk;
            $newPinjaman->norek_simpanan    = ($rekening) ? $rekening->no_rekening : '';
            $newPinjaman->jml_pinjaman      = $jumlahPinjaman;
            $newPinjaman->jml_margin        = $margin;
            $newPinjaman->total_pinjaman    = $totalPinjaman;
            $newPinjaman->jangka_waktu      = $request->jumlah_bulan;
            $newPinjaman->margin            = $request->jumlah_bunga_efektif;
            $newPinjaman->asuransi          = $asuransi;
            $newPinjaman->admin_fee          = $adminFee;
            $newPinjaman->saldo_akhir_pokok = $sisaPokok;
            $newPinjaman->saldo_akhir_margin = 0;
            $newPinjaman->cicilan           = 0;
            $newPinjaman->rev_margin        = 0;
            $newPinjaman->status_rekening   = 0;
            $newPinjaman->nilai_pencairan   = $nilaiPencairan;
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
            $newPinjaman->save();

            $idPinjaman = $newPinjaman->id;


            $financial          = new FinancialHelper;
            $startBulan         = date('n');
            $startTahun         = date('Y');
            $rangeBulan = FunctionHelper::rangeBulan($startBulan, $startTahun, $bulan + 1);

            for ($i = 1; $i <= ($request->jumlah_bulan); $i++) {
                $bungaPerBulan  = ($bunga * $saldoPerBulan) / 100 / 12;
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

            DB::commit();
            Session::flash('success', 'Simpan Data Pinjaman Baru Berhasil dengan nomor Rekening : <b>' . $no_rekening . '</b>, Dan Menunggu Approval');
            return redirect()->route('data.pinjaman.index');
        } catch (Exception $er) {
            DB::rollback();
            if (config('app.env') == 'local')
                Session::flash('fail', $er->getMessage() . ', Baris: ' . $er->getLine());
            else
                Session::flash('fail', 'Simpan Data Simpanan Baru Tidak Berhasil');

            return redirect()->route('data.pinjaman.index');
        }
    }

    public function simulasi(Request $request)
    {
        $produk     = Produk::whereHas('tipePr', function ($qry) {
            $qry->where('tipe_produk', 2);
        })->where('status_produk', 1)->orderBy('kode')->get();
        // return $produk;


        return view('pages.data.pinjaman.simulasi')
            ->with('produk', $produk)
            ->with('request', $request);
    }

    public function plafon(Request $request)
    {

        $anggota = Anggota::where('no_anggota', '=', $request->no_anggota)->firstOrFail();
        return view('pages.data.pinjaman.plafon')
            ->with('anggota', $anggota)
            ->with('request', $request);
    }

    public function mutasi(Request $request)
    {
        return view('layouts.underconstruction');
    }

    public function pinjamanSimulasiXls(Request $request)
    {

        return Excel::download(new SimulasiPinjaman($request->produk_id, $request->bunga, $request->bulan, $request->saldo, $request->bunga_efektif), 'SimulasiPinjaman.xlsx');
    }
    public function pencairan(Request $request)
    {

        //$pinjaman = Pinjaman::where('no_anggota', 'like', "%$request->no_anggota%")->first();
        return view('pages.data.pinjaman.pencairan');
        //->with('anggota', $pinjaman)
        // ->with('request', $request);
    }

    public function pelunasan(Request $request)
    {
        return view('pages.data.pinjaman.pelunasan');
    }

    public function pinjamanPengajuanXls(Request $request)
    {
        // return $request;

        return Excel::download(new SimulasiPinjaman($request->produk_id, $request->bunga, $request->bulan, $request->saldo, $request->bunga_efektif, $request->no_anggota), 'Pengajuan Pinjaman - ' . $request->no_anggota . '.xlsx');
    }

    public function plafonXls(Request $request)
    {
        // return $request;

        return Excel::download(new PlafonPinjaman($request->no_anggota, $request->masa, $request->gaji, $request->pbulan, $request->jml_pengajuan_baru, $request->angsuran), 'Plafon Pinjaman - ' . $request->no_anggota . '.xlsx');
    }
}
