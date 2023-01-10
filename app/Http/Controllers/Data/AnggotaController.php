<?php

namespace App\Http\Controllers\Data;

use Exception;
use App\Models\Data\Anggota;
use App\Models\Master\Grade;
use Illuminate\Http\Request;
use App\Models\Master\Departemen;
use Illuminate\Support\Facades\DB;
use App\Models\Master\ProfitCenter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Data\RequestAnggota;

class AnggotaController extends Controller
{
    public function index()
    {
        return view('pages.data.anggota.index');
    }

    public function create()
    {
        $departemen = Departemen::orderBy('kode')->get();
        $grade      = Grade::orderBy('kode')->get();
        $profit     = ProfitCenter::orderBy('kode')->get();
        return view('pages.data.anggota.create')
            ->with('departemen', $departemen)
            ->with('profit', $profit)
            ->with('grade', $grade);
    }

    public function store(RequestAnggota $request)
    {
        try {
            DB::beginTransaction();

            $gaji = intval(str_replace('.', '', $request->gaji));

            list($gradeId, $simpPokok, $simpWajib) = explode('__', $request->grade_id);

            $anggota = new Anggota;
            $anggota->no_anggota    = $request->no_anggota;
            $anggota->nama          = $request->nama;
            $anggota->nik           = $request->ktp;
            $anggota->no_kk         = $request->no_kk;
            $anggota->noka_bpjs     = $request->noka_bpjs;
            $anggota->tmp_lahir     = $request->tmp_lahir;
            $anggota->tgl_lahir     = $request->tgl_lahir;
            $anggota->jenis_kelamin = $request->jenis_kelamin;
            $anggota->alamat        = $request->alamat;
            $anggota->email         = $request->email;
            $anggota->telepon       = $request->telepon;
            $anggota->telepon_ext   = $request->telepon_ext;
            $anggota->no_ktp        = $request->ktp;
            $anggota->npwp          = $request->npwp;
            $anggota->pekerjaan         = '';
            $anggota->lokasi_kerja      = '';
            $anggota->departement_id    = $request->departement_id;
            $anggota->section           = '';
            $anggota->goldar            = $request->goldar;
            $anggota->agama             = $request->agama;
            $anggota->grade_id          = $gradeId;
            $anggota->profit_id         = $request->profit_id;
            $anggota->sim_pokok         = $simpPokok;
            $anggota->sim_wajib         = $simpWajib;
            $anggota->sim_khusus         = $request->sim_khusus;
            $anggota->dkm                = $request->dkm;
            $anggota->gaji              = $gaji;
            $anggota->gaji_updated     = date('Y-m-d H:i:s');
            $anggota->bank_nama         = $request->bank_nama;
            $anggota->bank_code         = $request->bank_code;
            $anggota->bank_cabang       = '';
            $anggota->bank_norek        = $request->bank_norek;
            $anggota->status_ebanking   = $request->status_ebanking;
            $anggota->passwd            = '';
            $anggota->status_anggota    = 0;
            $anggota->status_emp        = '';
            // $anggota->masukkerja_date   = date('Y-m-d H:i:s');
            $anggota->masukkerja_date   = $request->masukkerja_date;
            $anggota->catatan           = '';
            $anggota->reg_date          = date('Y-m-d H:i:s');
            $anggota->reg_by            = Auth::user()->id;
            $anggota->update_date       = date('Y-m-d H:i:s');
            $anggota->update_by         = 0;
            $anggota->terminate_date    = date('Y-m-d H:i:s');
            $anggota->terminate_by      = 0;
            $anggota->terminate_date    = date('Y-m-d H:i:s');
            $anggota->save();

            DB::commit();
            Session::flash('success', 'Tambah Data Anggota  Baru Berhasil');
        } catch (Exception $ex) {
            DB::rollback();
            Session::flash('fail', 'Tambah Data Anggota  Baru Tidak Berhasil');
        }
        return redirect()->route('data.anggota.index');
    }

    public function show($id)
    {
        $departemen = Departemen::orderBy('kode')->get();
        $grade      = Grade::orderBy('kode')->get();
        $profit     = ProfitCenter::orderBy('kode')->get();
        $anggota    = Anggota::find($id);
        return view('pages.data.anggota.show')
            ->with('id', $id)
            ->with('departemen', $departemen)
            ->with('profit', $profit)
            ->with('anggota', $anggota)
            ->with('grade', $grade);
    }

