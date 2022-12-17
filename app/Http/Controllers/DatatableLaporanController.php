<?php

namespace App\Http\Controllers;

use App\Models\Data\Anggota;
use App\Models\Data\Simpanan;
use App\Models\Data\TempAnggota;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Routing\Controller;

class DatatableLaporanController extends Controller
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

        $anggota = Anggota::whereMonth('reg_date', $bulan)->whereYear('reg_date', $tahun)->orderBy('reg_date');
        // return $bulan.'-'.$tahun;
        return DataTables::of($anggota)
            ->addIndexColumn()
            ->editColumn('no_anggota', function ($row) {
                return '<b>' . $row->no_anggota . '</b>';
            })
            ->editColumn('nama', function ($row) {
                return '<b>' . $row->nama . '</b>';
            })
            ->editColumn('grade', function ($row) {
                return '<b>' . strtoupper($row->grade_nama) . '</b>';
            })
            ->editColumn('profit', function ($row) {
                return '<b>' . strtoupper($row->profit_nama) . '</b>';
            })
            ->editColumn('tanggal_gabung', function ($row) {
                return '<b>' . date('d-m-Y', strtotime($row->reg_date)) . '</b>';
            })
            ->addColumn('status', function ($row) {
                if ($row->status_anggota == 0)
                    return '<span class="badge font-size-13 bg-secondary">Pengajuan Aktivasi</span>';
                elseif ($row->status_anggota == 1)
                    return '<span class="badge font-size-13 bg-success">Aktif</span>';
                elseif ($row->status_anggota == 4)
                    return '<span class="badge font-size-13 bg-warning">Pengajuan Terminasi</span>';
                else
                    return '<span class="badge font-size-13 bg-danger">Tidak Aktif</span>';
            })
            ->rawColumns(['no_anggota', 'nama', 'grade', 'profit', 'status', 'tanggal_gabung'])
            ->toJson();
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

        // $simpanan = TempAnggota::whereMonth('reg_date', $bulan)->whereYear('reg_date', $tahun)->orderBy('reg_date');
        $simpanan = TempAnggota::with(['anggota'])->orderBy('no_anggota');
        // return $simpanan;
        // return $bulan.'-'.$tahun;
        return DataTables::of($simpanan)
            ->addIndexColumn()
            ->editColumn('no_anggota', function ($row) {
                return '<b>' . $row->no_anggota . '</b>';
            })
            ->addColumn('nama', function ($row) {
                return '<b>' . ($row->anggota->nama) . '</b>';
            })
            ->editColumn('simwa', function ($row) {
                return '<b> Rp. ' . number_format($row->simwa, 0, ',', '.') . '</b>';
            })
            ->editColumn('simp_pokok', function ($row) {
                return '<b> Rp. ' . number_format($row->anggota->grades->simp_pokok, 0, ',', '.') . '</b>';
            })
            ->addColumn('total', function ($row) {
                return '<b> Rp. ' . number_format(($row->simwa + $row->anggota->grades->simp_pokok), 0, ',', '.') . '</b>';
            })
            // ->addColumn('status', function ($row) {
            //     if ($row->status_anggota == 0)
            //         return '<span class="badge font-size-13 bg-secondary">Pengajuan Aktivasi</span>';
            //     elseif ($row->status_anggota == 1)
            //         return '<span class="badge font-size-13 bg-success">Aktif</span>';
            //     elseif ($row->status_anggota == 4)
            //         return '<span class="badge font-size-13 bg-warning">Pengajuan Terminasi</span>';
            //     else
            //         return '<span class="badge font-size-13 bg-danger">Tidak Aktif</span>';
            // })
            ->rawColumns(['no_anggota', 'nama', 'simp_pokok', 'simwa', 'total'])
            ->toJson();
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

        $simpanan = Simpanan::with('anggota')->where('produk_id', 3)->whereMonth('created_date', $bulan)->whereYear('created_date', $tahun)->orderBy('created_date');
        // $simpanan = TempAnggota::with(['anggota'])->orderBy('no_anggota');
        // return $simpanan;
        // return $bulan.'-'.$tahun;
        return DataTables::of($simpanan)
            ->addIndexColumn()
            ->editColumn('tgl_jatuh_temp', function ($row) {
                return '<b>' . $row->tgl_jatuh_tempo . '</b>';
            })
            ->editColumn('no_rekening', function ($row) {
                return '<b>' . $row->no_rekening . '</b>';
            })
            ->editColumn('no_anggota', function ($row) {
                return '<b>' . $row->no_anggota . '</b>';
            })
            ->addColumn('nama', function ($row) {
                return '<b>' . $row->anggota->nama . '</b>';
            })
            ->addColumn('unit_kerja', function ($row) {
                return '<b>' . $row->anggota->DepartemenNama . '</b>';
            })
            ->addColumn('nilai_simpanan', function ($row) {
                return '<b> Rp. ' . number_format($row->saldo_akhir, 0, ',', '.') . '</b>';
            })
            // ->addColumn('status', function ($row) {
            //     if ($row->status_anggota == 0)
            //         return '<span class="badge font-size-13 bg-secondary">Pengajuan Aktivasi</span>';
            //     elseif ($row->status_anggota == 1)
            //         return '<span class="badge font-size-13 bg-success">Aktif</span>';
            //     elseif ($row->status_anggota == 4)
            //         return '<span class="badge font-size-13 bg-warning">Pengajuan Terminasi</span>';
            //     else
            //         return '<span class="badge font-size-13 bg-danger">Tidak Aktif</span>';
            // })
            ->rawColumns(['no_anggota', 'nama', 'tgl_jatuh_tempo', 'no_rekening', 'unit_kerja', 'nilai_simpanan'])
            ->toJson();
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

        $simpanan = Simpanan::with('anggota')->where('produk_id', 4)->whereMonth('created_date', $bulan)->whereYear('created_date', $tahun)->orderBy('created_date');
        // $simpanan = TempAnggota::with(['anggota'])->orderBy('no_anggota');
        // return $simpanan;
        // return $bulan.'-'.$tahun;
        return DataTables::of($simpanan)
            ->addIndexColumn()
            ->editColumn('tgl_jatuh_temp', function ($row) {
                return '<b>' . $row->tgl_jatuh_tempo . '</b>';
            })
            ->editColumn('no_rekening', function ($row) {
                return '<b>' . $row->no_rekening . '</b>';
            })
            ->editColumn('no_anggota', function ($row) {
                return '<b>' . $row->no_anggota . '</b>';
            })
            ->addColumn('nama', function ($row) {
                return '<b>' . $row->anggota->nama . '</b>';
            })
            ->addColumn('unit_kerja', function ($row) {
                return '<b>' . $row->anggota->DepartemenNama . '</b>';
            })
            ->addColumn('nilai_simpanan', function ($row) {
                return '<b> Rp. ' . number_format($row->saldo_akhir, 0, ',', '.') . '</b>';
            })
            // ->addColumn('status', function ($row) {
            //     if ($row->status_anggota == 0)
            //         return '<span class="badge font-size-13 bg-secondary">Pengajuan Aktivasi</span>';
            //     elseif ($row->status_anggota == 1)
            //         return '<span class="badge font-size-13 bg-success">Aktif</span>';
            //     elseif ($row->status_anggota == 4)
            //         return '<span class="badge font-size-13 bg-warning">Pengajuan Terminasi</span>';
            //     else
            //         return '<span class="badge font-size-13 bg-danger">Tidak Aktif</span>';
            // })
            ->rawColumns(['no_anggota', 'nama', 'tgl_jatuh_tempo', 'no_rekening', 'unit_kerja', 'nilai_simpanan'])
            ->toJson();
    }
}