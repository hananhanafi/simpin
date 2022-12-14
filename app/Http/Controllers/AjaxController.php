<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Support\Str;
use App\Models\Data\Anggota;
use Illuminate\Http\Request;
use App\Models\Master\Produk;
use App\Helpers\FunctionHelper;
use App\Helpers\FinancialHelper;
use App\Models\Data\Pinjaman;
use Illuminate\Routing\Controller;
use App\Models\Master\ProdukMargin;

class AjaxController extends Controller
{
    public function anggota(Request $request)
    {

        if ($request->q != '') {
            $anggota = Anggota::where('status_anggota', 1)
                ->where('nama', 'like', "%$request->q%")
                ->orderBy('no_anggota')
                ->get();
        } else {

            $anggota = Anggota::where('status_anggota', 1)
                ->orderBy('no_anggota')
                ->get();
        }


        $data = [];
        foreach ($anggota as $key => $val) {
            $row = [];
            $row['id'] = $val->no_anggota . '__' . $val->nama;
            $row['text'] = $val->no_anggota . ' - ' . $val->nama;
            $data[] = $row;
        }

        $result = [
            'results' => $data,
            'pagination' => ['more' => true]
        ];

        return $result;
    }

    public function pencairan($nomorrekening)
    {
        $pinjaman    =   Pinjaman::leftJoin('t_anggota', 't_pembiayaan.no_anggota', '=', 't_anggota.no_anggota')
            ->where('pencairan_by', 0)
            ->where('approve_by', 1)
            ->where('t_pembiayan.no_rekening', $nomorrekening)
            ->first();

        $data = [];
        foreach ($pinjaman as $key => $val) {
            $row = [];
            $row['id'] = $val->id . '__' . $val->id;
            $row['text'] = $val->no_rekening . ' - ' . $val->nama;
            $data[] = $row;
        }

        $result = [
            'results' => $data,
            'pagination' => ['more' => true]
        ];

        return $result;
    }

    public function marginByProduk(Request $request)
    {
        $margin = ProdukMargin::where('produk_id', $request->produkid)->with('produk')->get();

        $data = [];

        foreach ($margin as $idx => $item) {
            $row = [];
            $row['jangka_waktu'] = $item->jangka_waktu;
            $row['margin'] = $item->margin;
            $row['tipe_produk'] = $item->produk->tipe_produk;
            $row['asuransi'] = $item->asuransi;
            $data[] = $row;
        }

        if (count($data) != 0) {

            $res = [
                'status' => true,
                'message' => 'Data Margin DI Temukan',
                'data' => $data,
                'code' => 200
            ];
            return $res;
        } else {
            $res = [
                'status' => false,
                'message' => 'Data Margin Tidak Di Temukan',
                'data' => [],
                'code' => 404
            ];
            return $res;
        }
    }

    public function simpananSimulasi(Request $request)
    {
        $produk_id = $request->produk_id;
        $bunga = $request->bunga;
        $bulan = $request->bulan;
        $jenis_ssb = $request->input('jenis-ssb');
        $saldo = str_replace('.', '', $request->saldo);
        $bunga_efektif = $request->bunga_efektif;

        $startBulan = date('n');
        $startTahun = date('Y');
        $rangeBulan = FunctionHelper::rangeBulan($startBulan, $startTahun, $bulan);
        // return $rangeBulan;
        $produk = Produk::find($produk_id);
        if ($produk) {
            if (Str::slug($produk->nama_produk) == 'simpanan-sukarela-berjangka') {
                // return $saldo;
                return view('pages.data.simpanan.simulasi-ssb')
                    ->with('bulan', $bulan)
                    ->with('saldo', $saldo)
                    ->with('request', $request)
                    ->with('produk', $produk)
                    ->with('jenis_ssb', $jenis_ssb)
                    ->with('rangeBulan', $rangeBulan)
                    ->with('bunga_efektif', $bunga_efektif)
                    ->with('bunga', $bunga);
            } elseif (Str::slug($produk->nama_produk) == 'simpanan-pasti') {

                // return $request
                $saldo = ($request->saldo == null ? 0 : $saldo);
                $bulan = ($request->bulan == null ? 1 : $bulan);
                $rangeBulan = FunctionHelper::rangeBulan($startBulan, $startTahun, ($bulan + 1));
                $simpas     = FunctionHelper::hitungSimpas($bulan, $bunga_efektif, $bunga, $saldo);

                return view('pages.data.simpanan.simulasi-simpas')
                    ->with('bulan', $bulan)
                    ->with('saldo', $saldo)
                    ->with('request', $request)
                    ->with('produk', $produk)
                    ->with('simpas', $simpas)
                    ->with('rangeBulan', $rangeBulan)
                    ->with('bunga_efektif', $bunga_efektif)
                    ->with('bunga', $bunga);
            }
        }
    }

