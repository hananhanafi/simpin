<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Data\Shu;
use App\Models\Data\Anggota;
use App\Models\Master\Grade;
use Illuminate\Http\Request;
use App\Models\Data\Pinjaman;
use App\Models\Data\Simpanan;
use App\Models\Master\Produk;
use App\Models\Master\Departemen;
use App\Models\Master\SumberDana;
use Illuminate\Support\Facades\DB;
use App\Models\Master\ProfitCenter;
use App\Models\Master\ProdukKategori;
use Yajra\DataTables\Facades\DataTables;

class DatatableController extends Controller
{
    public function produkType(Request $request)
    {

        $produkType = ProdukKategori::orderBy('tipe_produk')->orderBy('kode')->get();

        return DataTables::of($produkType)
            ->addIndexColumn()
            ->addColumn('nama', function ($row) {
                return '<b>' . $row->nama . '</b>';
            })
            ->editColumn('kode', function ($row) {
                return '<b>' . $row->kode . '</b>';
            })
            ->editColumn('tipe_produk', function ($row) {
                return '<b>' . $row->tipe . '</b>';
            })
            ->addColumn('aksi', function ($row) use ($request) {

                $btn = '<div class="btn-group">
                            <button type="button" class="btn btn-primary btn-sm">Aksi</button>
                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" style="">
                                <a class="dropdown-item dropdown-menu-end" href="' . route('master.produk-kategori.edit', $row->id) . '">Edit</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item dropdown-menu-end" href="javascript:hapus(\'' . $row->id . '\')">Hapus</a>
                            </div>
                        </div>';
                return $btn;
            })
            ->rawColumns(['nama', 'kode', 'tipe_produk', 'aksi'])
            ->toJson();
    }
    public function produk(Request $request)
    {

        if ($request->approval) {
            $produk = Produk::where('status_produk', 0)
                ->orderBy('tipe_produk')
                ->orderBy('kode')
                ->with('tipePr')
                ->get();
        } else {
            $produk = Produk::orderBy('tipe_produk')
                ->orderBy('kode')
                ->with('tipePr')
                ->get();
        }

        return DataTables::of($produk)
            ->addIndexColumn()
            ->addColumn('nama_produk', function ($row) {
                return '<b>' . $row->nama_produk . '</b>';
            })
            ->editColumn('kode', function ($row) {
                return '<b>' . $row->kode . '</b>';
            })
            ->editColumn('produk_tipe', function ($row) {
                return '<b>' . $row->tipe . '</b>';
            })
            ->editColumn('produk_jenis', function ($row) {
                return '<b>' . $row->jenis . '</b>';
            })
            ->editColumn('admin_fee', function ($row) {
                return '<b>Rp. ' . number_format($row->admin_fee, 0, ',', '.') . '</b>';
            })
            ->addColumn('status_produk', function ($row) {
                if ($row->status_produk == 0)
                    return '<span class="badge font-size-13 bg-secondary">Draft</span>';
                elseif ($row->status_produk == 1)
                    return '<span class="badge font-size-13 bg-success">Aktif</span>';
                else
                    return '<span class="badge font-size-13 bg-danger">Tidak Aktif</span>';
            })
            ->addColumn('aksi', function ($row) use ($request) {

                if ($request->approval) {
                    $btn = '<div class="btn-group">
                            <button type="button" class="btn btn-primary btn-sm">Aksi</button>
                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" style="">
                                <a class="dropdown-item dropdown-menu-end text-success" href="javascript:approve(' . $row->id . ')"><i class="fa fa-check"></i> Approve</a>
                                <a class="dropdown-item dropdown-menu-end text-danger" href="javascript:tolak(' . $row->id . ')"><i class="fa fa-times"></i> Tolak</a>
                            </div>
                        </div>';
                } else {

                    $btn = '<div class="btn-group">
                            <button type="button" class="btn btn-primary btn-sm">Aksi</button>
                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" style="">
                                <a class="dropdown-item dropdown-menu-end" href="' . route('master.produk.show', $row->id) . '">Detail</a>
                                <a class="dropdown-item dropdown-menu-end" href="' . route('master.produk.edit', $row->id) . '">Edit</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item dropdown-menu-end" href="javascript:hapus(\'' . $row->id . '\')">Hapus</a>
                            </div>
                        </div>';
                }
                return $btn;
            })
            ->rawColumns(['nama_produk', 'kode', 'status_produk', 'aksi', 'produk_tipe', 'produk_jenis', 'admin_fee'])
            ->toJson();
    }

    public function grade()
    {
        $grade = Grade::orderBy('kode')
            ->get();

        return DataTables::of($grade)
            ->addIndexColumn()
            ->editColumn('kode', function ($row) {
                return '<b>' . $row->kode . '</b>';
            })
            ->editColumn('grade_name', function ($row) {
                return '<b>' . $row->grade_name . '</b>';
            })
            ->editColumn('simpanan_pokok', function ($row) {
                return '<b>Rp. ' . number_format($row->simp_pokok, 0, ',', '.') . '</b>';
            })
            ->editColumn('simpanan_wajib', function ($row) {
                return '<b>Rp. ' . number_format($row->simp_wajib, 0, ',', '.') . '</b>';
            })
            ->addColumn('aksi', function ($row) {
                $btn = '<div class="btn-group">
                        <button type="button" class="btn btn-primary btn-sm">Aksi</button>
                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="mdi mdi-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" style="">
                            <a class="dropdown-item dropdown-menu-end" href="' . route('master.grade.edit', $row->id) . '">Edit</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item dropdown-menu-end" href="javascript:hapus(\'' . $row->id . '\')">Hapus</a>
                        </div>
                    </div>';
                return $btn;
            })
            ->rawColumns(['kode', 'grade_name', 'simpanan_pokok', 'simpanan_wajib', 'aksi'])
            ->toJson();
    }
    public function departemen()
    {
        $grade = Departemen::where('parent_id', 0)->orderBy('kode');

        return DataTables::of($grade)
            ->addIndexColumn()
            ->editColumn('kode', function ($row) {
                return '<b>' . $row->kode . '</b>';
            })
            ->editColumn('departemen', function ($row) {
                return '<b>' . $row->departemen . '</b>';
            })
            ->editColumn('sub_departemen', function ($row) {
                return '<b>' . count($row->sub_departemen) . '</b>';
            })
            ->addColumn('aksi', function ($row) {
                $btn = '<div class="btn-group">
                        <button type="button" class="btn btn-primary btn-sm">Aksi</button>
                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="mdi mdi-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" style="">
                            <a class="dropdown-item dropdown-menu-end" href="' . route('master.departemen.show', $row->id) . '">Detail</a>
                            <a class="dropdown-item dropdown-menu-end" href="' . route('master.departemen.edit', $row->id) . '">Edit</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item dropdown-menu-end" href="javascript:hapus(\'' . $row->id . '\')">Hapus</a>
                        </div>
                    </div>';
                return $btn;
            })
            ->rawColumns(['kode', 'departemen', 'sub_departemen', 'aksi'])
            ->toJson();
    }
    public function profit()
    {
        $profit = ProfitCenter::orderBy('kode');

        return DataTables::of($profit)
            ->addIndexColumn()
            ->editColumn('kode', function ($row) {
                return '<b>' . $row->kode . '</b>';
            })
            ->editColumn('nama', function ($row) {
                return '<b>' . $row->nama . '</b>';
            })
            ->editColumn('desc', function ($row) {
                return $row->desc;
            })
            ->addColumn('aksi', function ($row) {
                $btn = '<div class="btn-group">
                        <button type="button" class="btn btn-primary btn-sm">Aksi</button>
                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="mdi mdi-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" style="">
                            <a class="dropdown-item dropdown-menu-end" href="' . route('master.profit.show', $row->id) . '">Detail</a>
                            <a class="dropdown-item dropdown-menu-end" href="' . route('master.profit.edit', $row->id) . '">Edit</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item dropdown-menu-end" href="javascript:hapus(\'' . $row->id . '\')">Hapus</a>
                        </div>
                    </div>';
                return $btn;
            })
            ->rawColumns(['kode', 'desc', 'nama', 'aksi'])
            ->toJson();
    }
    public function sumberdana()
    {
        $sumberdana = SumberDana::orderBy('kode');

        return DataTables::of($sumberdana)
            ->addIndexColumn()
            ->editColumn('kode', function ($row) {
                return '<b>' . $row->kode . '</b>';
            })
            ->editColumn('sumber_dana', function ($row) {
                return '<b>' . $row->sumber_dana . '</b>';
            })
            ->addColumn('aksi', function ($row) {
                $btn = '<div class="btn-group">
                        <button type="button" class="btn btn-primary btn-sm">Aksi</button>
                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="mdi mdi-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" style="">
                            <a class="dropdown-item dropdown-menu-end" href="' . route('master.sumber-dana.edit', $row->id) . '">Edit</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item dropdown-menu-end" href="javascript:hapus(\'' . $row->id . '\')">Hapus</a>
                        </div>
                    </div>';
                return $btn;
            })
            ->rawColumns(['kode', 'sumber_dana', 'aksi'])
            ->toJson();
    }

    public function anggota(Request $request)
    {
        if ($request->approval) {
            $anggota = Anggota::whereIn('status_anggota', [0, 4])->orderBy('no_anggota');
        } else {
            $anggota = Anggota::orderBy('no_anggota');
        }

        return DataTables::of($anggota)
            ->addIndexColumn()
            ->editColumn('no_anggota', function ($row) {
                return '<b>' . $row->no_anggota . '</b>';
            })
            ->editColumn('nama', function ($row) {
                return '<b>' . $row->nama . '</b>';
            })
            ->editColumn('telepon', function ($row) {
                return '<b>' . $row->telepon . '</b>';
            })
            ->editColumn('alamat', function ($row) {
                return '<b>' . $row->alamat . '</b>';
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
            ->addColumn('aksi', function ($row) use ($request) {
                if ($request->approval) {
                    $btn = '<div class="btn-group">
                            <button type="button" class="btn btn-primary btn-sm">Aksi</button>
                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" style="">
                                <a class="dropdown-item dropdown-menu-end text-success" href="javascript:approve(' . $row->id . ')"><i class="fa fa-check"></i> Approve</a>
                                <a class="dropdown-item dropdown-menu-end text-danger" href="javascript:tolak(' . $row->id . ')"><i class="fa fa-times"></i> Tolak</a>
                            </div>
                        </div>';
                } else {
                    $btn = '<div class="btn-group">
                            <button type="button" class="btn btn-primary btn-sm">Aksi</button>
                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" style="">
                                <a class="dropdown-item dropdown-menu-end" href="' . route('data.anggota.show', $row->id) . '">Detail</a>
                                <a class="dropdown-item dropdown-menu-end" href="' . route('data.anggota.edit', $row->id) . '">Edit</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item dropdown-menu-end" href="javascript:penutupan(\'' . $row->id . '\',\'' . $row->nama . '\',\'' . $row->no_anggota . '\')">Pengajuan Terminasi</a>
                                <a class="dropdown-item dropdown-menu-end" href="javascript:hapus(\'' . $row->id . '\')">Hapus</a>
                            </div>
                        </div>';
                }
                return $btn;
            })
            ->rawColumns(['no_anggota', 'nama', 'telepon', 'alamat', 'status', 'aksi'])
            ->toJson();
    }

    public function simpanan(Request $request)
    {

        if ($request->approval) {
            $simpanan = Simpanan::with(['produk', 'anggota'])->whereIn('status_rekening', [0, 4])->orderBy('no_rekening');
        } else {
            $simpanan = Simpanan::with(['produk', 'anggota'])->orderBy('no_rekening');
        }
        return DataTables::of($simpanan)
            ->addIndexColumn()
            ->editColumn('no_rekening', function ($row) {
                return '<b>' . $row->no_rekening . '</b>';
            })
            ->editColumn('no_anggota', function ($row) {
                return '<b>' . $row->no_anggota . '</b>';
            })
            ->editColumn('nama', function ($row) {
                return '<b>' . $row->nama . '</b>';
            })
            ->editColumn('jenis_simpanan', function ($row) {
                return '<b>' . $row->jenis_simpanan . '</b>';
            })
            // ->addColumn('jenis_simpanan', function ($row) {
            //     return '<b>' . $row->jenis_simpanan . '</b>';
            // })
            ->editColumn('saldo_akhir', function ($row) {
                return '<b>' . number_format($row->saldo_akhir, 0, ',', '.') . '</b>';
            })
            ->addColumn('status', function ($row) {
                return $row->status;
            })
            ->addColumn('aksi', function ($row) use ($request) {
                if ($request->approval) {
                    $btn = '<div class="btn-group">
                                <button type="button" class="btn btn-primary btn-sm">Aksi</button>
                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-chevron-down"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" style="">
                                    <a class="dropdown-item dropdown-menu-end text-success" href="javascript:approve(' . $row->id . ')"><i class="fa fa-check"></i> Approve</a>
                                    <a class="dropdown-item dropdown-menu-end text-danger" href="javascript:tolak(' . $row->id . ')"><i class="fa fa-times"></i> Tolak</a>
                                </div>
                            </div>';
                } else {
                    $tutup = '';
                    if ($row->status_rekening == 1) {
                        $tutup = '<a class="dropdown-item dropdown-menu-end" href="javascript:penutupan(\'' . $row->id . '\',\'' . $row->nama . '\',\'' . $row->no_anggota . '\')">Pengajuan Penutupan</a>';
                    }
                    $btn = '<div class="btn-group">
                                <button type="button" class="btn btn-primary btn-sm">Aksi</button>
                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-chevron-down"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" style="">
                                    <a class="dropdown-item dropdown-menu-end" href="' . route('data.simpanan.show', $row->id) . '">Detail</a>
                                    <div class="dropdown-divider"></div>
                                    ' . $tutup . '
                                    <a class="dropdown-item dropdown-menu-end" href="javascript:hapus(\'' . $row->id . '\')">Hapus</a>
                                </div>
                            </div>';
                }
                return $btn;
            })
            ->rawColumns(['no_rekening', 'no_anggota', 'nama', 'jenis_simpanan', 'saldo_akhir', 'status', 'aksi'])
            ->toJson();
    }

    public function simpanan_sertif(Request $request)
    {

        $simpanan = Simpanan::with(['produk', 'anggota'])->where('status_rekening', 1)->orderBy('no_rekening');
        return DataTables::of($simpanan)
            ->addIndexColumn()
            ->editColumn('no_rekening', function ($row) {
                return '<b>' . $row->no_rekening . '</b>';
            })
            ->editColumn('no_anggota', function ($row) {
                return '<b>' . $row->no_anggota . '</b>';
            })
            ->editColumn('nama', function ($row) {
                return '<b>' . $row->nama . '</b>';
            })
            ->editColumn('jenis_simpanan', function ($row) {
                return '<b>' . $row->jenis_simpanan . '</b>';
            })
            ->editColumn('saldo_akhir', function ($row) {
                return '<b>' . number_format($row->saldo_akhir, 0, ',', '.') . '</b>';
            })
            ->addColumn('status', function ($row) {
                return $row->status;
            })
            ->addColumn('aksi', function ($row) use ($request) {

                $tutup = '';
                if ($row->status_rekening == 1) {
                    $tutup = '<a class="dropdown-item dropdown-menu-end" href="javascript:penutupan(\'' . $row->id . '\',\'' . $row->nama . '\',\'' . $row->no_anggota . '\')">Pengajuan Penutupan</a>';
                }
                $btn = '<div class="btn-group">
                                <button type="button" class="btn btn-primary btn-sm">Aksi</button>
                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-chevron-down"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" style="">
                                    <a class="dropdown-item dropdown-menu-end" href="' . route('data.simpanan.sertif-pdf', $row->id) . '">Cetak Sertifikat</a>
                                </div>';
                return $btn;
            })
            ->rawColumns(['no_rekening', 'no_anggota', 'nama', 'jenis_simpanan', 'saldo_akhir', 'status', 'aksi'])
            ->toJson();
    }

    public function pinjaman(Request $request)
    {
        if ($request->approval) {

            // $anggota = Anggota::select(DB::raw('t_anggota.id,t_anggota.no_anggota, t_anggota.nama, t_anggota.alamat, p_departemen.departemen, t_anggota.telepon, t_anggota.status_anggota '))
            //                 ->leftJoin('p_departemen','p_departemen.id','=','t_anggota.departement_id')
            //                 ->whereIn('t_anggota.status',[0,4])
            //                 ->where('t_anggota.nama','!=','')
            //                 ->orderBy('t_anggota.nama');
            // $pinjaman = Pinjaman::select(DB::raw('t_pembiayaan.id as id_pinjaman,t_pembiayaan.produk_id,t_pembiayaan.jml_pinjaman, t_pembiayaan.saldo_akhir_pokok, t_pembiayaan.jangka_waktu, t_pembiayaan.tanggal_mulai, t_pembiayaan.tanggal_akhir, t_pembiayaan.no_rekening,t_pembiayaan.status_rekening as status,t_anggota.id,t_anggota.no_anggota, t_anggota.nama, t_anggota.alamat, p_departemen.departemen, t_anggota.telepon, t_anggota.status_anggota '))
            //     ->leftJoin('t_anggota', 't_anggota.no_anggota', '=', 't_pembiayaan.no_anggota')
            //     ->leftJoin('p_departemen', 'p_departemen.id', '=', 't_anggota.departement_id')
            //     ->with(['jenispinjaman', 'anggota'])
            //     ->whereIn('t_pembiayaan.status_rekening', [0, 4])
            //     ->where('t_anggota.nama', '!=', '')
            //     ->orderBy('t_anggota.nama');

            $pinjaman = Pinjaman::
                // leftJoin('t_anggota', 't_anggota.no_anggota', '=', 't_pembiayaan.no_anggota')
                // ->leftJoin('p_departemen', 'p_departemen.id', '=', 't_anggota.departement_id')
                with(['jenispinjaman', 'anggota', 'detail'])
                ->whereIn('status_rekening', [0, 4]);
            // ->where('t_anggota.nama', '!=', '')
            // ->orderBy('t_anggota.nama');
        } else {
            // $anggota = Anggota::select(DB::raw('t_anggota.id,t_anggota.no_anggota, t_anggota.nama, t_anggota.alamat, p_departemen.departemen, t_anggota.telepon, t_anggota.status_anggota '))
            //                 ->leftJoin('p_departemen','p_departemen.id','=','t_anggota.departement_id')
            //                 ->where('t_anggota.nama','!=','')
            //                 ->orderBy('t_anggota.nama');

            // $pinjaman = Pinjaman::select(DB::raw('t_pembiayaan.id as id_pinjaman,t_pembiayaan.produk_id,t_pembiayaan.jml_pinjaman, t_pembiayaan.saldo_akhir_pokok, t_pembiayaan.jangka_waktu, t_pembiayaan.tanggal_mulai, t_pembiayaan.tanggal_akhir, t_pembiayaan.no_rekening,t_pembiayaan.status_rekening as status,t_anggota.id,t_anggota.no_anggota, t_anggota.nama, t_anggota.alamat, p_departemen.departemen, t_anggota.telepon, t_anggota.status_anggota '))
            //     ->leftJoin('t_anggota', 't_anggota.no_anggota', '=', 't_pembiayaan.no_anggota')
            //     ->leftJoin('p_sumberdana', 'p_sumberdana.id', '=', 't_pembiayaan.sumber_dana')
            //     ->leftJoin('p_departemen', 'p_departemen.id', '=', 't_anggota.departement_id')
            //     ->with(['jenispinjaman', 'anggota'])
            //     ->where('t_anggota.nama', '!=', '')
            //     ->orderBy('t_anggota.nama');
            $pinjaman = Pinjaman::
                // leftJoin('t_anggota', 't_anggota.no_anggota', '=', 't_pembiayaan.no_anggota')
                // ->leftJoin('p_sumberdana', 'p_sumberdana.id', '=', 't_pembiayaan.sumber_dana')
                // ->leftJoin('p_departemen', 'p_departemen.id', '=', 't_anggota.departement_id')
                with(['jenispinjaman', 'anggota', 'detail']);
            // ->where('t_anggota.nama', '!=', '')
            // ->orderBy('t_anggota.nama');
        }
        // dd($pinjaman->get());
        // return $pinjaman->get();
        return DataTables::of($pinjaman)
            ->addIndexColumn()
            ->editColumn('no_anggota', function ($row) {
                return '<b>' . $row->no_anggota . '</b>';
            })
            ->editColumn('no_rekening', function ($row) {
                return '<b>' . $row->no_rekening . '</b>';
            })
            ->editColumn('nama', function ($row) {
                return '<b>' . $row->anggota->nama . '</b>';
            })
            // ->editColumn('alamat', function ($row) {
            //     return '<b>' . $row->alamat . '</b>';
            // })
            // ->editColumn('telepon', function ($row) {
            //     return '<b>' . $row->telepon . '</b>';
            // })
            ->editColumn('nama_produk', function ($row) {
                if (isset($row->jenispinjaman->nama_produk))
                    return '<b>' . $row->jenispinjaman->nama_produk . '</b>';
                else
                    return '-';
            })
            ->editColumn('jml_pinjaman', function ($row) {
                return '<b>Rp. ' . number_format($row->jml_pinjaman, 0, ',', '.') . '</b>';
            })
            ->editColumn('mulai', function ($row) {
                return '<b>' . $row->tanggal_mulai . '</b>';
            })
            ->editColumn('akhir', function ($row) {
                return '<b>' . $row->tanggal_akhir . '</b>';
            })
            ->editColumn('angsuran', function ($row) {
                return '<b>Rp. ' . number_format(floatval($row->detail[0]->total_angsuran ?? 0), 0, ',', '.') . '</b>';
            })
            ->editColumn('jangka_waktu', function ($row) {
                return '<b>' . $row->jangka_waktu . '</b>';
            })
            ->editColumn('saldo', function ($row) {
                return '<b>Rp. ' . number_format(floatval($row->saldo_akhir_pokok), 0, ',', '.') . '</b>';
            })
            ->addColumn('status', function ($row) {
                // $xstatus = '';
                // if ($row->status == 0) {
                //     $xstatus = "<span class='btn btn-sm btn-rounded btn-secondary'>Draft</span>";
                // } elseif ($row->status == 1) {
                //     $xstatus = "<span class='btn btn-sm btn-rounded btn-success'>Aktif</span>";
                // } elseif ($row->status == 2) {
                //     $xstatus = "<span class='btn btn-sm btn-rounded btn-info'>Pencairan</span>";
                // } elseif ($row->status == 3) {
                //     $xstatus = "<span class='btn btn-sm btn-rounded btn-success'>Pelunasan</span>";
                // } elseif ($row->status == 4) {
                //     $xstatus = '<span class="badge font-size-13 bg-warning">Pengajuan Penutupan</span>';
                // } elseif ($row->status == 5) {
                //     $xstatus = "<span class='btn btn-sm btn-rounded btn-danger'>Tidak Aktif</span>";
                // }
                return $row->x_status;
            })
            ->addColumn('aksi', function ($row) use ($request) {
                if ($request->approval) {
                    $btn = '<div class="btn-group">
                                <button type="button" class="btn btn-primary btn-sm">Aksi</button>
                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-chevron-down"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" style="">
                                    <a class="dropdown-item dropdown-menu-end text-success" href="javascript:approve(' . $row->id . ')"><i class="fa fa-check"></i> Approve</a>
                                    <a class="dropdown-item dropdown-menu-end text-danger" href="javascript:tolak(' . $row->id . ')"><i class="fa fa-times"></i> Tolak</a>
                                </div>
                            </div>';
                } else {

                    $btn = '<div class="btn-group">
                                <button type="button" class="btn btn-primary btn-sm">Aksi</button>
                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-chevron-down"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" style="">
                                    <a class="dropdown-item dropdown-menu-end" href="' . route('data.pinjaman.show', $row->id) . '">Detail</a>
                                    <div class="dropdown-divider"></div>
                                </div>
                            </div>';
                }
                return $btn;
            })
            ->rawColumns(['no_rekening', 'no_anggota', 'nama', 'mulai', 'akhir', 'angsuran', 'jangka_waktu', 'saldo', 'status', 'nama_produk', 'jml_pinjaman', 'aksi'])
            ->toJson();
    }

    public function pencairan(Request $request)
    {

        if ($request->approval) {

            $pencairan = Pinjaman::select(DB::raw('t_pembiayaan.id as id_pinjaman,t_pembiayaan.produk_id,t_pembiayaan.jml_pinjaman,t_pembiayaan.nilai_pencairan,t_pembiayaan.nilai_pelunasan,t_pembiayaan.jangka_waktu,t_pembiayaan.asuransi,t_pembiayaan.admin_fee,t_pembiayaan.no_rekening,t_pembiayaan.status_rekening as status,t_pembiayaan.pencairan_date,t_pembiayaan.dana_mengendap,t_anggota.id,t_anggota.no_anggota, t_anggota.nama, t_anggota.alamat, p_departemen.departemen, t_anggota.telepon, t_anggota.status_anggota '))
                ->leftJoin('t_anggota', 't_anggota.no_anggota', '=', 't_pembiayaan.no_anggota')
                ->leftJoin('p_departemen', 'p_departemen.id', '=', 't_anggota.departement_id')
                ->with(['jenispinjaman', 'anggota'])
                ->whereIn('t_pembiayaan.status_rekening', [0, 4])
                ->where('t_anggota.nama', '!=', '')
                ->where('t_pembiayaan.approv_by', '=', 1)
                ->orderBy('t_anggota.nama');
        } else {

            $pencairan = Pinjaman::select(DB::raw('t_pembiayaan.id as id_pinjaman,t_pembiayaan.produk_id,t_pembiayaan.jml_pinjaman,t_pembiayaan.nilai_pencairan,t_pembiayaan.nilai_pelunasan,t_pembiayaan.jangka_waktu,t_pembiayaan.asuransi,t_pembiayaan.admin_fee,t_pembiayaan.no_rekening,t_pembiayaan.status_rekening as status,t_pembiayaan.pencairan_date,t_pembiayaan.dana_mengendap,t_anggota.id,t_anggota.no_anggota, t_anggota.nama, t_anggota.alamat, p_departemen.departemen, t_anggota.telepon, t_anggota.status_anggota '))
                ->leftJoin('t_anggota', 't_anggota.no_anggota', '=', 't_pembiayaan.no_anggota')
                ->leftJoin('p_departemen', 'p_departemen.id', '=', 't_anggota.departement_id')
                ->with(['jenispinjaman', 'anggota'])
                ->where('t_anggota.nama', '!=', '')
                ->where('t_pembiayaan.approv_by', '=', 1)
                ->orderBy('t_anggota.nama');
        }
        // return $pinjaman->get();
        return DataTables::of($pencairan)
            ->addIndexColumn()
            ->editColumn('no_anggota', function ($row) {
                return '<b>' . $row->no_anggota . '</b>';
            })
            ->editColumn('no_rekening', function ($row) {
                return '<b>' . $row->no_rekening . '</b>';
            })
            ->editColumn('nama', function ($row) {
                return '<b>' . $row->nama . '</b>';
            })
            ->editColumn('alamat', function ($row) {
                return '<b>' . $row->alamat . '</b>';
            })
            ->editColumn('telepon', function ($row) {
                return '<b>' . $row->telepon . '</b>';
            })
            ->editColumn('nama_produk', function ($row) {
                if (isset($row->jenispinjaman->nama_produk))
                    return '<b>' . $row->jenispinjaman->nama_produk . '</b>';
                else
                    return '-';
            })
            ->editColumn('jml_pinjaman', function ($row) {
                return '<b>Rp. ' . number_format($row->jml_pinjaman, 0, ',', '.') . '</b>';
            })
            ->editColumn('masa', function ($row) {
                return '<b>' . $row->jangka_waktu . '</b>';
            })
            ->editColumn('admin', function ($row) {
                return '<b>Rp. ' . number_format($row->admin_fee, 0, ',', '.') . '</b>';
            })
            ->editColumn('asuransi', function ($row) {
                return '<b>Rp. ' . number_format($row->asuransi, 0, ',', '.') . '</b>';
            })
            ->editColumn('nilai_pelunasan', function ($row) {
                return '<b>Rp. ' . number_format($row->nilai_pelunasan, 0, ',', '.') . '</b>';
            })
            ->editColumn('nilai_pencairan', function ($row) {
                return '<b>Rp. ' . number_format($row->nilai_pencairan, 0, ',', '.') . '</b>';
            })
            ->editColumn('dana_mengendap', function ($row) {
                return '<b>Rp. ' . number_format($row->dana_mengendap, 0, ',', '.') . '</b>';
            })
            ->editColumn('pencairan_date', function ($row) {
                return '<b>' . $row->pencairan_date . '</b>';
            })
            ->addColumn('status', function ($row) {
                $xstatus = '';
                if ($row->status == 0) {
                    $xstatus = "<span class='btn btn-sm btn-rounded btn-secondary'>Draft</span>";
                } elseif ($row->status == 1) {
                    $xstatus = "<span class='btn btn-sm btn-rounded btn-success'>Aktif</span>";
                } elseif ($row->status == 2) {
                    $xstatus = "<span class='btn btn-sm btn-rounded btn-info'>Pencairan</span>";
                } elseif ($row->status == 3) {
                    $xstatus = "<span class='btn btn-sm btn-rounded btn-success'>Pelunasan</span>";
                } elseif ($row->status == 4) {
                    $xstatus = '<span class="badge font-size-13 bg-warning">Pengajuan Penutupan</span>';
                } elseif ($row->status == 5) {
                    $xstatus = "<span class='btn btn-sm btn-rounded btn-danger'>Tidak Aktif</span>";
                }
                return $xstatus;
            })
            ->addColumn('aksi', function ($row) use ($request) {
                if ($request->approval) {
                    $btn = '<div class="btn-group">
                                <button type="button" class="btn btn-primary btn-sm">Aksi</button>
                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-chevron-down"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" style="">
                                    <a class="dropdown-item dropdown-menu-end text-success" href="javascript:approve(' . $row->no_anggota . ')"><i class="fa fa-check"></i> Approve</a>
                                    <a class="dropdown-item dropdown-menu-end text-danger" href="javascript:tolak(' . $row->no_anggota . ')"><i class="fa fa-times"></i> Tolak</a>
                                </div>
                            </div>';
                } else {
                    //button untuk proses untuk pencairan
                    $btn = '<div class="btn-group">
                                <button type="button" class="btn btn-primary btn-sm">Aksi</button>
                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-chevron-down"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" style="">
                                    <a class="dropdown-item dropdown-menu-end" href="' . route('data.pencairan.show', $row->id_pinjaman) . '">Pencairan</a>
                                   
                                    <div class="dropdown-divider"></div>
                                </div>
                            </div>';
                }
                return $btn;
            })
            ->rawColumns(['no_rekening', 'no_anggota', 'nama', 'jml_pinjaman', 'masa', 'admin', 'asuransi', 'nilai_pelunasan', 'nilai_pencairan', 'dana_mengendap', 'pencairan_date', 'status', 'aksi'])
            ->toJson();
    }

    public function pelunasan(Request $request)
    {
        $pelunasan = Pinjaman::select(DB::raw('t_pembiayaan.id as id_pinjaman,t_pembiayaan.produk_id,t_pembiayaan.jml_pinjaman,t_pembiayaan.nilai_pencairan,t_pembiayaan.nilai_pelunasan,t_pembiayaan.jangka_waktu,t_pembiayaan.asuransi,t_pembiayaan.admin_fee,t_pembiayaan.no_rekening,t_pembiayaan.status_rekening as status,t_pembiayaan.pencairan_date,t_pembiayaan.dana_mengendap,t_anggota.id,t_anggota.no_anggota, t_anggota.nama, t_anggota.alamat, p_departemen.departemen, t_anggota.telepon, t_anggota.status_anggota '))
            ->leftJoin('t_anggota', 't_anggota.no_anggota', '=', 't_pembiayaan.no_anggota')
            ->leftJoin('p_departemen', 'p_departemen.id', '=', 't_anggota.departement_id')
            ->with(['jenispinjaman', 'anggota'])
            ->where('t_anggota.nama', '!=', '')
            ->where('t_pembiayaan.approv_by', '=', 1)
            ->orderBy('t_anggota.nama');

        // return $pinjaman->get();
        return DataTables::of($pelunasan)
            ->addIndexColumn()
            ->editColumn('no_rekening', function ($row) {
                return '<b>' . $row->no_rekening . '</b>';
            })
            ->editColumn('no_anggota', function ($row) {
                return '<b>' . $row->no_anggota . '</b>';
            })
            ->editColumn('nama', function ($row) {
                return '<b>' . $row->nama . '</b>';
            })
            ->editColumn('nilai_pelunasan', function ($row) {
                return '<b>Rp. ' . number_format($row->nilai_pelunasan, 0, ',', '.') . '</b>';
            })
            ->editColumn('jml_pinjaman', function ($row) {
                return '<b>Rp. ' . number_format($row->jml_pinjaman, 0, ',', '.') . '</b>';
            })
            ->editColumn('pencairan_date', function ($row) {
                return '<b>' . $row->pencairan_date . '</b>';
            })
            ->addColumn('status', function ($row) {
                $xstatus = '';
                if ($row->status == 0) {
                    $xstatus = "<span class='btn btn-sm btn-rounded btn-secondary'>Draft</span>";
                } elseif ($row->status == 1) {
                    $xstatus = "<span class='btn btn-sm btn-rounded btn-success'>Aktif</span>";
                } elseif ($row->status == 2) {
                    $xstatus = "<span class='btn btn-sm btn-rounded btn-info'>Pencairan</span>";
                } elseif ($row->status == 3) {
                    $xstatus = "<span class='btn btn-sm btn-rounded btn-success'>Pelunasan</span>";
                } elseif ($row->status == 4) {
                    $xstatus = '<span class="badge font-size-13 bg-warning">Pengajuan Penutupan</span>';
                } elseif ($row->status == 5) {
                    $xstatus = "<span class='btn btn-sm btn-rounded btn-danger'>Tidak Aktif</span>";
                }
                return $xstatus;
            })
            ->addColumn('aksi', function ($row) use ($request) {
                if ($request->approval) {
                    $btn = '<div class="btn-group">
                                <button type="button" class="btn btn-primary btn-sm">Aksi</button>
                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-chevron-down"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" style="">
                                    <a class="dropdown-item dropdown-menu-end text-success" href="javascript:approve(' . $row->no_anggota . ')"><i class="fa fa-check"></i> Approve</a>
                                    <a class="dropdown-item dropdown-menu-end text-danger" href="javascript:tolak(' . $row->no_anggota . ')"><i class="fa fa-times"></i> Tolak</a>
                                </div>
                            </div>';
                } else {
                    //button untuk proses untuk pencairan
                    $btn = '<div class="btn-group">
                                <button type="button" class="btn btn-primary btn-sm">Aksi</button>
                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-chevron-down"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" style="">
                                    <a class="dropdown-item dropdown-menu-end" href="' . route('data.pelunasan.addPelunasan', ['idPinjaman' => $row->id_pinjaman, 'type' => 1]) . '">Pelunasan Sesuai Cicilan</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item dropdown-menu-end" href="' . route('data.pelunasan.addPelunasan', ['idPinjaman' => $row->id_pinjaman, 'type' => 2]) . '">Pelunasan Dipercepat</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item dropdown-menu-end" href="' . route('data.pelunasan.addPelunasan', ['idPinjaman' => $row->id_pinjaman, 'type' => 3]) . '">Pelunasan Topup</a>
                                    <div class="dropdown-divider"></div>
                                </div>
                            </div>';
                }
                return $btn;
            })
            ->rawColumns(['no_rekening', 'no_anggota', 'nama', 'pencairan_date', 'jml_pinjaman', 'nilai_pelunasan', 'aksi'])
            ->toJson();
    }

    public function potonganHRD(Request $request)
    {
        // $pelunasan = Anggota::select(DB::raw('t_pembiayaan.id as id_pinjaman,t_pembiayaan.produk_id,t_pembiayaan.jml_pinjaman,t_pembiayaan.nilai_pencairan,t_pembiayaan.nilai_pelunasan,t_pembiayaan.jangka_waktu,t_pembiayaan.asuransi,t_pembiayaan.admin_fee,t_pembiayaan.no_rekening,t_pembiayaan.status_rekening as status,t_pembiayaan.pencairan_date,t_pembiayaan.dana_mengendap,t_anggota.id,t_anggota.no_anggota, t_anggota.nama, t_anggota.alamat, p_departemen.departemen, t_anggota.telepon, t_anggota.status_anggota '))
        //     ->leftJoin('t_anggota', 't_anggota.no_anggota', '=', 't_pembiayaan.no_anggota')
        //     ->leftJoin('p_departemen', 'p_departemen.id', '=', 't_anggota.departement_id')
        //     ->with(['jenispinjaman', 'anggota'])
        //     ->where('t_anggota.nama', '!=', '')
        //     ->where('t_pembiayaan.approv_by', '=', 1)
        //     ->orderBy('t_anggota.nama');

        // $anggota = Anggota::orderBy('no_anggota');
        $anggota = Anggota::select(DB::raw('*'))
            ->with([
                'simpananAnggota' => function ($q) use ($request) {
                    $q
                        ->with(['detailSimpas' => function ($q2) use ($request) {
                            $q2
                                ->whereNull('deleted_at')
                                ->where('tahun', $request->tahun)
                                ->where('bulan', $request->bulan);
                        }])
                        ->where([
                            ['produk_id', '=', 1],
                            ['status_rekening', '=', 1]
                        ]);
                },
                'pinjamanAnggota' => function ($q) use ($request) {
                    $q
                        ->with(['detail' => function ($q2) use ($request) {
                            $q2
                                ->whereNull('deleted_at')
                                ->where('tahun', $request->tahun)
                                ->where('bulan', $request->bulan);
                        }])
                        ->whereIn('status_rekening', [2, 3])
                        ->where('sisa_hutangs', '>', '0');
                }
            ])
            ->orderBy('t_anggota.no_anggota');


        return DataTables::of($anggota)
            ->addIndexColumn()
            ->editColumn('no_anggota', function ($row) {
                return '<b>' . $row->no_anggota . '</b>';
            })
            ->editColumn('nama', function ($row) {
                return '<b>' . $row->nama . '</b>';
            })
            ->editColumn('kode_profit', function ($row) {
                if ($row->profits === NULL) {
                    return '<b>' . '-' . '</b>';
                } else {
                    return '<b>' . $row->profits->kode . '</b>';
                }
            })
            ->editColumn('total_potongan', function ($row) {
                $simpananArr = json_decode(json_encode($row->simpananAnggota), true);
                $totalAngsuranSimpas = 0;
                if (count($simpananArr) > 0 && count($simpananArr[0]['detail_simpas']) > 0) {
                    $detailsimpananArr = array_map(function ($val) {
                        return $val['tabungan_per_bulan'];
                    }, $simpananArr[0]['detail_simpas']);
                    $totalAngsuranSimpas = array_sum($detailsimpananArr);
                }
                $pinjamanArr = json_decode(json_encode($row->pinjamanAnggota), true);
                $totalAngsuran = 0;
                if (count($pinjamanArr) > 0 && count($pinjamanArr[0]['detail']) > 0) {
                    $detailPinjamanArr = array_map(function ($val) {
                        return $val['total_angsuran'];
                    }, $pinjamanArr[0]['detail']);
                    $totalAngsuran = array_sum($detailPinjamanArr);
                }
                $totalPotongan = $totalAngsuranSimpas + $totalAngsuran;
                return '<b>' . number_format($totalPotongan, 0) . '</b>';
            })
            ->editColumn('potongan_koperasi', function ($row) {
                if (count($row->pinjamanAnggota) < 1) {
                    return '<b>' . 0 . '</b>';
                } else {
                    $pinjamanArr = json_decode(json_encode($row->pinjamanAnggota), true);
                    $totalAngsuran = 0;
                    if (count($pinjamanArr) > 0 && count($pinjamanArr[0]['detail']) > 0) {
                        $detailPinjamanArr = array_map(function ($val) {
                            return $val['total_angsuran'];
                        }, $pinjamanArr[0]['detail']);
                        $totalAngsuran = array_sum($detailPinjamanArr);
                    }
                    return '<b>' . number_format($totalAngsuran, 0) . '</b>';
                }
            })
            ->editColumn('potongan_sembako', function ($row) {
                return '<b>' . 0 . '</b>';
            })
            ->editColumn('potongan_simpas', function ($row) {
                if (count($row->simpananAnggota) < 1) {
                    return '<b>' . 0 . '</b>';
                } else {
                    // return '<b>' . $row->simpananAnggota . '</b>';
                    $simpananArr = json_decode(json_encode($row->simpananAnggota), true);
                    $totalAngsuranSimpas = 0;
                    if (count($simpananArr) > 0 && count($simpananArr[0]['detail_simpas']) > 0) {
                        $detailsimpananArr = array_map(function ($val) {
                            return $val['tabungan_per_bulan'];
                        }, $simpananArr[0]['detail_simpas']);
                        $totalAngsuranSimpas = array_sum($detailsimpananArr);
                    }
                    return '<b>' . number_format($totalAngsuranSimpas, 0) . '</b>';
                }
            })
            ->editColumn('potongan_dkm', function ($row) {
                return '<b>' . number_format($row->dkm, 0) . '</b>';
            })
            ->editColumn('sisa_potongan', function ($row) {
                $pinjamanArr = json_decode(json_encode($row->pinjamanAnggota), true);
                $totalHutang = array_sum(array_column($pinjamanArr, 'sisa_hutangs'));
                return '<b>' . number_format($totalHutang, 0) . '</b>';
            })
            ->editColumn('potongan_pokok', function ($row) {
                return '<b>' . number_format($row->sim_pokok, 0) . '</b>';
            })
            ->editColumn('potongan_wajib', function ($row) {
                return '<b>' . number_format($row->sim_wajib, 0) . '</b>';
            })
            ->rawColumns(['kode_profit', 'no_anggota', 'nama', 'total_potongan', 'potongan_koperasi', 'potongan_sembako', 'potongan_simpas',  'potongan_dkm', 'sisa_potongan', 'potongan_pokok', 'potongan_wajib'])
            ->toJson();
    }

    public function shu(Request $request)
    {

        if ($request->approval) {
            $shu = Shu::whereIn('status', [0, 4])->orderBy('tahun', 'desc');
        } else {
            $shu = Shu::orderBy('tahun', 'desc');
        }
        // return $pinjaman->get();
        return DataTables::of($shu)
            ->addIndexColumn()
            ->editColumn('tahun', function ($row) {
                return '<b>' . $row->tahun . '</b>';
            })
            ->editColumn('alokasi_shu', function ($row) {
                return '<b>' . number_format($row->alokasi_shu, 0) . '</b>';
            })
            ->editColumn('pengurus', function ($row) {
                return '<b>' . number_format($row->shu_pengurus, 0) . '</b>';
            })
            ->editColumn('anggota', function ($row) {
                return '<b>' . number_format($row->shu_anggota, 0) . '</b>';
            })
            ->addColumn('status', function ($row) {
                $xstatus = '';
                if ($row->status == 0) {
                    $xstatus = "<span class='btn btn-sm btn-rounded btn-secondary'>Draft</span>";
                } elseif ($row->status == 1) {
                    $xstatus = "<span class='btn btn-sm btn-rounded btn-success'>Aktif</span>";
                } elseif ($row->status == 5) {
                    $xstatus = "<span class='btn btn-sm btn-rounded btn-danger'>Tidak Aktif</span>";
                }
                return $xstatus;
            })
            ->addColumn('aksi', function ($row) use ($request) {
                if ($request->approval) {
                    $btn = '<div class="btn-group">
                                <button type="button" class="btn btn-primary btn-sm">Aksi</button>
                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-chevron-down"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" style="">
                                    <a class="dropdown-item dropdown-menu-end text-success" href="javascript:approve(\'' . $row->uuid . '\')"><i class="fa fa-check"></i> Approve</a>
                                    <a class="dropdown-item dropdown-menu-end text-danger" href="javascript:tolak(\'' . $row->uuid . '\')"><i class="fa fa-times"></i> Tolak</a>
                                </div>
                            </div>';
                } else {

                    $btn = '<div class="btn-group">
                                <button type="button" class="btn btn-primary btn-sm">Aksi</button>
                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-chevron-down"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" style="">
                                    <a class="dropdown-item dropdown-menu-end" href="' . route('data.shu.show', $row->uuid) . '">Detail</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item dropdown-menu-end" href="javascript:hapus(\'' . $row->uuid . '\')">Hapus</a>
                                </div>
                            </div>';
                }
                return $btn;
            })
            ->rawColumns(['tahun', 'alokasi_shu', 'pengurus', 'anggota', 'status', 'aksi'])
            ->toJson();
    }

    public function rincian_anggota(Request $request)
    {
        if ($request->approval) {
            $anggota = Anggota::whereIn('status_anggota', [0, 4])->where('created_at')->orderBy('no_anggota');
        } else {
            $anggota = Anggota::orderBy('no_anggota');
        }

        // GET SIMPTOT
        // SELECT t_anggota.no_anggota, sum(saldo_akhir), p_grade.simp_pokok, grade_id, COALESCE(sum(saldo_akhir),0)+ p_grade.simp_pokok simpanan FROM `t_simpanan` right join t_anggota on t_simpanan.no_anggota=t_anggota.no_anggota left join p_grade on p_grade.id=t_anggota.grade_id GROUP by t_anggota.no_anggota; 

        $totSimpanan = DB::table('t_simpanan')
            ->select(DB::raw("sum(saldo_akhir) as totalSimpanan"))
            ->where('status_rekening', '=', 1)
            ->groupBy(DB::raw("YEAR(created_at)"))
            ->first();


        return DataTables::of($anggota)
            ->addIndexColumn()
            ->editColumn('no_anggota', function ($row) {
                return '<b>' . $row->no_anggota . '</b>';
            })
            ->editColumn('nama', function ($row) {
                return '<b>' . $row->nama . '</b>';
            })
            ->editColumn('telepon', function ($row) {
                return '<b>' . $row->telepon . '</b>';
            })
            ->editColumn('departemen', function ($row) {
                return '<b>' . $row->departement . '</b>';
            })
            // still total simpanan
            ->addColumn('simpanan', function ($row) {
                return 'Rp. ' . number_format(($row->shuDetail->simwa  ?? '0') + ($row->shuDetail->saldo_shu ?? '0') + ($row->grades->simp_pokok ?? '0'));
                // return 'Rp. ' . ($row->grades->simp_pokok ?? '0');
            })
            // rata-rata pinjaman
            ->addColumn('saldo_pinjaman', function ($row) {
                return 'Rp. ' . number_format(($row->shuDetail->saldo_pinjaman ?? '0') / 12);
            })
            // rerata sembako
            ->addColumn('sembako', function ($row) {
                return 'Rp. ' . number_format(($row->shuDetail->sembako ?? '0') / 12);
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
            ->addColumn('aksi', function ($row) use ($request) {
                if ($request->approval) {
                    $btn = '<div class="btn-group">
                        <button type="button" class="btn btn-primary btn-sm">Aksi</button>
                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="mdi mdi-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" style="">
                            <a class="dropdown-item dropdown-menu-end text-success" href="javascript:approve(' . $row->id . ')"><i class="fa fa-check"></i> Approve</a>
                            <a class="dropdown-item dropdown-menu-end text-danger" href="javascript:tolak(' . $row->id . ')"><i class="fa fa-times"></i> Tolak</a>
                        </div>
                    </div>';
                } else {
                    $btn = '<div class="btn-group">
                        <button type="button" class="btn btn-primary btn-sm">Aksi</button>
                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="mdi mdi-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" style="">
                            <a class="dropdown-item dropdown-menu-end" href="' . route('data.anggota.show', $row->id) . '">Detail</a>
                            <a class="dropdown-item dropdown-menu-end" href="' . route('data.anggota.edit', $row->id) . '">Edit</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item dropdown-menu-end" href="javascript:penutupan(\'' . $row->id . '\',\'' . $row->nama . '\',\'' . $row->no_anggota . '\')">Pengajuan Terminasi</a>
                            <a class="dropdown-item dropdown-menu-end" href="javascript:hapus(\'' . $row->id . '\')">Hapus</a>
                        </div>
                    </div>';
                }
                return $btn;
            })
            ->rawColumns(['no_anggota', 'nama', 'telepon', 'alamat', 'status', 'aksi'])
            ->toJson();
    }

    public function pengguna(Request $request)
    {
        $pengguna = User::orderBy('nama');

        return DataTables::of($pengguna)
            ->addIndexColumn()
            ->editColumn('nama', function ($row) {
                return '<b>' . $row->nama . '</b>';
            })
            ->editColumn('email', function ($row) {
                return '<b>' . $row->email . '</b>';
            })
            ->editColumn('telepon', function ($row) {
                return '<b>' . $row->telepon . '</b>';
            })
            ->editColumn('username', function ($row) {
                return '<b>' . $row->username . '</b>';
            })
            ->addColumn('status', function ($row) {
                if ($row->status_akses == 0)
                    return '<span class="badge font-size-13 bg-secondary">Tidak Aktif</span>';
                elseif ($row->status_akses == 1)
                    return '<span class="badge font-size-13 bg-success">Aktif</span>';
                else
                    return '<span class="badge font-size-13 bg-danger">-</span>';
            })
            ->addColumn('g_akses', function ($row) {
                if ($row->group_akses == 1)
                    return '<span class="badge font-size-13 bg-primary">Admin</span>';
                elseif ($row->group_akses == 2)
                    return '<span class="badge font-size-13 bg-success">Operator</span>';
                elseif ($row->group_akses == 3)
                    return '<span class="badge font-size-13 bg-info">Pengurus Koperasi</span>';
                else
                    return '<span class="badge font-size-13 bg-danger">-</span>';
            })
            ->addColumn('aksi', function ($row) use ($request) {

                $btn = '<div class="btn-group">
                            <button type="button" class="btn btn-primary btn-sm">Aksi</button>
                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" style="">
                                <a class="dropdown-item dropdown-menu-end" href="' . route('data.pengguna.edit', $row->id) . '">Edit</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item dropdown-menu-end" href="javascript:hapus(\'' . $row->id . '\')">Hapus</a>
                            </div>
                        </div>';

                return $btn;
            })
            ->rawColumns(['nama', 'email', 'telepon', 'username', 'status', 'g_akses', 'aksi'])
            ->toJson();
    }
}