    public function edit($id)
    {
        $departemen = Departemen::orderBy('kode')->get();
        $grade      = Grade::orderBy('kode')->get();
        $profit     = ProfitCenter::orderBy('kode')->get();
        $anggota    = Anggota::find($id);
        return view('pages.data.anggota.edit')
            ->with('id', $id)
            ->with('departemen', $departemen)
            ->with('profit', $profit)
            ->with('anggota', $anggota)
            ->with('grade', $grade);
    }

    public function update(RequestAnggota $request, $id)
    {
        try {
            DB::beginTransaction();
            $gaji = intval(str_replace('.', '', $request->gaji));

            list($gradeId, $simpPokok, $simpWajib) = explode('__', $request->grade_id);

            $anggota = Anggota::find($id);
            $anggota->no_anggota        = $request->no_anggota;
            $anggota->nama              = $request->nama;
            $anggota->nik               = $request->ktp;
            $anggota->no_kk             = $request->no_kk;
            $anggota->noka_bpjs         = $request->noka_bpjs;
            $anggota->tmp_lahir         = $request->tmp_lahir;
            $anggota->tgl_lahir         = $request->tgl_lahir;
            $anggota->jenis_kelamin     = $request->jenis_kelamin;
            $anggota->alamat            = $request->alamat;
            $anggota->email             = $request->email;
            $anggota->telepon           = $request->telepon;
            $anggota->telepon_ext       = $request->telepon_ext;
            $anggota->no_ktp            = $request->ktp;
            $anggota->npwp              = $request->npwp;
            $anggota->pekerjaan         = '';
            $anggota->lokasi_kerja      = '';
            $anggota->departement_id    = $request->departement_id;
            $anggota->section           = '';
            $anggota->goldar            = $request->goldar;
            $anggota->agama             = $request->agama;
            $anggota->grade_id          = $gradeId;
            $anggota->profit_id         = $request->profit_id;
            $anggota->sim_pokok         = $simpPokok;
            $anggota->sim_khusus         = $request->sim_khusus;
            $anggota->dkm                = $request->dkm;
            $anggota->gaji              = $gaji;
            $anggota->gaji_updated      = date('Y-m-d H:i:s');
            $anggota->bank_nama         = $request->bank_nama;
            $anggota->bank_code         = $request->bank_code;
            $anggota->bank_cabang       = '';
            $anggota->bank_norek        = $request->bank_norek;
            $anggota->status_ebanking   = $request->status_ebanking;
            $anggota->passwd            = '';
            $anggota->status_anggota    = 0;
            $anggota->status_emp        = '';

            $anggota->masukkerja_date   = $request->masukkerja_date;

            $anggota->catatan           = '';
            $anggota->reg_date          = date('Y-m-d H:i:s');
            $anggota->reg_by            = 0;
            $anggota->update_date       = date('Y-m-d H:i:s');
            $anggota->update_by         = Auth::user()->id;
            $anggota->terminate_date    = date('Y-m-d H:i:s');
            $anggota->terminate_by      = 0;
            $anggota->save();

            DB::commit();
            Session::flash('success', 'Update Data Anggota Berhasil');
        } catch (Exception $ex) {
            DB::rollback();
            Session::flash('fail', 'Update Data Anggota Tidak Berhasil');
        }
        return redirect()->route('data.anggota.index');
    }

    public function penutupan(Request $request)
    {
        // return $request;
        $anggota                        = Anggota::find($request->id_anggota);
        if ($anggota) {
            $anggota->status_anggota    = 4;
            $anggota->catatan           = $request->keterangan;
            $anggota->update_date       = date('Y-m-d H:i:s');
            $anggota->update_by         = Auth::user()->id;
            $anggota->terminate_date    = date('Y-m-d H:i:s');
            $anggota->terminate_by      = Auth::user()->id;
            $anggota->catatan           = $request->keterangan;
            $anggota->save();

            Session::flash('success', 'Pengajuan Terminasi Data Anggota Berhasil');
        } else {
            Session::flash('fail', 'Pengajuan Terminasi Data Anggota Tidak Berhasil');
        }

        return redirect()->route('data.anggota.index');
    }

    public function destroy($id)
    {
        $anggota    = Anggota::find($id);
        $anggota->delete();
        Session::flash('success', 'Hapus Data Anggota Berhasil');
        return redirect()->route('data.anggota.index');
    }
}
