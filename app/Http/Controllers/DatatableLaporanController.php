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
        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d');
        if (isset($request->start_date)) {
            if ($request->start_date != '')
                $startDate = $request->start_date;
        }
        if (isset($request->end_date)) {
            if ($request->end_date != '')
                $endDate = $request->end_date;
        }

        $anggota = Anggota::
            whereDate('reg_date','>=',$startDate)
            ->whereDate('reg_date','<=',$endDate)
            // whereMonth('reg_date', '>=', $bulan)
            // ->whereYear('reg_date', '>=', $tahun)
            ->orderBy('reg_date');
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
            ->editColumn('departemen', function ($row) {
                return '<b>' . strtoupper($row->departemen_nama) . '</b>';
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
            ->rawColumns(['no_anggota', 'nama', 'grade', 'profit', 'departemen', 'status', 'tanggal_gabung'])
            ->toJson();
    }

    public function simpanan(Request $request)
    {

        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d');
        if (isset($request->start_date)) {
            if ($request->start_date != '')
                $startDate = $request->start_date;
        }
        if (isset($request->end_date)) {
            if ($request->end_date != '')
                $endDate = $request->end_date;
        }
        // $simpanan = TempAnggota::whereMonth('reg_date', $bulan)->whereYear('reg_date', $tahun)->orderBy('reg_date');
        // $simpanan = TempAnggota::with(['anggota'])->orderBy('no_anggota');
        $simpanan    = Anggota::
            whereDate('reg_date','>=',$startDate)
            ->whereDate('reg_date','<=',$endDate)
            // whereMonth('reg_date', '>=', $bulan)
            // ->whereYear('reg_date', '>=', $tahun)
            ->orderBy('reg_date');
        // return $simpanan;
        // return $bulan.'-'.$tahun;
        return DataTables::of($simpanan)
            ->addIndexColumn()
            ->editColumn('no_anggota', function ($row) {
                return '<b>' . $row->no_anggota . '</b>';
            })
            ->addColumn('nama', function ($row) {
                // return '<b>' . ($row->anggota->nama) . '</b>';
                return '<b>' . ($row->nama) . '</b>';
            })
            ->editColumn('sim_wajib', function ($row) {
                return '<b>' . number_format($row->sim_wajib, 0) . '</b>';
            })
            ->editColumn('sim_pokok', function ($row) {
                return '<b>' . number_format($row->sim_pokok, 0) . '</b>';
                // return '<b> Rp. ' . number_format($row->anggota->grades->simp_pokok, 0, ',', '.') . '</b>';
            })
            ->editColumn('sim_khusus', function ($row) {
                return '<b>' . number_format($row->sim_khusus, 0) . '</b>';
            })
            ->addColumn('total', function ($row) {
                // return '<b> Rp. ' . number_format(($row->simwa + $row->anggota->grades->simp_pokok), 0, ',', '.') . '</b>';
                return '<b> Rp. ' . number_format(($row->sim_wajib + $row->sim_pokok), 0, ',', '.') . '</b>';
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
            ->rawColumns(['no_anggota', 'nama', 'sim_pokok', 'sim_wajib', 'sim_khusus', 'total'])
            ->toJson();
    }

    public function simp_ssb(Request $request)
    {
        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d');
        if (isset($request->start_date)) {
            if ($request->start_date != '')
                $startDate = $request->start_date;
        }
        if (isset($request->end_date)) {
            if ($request->end_date != '')
                $endDate = $request->end_date;
        }
        $simpanan = Simpanan::with('anggota')->where('produk_id', 2)
        // ->whereMonth('created_date', $bulan)->whereYear('created_date', $tahun)
        ->whereDate('created_date','>=',$startDate)
        ->whereDate('created_date','<=',$endDate)
        ->orderBy('created_date');
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
        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d');
        if (isset($request->start_date)) {
            if ($request->start_date != '')
                $startDate = $request->start_date;
        }
        if (isset($request->end_date)) {
            if ($request->end_date != '')
                $endDate = $request->end_date;
        }
        $simpanan = Simpanan::with('anggota')->where('produk_id', 1)
        // ->whereMonth('created_date', $bulan)->whereYear('created_date', $tahun)
        ->whereDate('created_date','>=',$startDate)
        ->whereDate('created_date','<=',$endDate)
        ->orderBy('created_date');
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
