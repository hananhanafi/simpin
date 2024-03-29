<?php

namespace App\Http\Controllers\Master;

use Exception;
use App\Models\Master\SumberDana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Master\RequestSumberDana;

class SumberDanaController extends Controller
{
    public function index()
    {
        return view('pages.master.sumber-dana.index');
    }
    public function create()
    {
        return view('pages.master.sumber-dana.create');
    }

    public function store(RequestSumberDana $request)
    {
        $danaCheck = SumberDana::where('kode', '=', $request->kode)->whereNull('deleted_at')->get();
        // dd($produkCheck);
        if (count($danaCheck) > 0) {
            Session::flash('fail', 'Kode ' . $request->kode . ' Sudah Ada. Silahkan Gunakan Kode Produk Type Lain');
            // return redirect()->back();
            return redirect()->route('master.sumber-dana.create');
        }
        try {
            DB::beginTransaction();

            $biayaBank = intVal(str_replace('.', '', $request->biaya_bank));
            $sumberdana = new SumberDana;
            $sumberdana->kode           = $request->kode;
            $sumberdana->sumber_dana    = $request->sumber_dana;
            $sumberdana->biaya_bank         = $biayaBank;
            $sumberdana->save();

            DB::commit();
            Session::flash('success', 'Tambah Data Sumber DanaBaru Berhasil');
        } catch (Exception $ex) {
            DB::rollback();
            Session::flash('fail', 'Tambah Data Sumber DanaBaru Tidak Berhasil');
        }
        return redirect()->route('master.sumber-dana.index');
    }

    public function edit($id)
    {
        $sumberdana = SumberDana::find($id);
        return view('pages.master.sumber-dana.edit')
            ->with('sumberdana', $sumberdana)
            ->with('id', $id);
    }

    public function show($id)
    {
        $sumberdana = SumberDana::where('id', $id)
            ->with('sub_sumber-dana')
            ->first();

        return view('pages.master.sumber-dana.show')
            ->with('id', $id)
            ->with('sumberdana', $sumberdana);
    }

    public function update(RequestSumberDana $request, $id)
    {
        try {
            DB::beginTransaction();

            $biayaBank = intVal(str_replace('.', '', $request->biaya_bank));
            $sumberdana = SumberDana::find($id);
            $sumberdana->kode           = $request->kode;
            $sumberdana->sumber_dana    = $request->sumber_dana;
            $sumberdana->biaya_bank         = $biayaBank;
            $sumberdana->save();

            DB::commit();
            Session::flash('success', 'Update Data Sumber Dana Berhasil');
        } catch (Exception $ex) {
            DB::rollback();
            Session::flash('fail', 'Update Data Sumber Dana Tidak Berhasil');
        }
        return redirect()->route('master.sumber-dana.index');
    }

    public function destroy($id)
    {
        $sumberdana = SumberDana::find($id);
        $sumberdana->delete();
        Session::flash('success', 'Hapus Data Sumber Dana Berhasil');
        return redirect()->route('master.sumber-dana.index');
    }
}
