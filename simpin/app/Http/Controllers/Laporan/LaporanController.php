<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function anggota(Request $request)
    {
        $tahun = date('Y');
        $bulan = date('n');
        if (isset($request->tahun)) {
            if ($request->tahun != '')
                $tahun = $request->tahun;
        }
        if (isset($request->bulan)) {
            if ($request->bulan != '')
                $bulan = $request->bulan;
        }

        return view('pages.laporan.anggota.index')
            ->with('tahun', $tahun)
            ->with('bulan', $bulan)
            ->with('request', $request);
    }

    public function simpanan(Request $request)
    {
        $tahun = date('Y');
        $bulan = date('n');
        if (isset($request->tahun)) {
            if ($request->tahun != '')
                $tahun = $request->tahun;
        }
        if (isset($request->bulan)) {
            if ($request->bulan != '')
                $bulan = $request->bulan;
        }

        return view('pages.laporan.simpanan.index')
            ->with('tahun', $tahun)
            ->with('bulan', $bulan)
            ->with('request', $request);
    }

    public function simp_ssb(Request $request)
    {
        $tahun = date('Y');
        $bulan = date('n');
        if (isset($request->tahun)) {
            if ($request->tahun != '')
                $tahun = $request->tahun;
        }
        if (isset($request->bulan)) {
            if ($request->bulan != '')
                $bulan = $request->bulan;
        }

        return view('pages.laporan.simp-ssb.index')
            ->with('tahun', $tahun)
            ->with('bulan', $bulan)
            ->with('request', $request);
    }

    public function simpas(Request $request)
    {
        $tahun = date('Y');
        $bulan = date('n');
        if (isset($request->tahun)) {
            if ($request->tahun != '')
                $tahun = $request->tahun;
        }
        if (isset($request->bulan)) {
            if ($request->bulan != '')
                $bulan = $request->bulan;
        }

        return view('pages.laporan.simpas.index')
            ->with('tahun', $tahun)
            ->with('bulan', $bulan)
            ->with('request', $request);
    }
}