    public function pinjamanSimulasi(Request $request)
    {
        // return $request;
        $produk_id = $request->produk_id;
        $bunga = $request->bunga;
        $bulan = $request->bulan;
        $saldo = str_replace('.', '', $request->saldo);
        $bunga_efektif = $request->bunga_efektif;

        $startBulan = date('n');
        $startTahun = date('Y');
        $rangeBulan = FunctionHelper::rangeBulan($startBulan, $startTahun, $bulan);
        $produk = Produk::find($produk_id);
        $saldo = ($request->saldo == null ? 0 : $saldo);
        $bulan = ($request->bulan == null ? 1 : $bulan);
        $rangeBulan = FunctionHelper::rangeBulan($startBulan, $startTahun, ($bulan + 1));
        $simpas     = FunctionHelper::hitungSimpas($bulan, $bunga_efektif, $bunga, $saldo);
        $financial = new FinancialHelper;
        return view('pages.data.pinjaman.simulasi-table')
            ->with('bulan', $bulan)
            ->with('financial', $financial)
            ->with('request', $request)
            ->with('saldo', $saldo)
            ->with('produk', $produk)
            ->with('simpas', $simpas)
            ->with('rangeBulan', $rangeBulan)
            ->with('bunga_efektif', $bunga_efektif)
            ->with('bunga', $bunga);
    }

    public function pinjamanPengajuanSimulasi(Request $request)
    {
        // return $request;
        $produk_id = $request->produk_id;
        $bunga = $request->bunga;
        $bulan = $request->bulan;
        $saldo = str_replace('.', '', $request->saldo);
        $bunga_efektif = $request->bunga_efektif;

        $anggota = Anggota::where('no_anggota', $request->no_anggota)->firstOrFail();

        $startBulan = date('n');
        $startTahun = date('Y');
        $rangeBulan = FunctionHelper::rangeBulan($startBulan, $startTahun, $bulan);
        $produk = Produk::find($produk_id);
        $saldo = ($request->saldo == null ? 0 : $saldo);
        $bulan = ($request->bulan == null ? 1 : $bulan);
        $rangeBulan = FunctionHelper::rangeBulan($startBulan, $startTahun, ($bulan + 1));
        $simpas     = FunctionHelper::hitungSimpas($bulan, $bunga_efektif, $bunga, $saldo);
        $financial = new FinancialHelper;
        return view('pages.data.pinjaman.simulasi-pengajuan-table')
            ->with('bulan', $bulan)
            ->with('anggota', $anggota)
            ->with('financial', $financial)
            ->with('request', $request)
            ->with('saldo', $saldo)
            ->with('produk', $produk)
            ->with('simpas', $simpas)
            ->with('rangeBulan', $rangeBulan)
            ->with('bunga_efektif', $bunga_efektif)
            ->with('bunga', $bunga);
    }

    public function pinjamanPlafon(Request $request)
    {
        // return $request;
        $gaji40 = 0;

        if ($request->gaji) {
            $gaji40 = str_replace('.', '', $request->gaji) * 0.4;
            $request->gaji = str_replace('.', '', $request->gaji);
        }
        // return $gaji40;
        $pinjaman = Pinjaman::where('no_anggota', 'like', "%$request->no_anggota%")->get();

        // $bunga = $request->bunga;
        $jml_baru = str_replace('.', '', $request->jml_pengajuan_baru ?? 0);
        $angsuran = str_replace('.', '', $request->angsuran ?? 0);
        // $bunga_efektif = $request->bunga_efektif;
        // $bulan = $request->bulan;
        if ($request->no_anggota) {
            $anggota = Anggota::where('no_anggota', $request->no_anggota)->firstOrFail();
        } else {
            $anggota = null;
        }

        // $startBulan = date('n');
        // $startTahun = date('Y');
        // $rangeBulan = FunctionHelper::rangeBulan($startBulan, $startTahun, $bulan);
        // $produk = Produk::find($produk_id);
        // $saldo = ($request->saldo == null ? 0 : $saldo);
        // $bulan = ($request->bulan == null ? 1 : $bulan);
        // $rangeBulan = FunctionHelper::rangeBulan($startBulan, $startTahun, ($bulan + 1));
        // $simpas     = FunctionHelper::hitungSimpas($bulan, $bunga_efektif, $bunga, $saldo);
        $financial = new FinancialHelper;
        return view('pages.data.pinjaman.simulasi-plafon-table')
            ->with('pinjaman', $pinjaman)
            ->with('jml_baru', $jml_baru)
            ->with('gaji40', $gaji40)
            ->with('anggota', $anggota)
            ->with('financial', $financial)
            ->with('request', $request)
            ->with('angsuran', $angsuran)
            // ->with('produk', $produk)
            // ->with('simpas', $simpas)
            // ->with('rangeBulan', $rangeBulan)
            // ->with('bunga_efektif', $bunga_efektif)
            // ->with('bunga', $bunga);
        ;
    }

    public function shuSimulasi(Request $request)
    {
        $alokasi_shu    = str_replace('.', '', $request->alokasi_shu);
        $tahun          = $request->tahun;
        // return $request;
        return view('pages.data.shu.simulasi')
            ->with('tahun', $tahun)
            ->with('alokasi_shu', $alokasi_shu)
            ->with('request', $request);
    }

    public function getBungapaByMarginflat(Request $request)
    {
        $marginFlat = $request->marginFlat;
        $bulan = $request->bulan;
        $saldo = str_replace('.', '', $request->saldo);

        return FunctionHelper::bungaEfektif($marginFlat / 100, $bulan, $saldo);
    }
}
