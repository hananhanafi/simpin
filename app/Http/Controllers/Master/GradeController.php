<?php

namespace App\Http\Controllers\Master;

use App\Models\Master\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Master\RequestGrade;

class GradeController extends Controller
{
    public function index(){
        return view('pages.master.grade.index');
    }
    public function create(){
        return view('pages.master.grade.create');
    }

    public function store(RequestGrade $request){
        try{
            DB::beginTransaction();

            $grade = new Grade;
            $grade->kode	        = $request->kode;
            $grade->grade_name	    = $request->grade_name;
            $grade->simp_pokok	    = $request->simp_pokok;
            $grade->simp_wajib	    = $request->simp_wajib;
            $grade->simp_sukarela	= $request->simp_sukarela;
            $grade->save();

            DB::commit();
            Session::flash('success','Tambah Data Grade Anggota Baru Berhasil');

        }catch(Exception $ex){
            DB::rollback();
            Session::flash('fail','Tambah Data Grade Anggota Baru Tidak Berhasil');
        }
        return redirect()->route('master.grade.index');
    }

    public function edit($id){
        $grade = Grade::find($id);
        return view('pages.master.grade.edit')
            ->with('grade',$grade)
            ->with('id',$id);
    }

    public function update(RequestGrade $request,$id){
        try{
            DB::beginTransaction();

            $grade = Grade::find($id);
            $grade->kode	        = $request->kode;
            $grade->grade_name	    = $request->grade_name;
            $grade->simp_pokok	    = $request->simp_pokok;
            $grade->simp_wajib	    = $request->simp_wajib;
            $grade->simp_sukarela	= $request->simp_sukarela;
            $grade->save();

            DB::commit();
            Session::flash('success','Update Data Grade Anggota Berhasil');

        }catch(Exception $ex){
            DB::rollback();
            Session::flash('fail','Update Data Grade Anggota Tidak Berhasil');
        }
        return redirect()->route('master.grade.index');
    }

    public function destroy($id){
        $grade = Grade::find($id);
        $grade->delete();
        Session::flash('success','Hapus Data Grade Anggota Berhasil');
        return redirect()->route('master.grade.index');
    }
}
