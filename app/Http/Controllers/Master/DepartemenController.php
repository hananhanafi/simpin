<?php

namespace App\Http\Controllers\Master;

use App\Models\Master\Departemen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Master\RequestDepartemen;

class DepartemenController extends Controller
{
    public function index(){
        return view('pages.master.departemen.index');
    }
    public function create(){
        return view('pages.master.departemen.create');
    }

    public function store(RequestDepartemen $request){
        try{
            DB::beginTransaction();

            $departemen = new Departemen;
            $departemen->parent_id      = 0;
            $departemen->kode           = $request->kode;
            $departemen->departemen     = $request->departemen;
            $departemen->save();

            DB::commit();
            Session::flash('success','Tambah Data Departemen  Baru Berhasil');

        }catch(Exception $ex){
            DB::rollback();
            Session::flash('fail','Tambah Data Departemen  Baru Tidak Berhasil');
        }
        return redirect()->route('master.departemen.index');
    }

    public function edit($id){
        $departemen = Departemen::find($id);
        return view('pages.master.departemen.edit')
            ->with('departemen',$departemen)
            ->with('id',$id);
    }

    public function show($id){
        $departemen = Departemen::where('id',$id)
                    ->with('sub_departemen')
                    ->first();
        return view('pages.master.departemen.show')
                ->with('id', $id)
                ->with('departemen', $departemen);
    }

    public function update(RequestDepartemen $request,$id){
        try{
            DB::beginTransaction();

            $departemen = Departemen::find($id);
            $departemen->parent_id      = 0;
            $departemen->kode           = $request->kode;
            $departemen->departemen     = $request->departemen;
            $departemen->save();

            DB::commit();
            Session::flash('success','Update Data Departemen  Berhasil');

        }catch(Exception $ex){
            DB::rollback();
            Session::flash('fail','Update Data Departemen  Tidak Berhasil');
        }
        return redirect()->route('master.departemen.index');
    }

    public function destroy($id){
        $departemen = Departemen::find($id);
        $departemen->delete();
        Session::flash('success','Hapus Data Departemen  Berhasil');
        return redirect()->route('master.departemen.index');
    }
}
