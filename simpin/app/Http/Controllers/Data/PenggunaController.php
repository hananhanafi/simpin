<?php

namespace App\Http\Controllers\Data;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PenggunaController extends Controller
{
    public function index(){
        return view('pages.data.pengguna.index');    
    }
    public function create(){
        return view('pages.data.pengguna.create');    
    }
    public function store(Request $request){
        try {
            DB::beginTransaction();

            $profil = new User();
            $profil->nama           = $request->nama;
            $profil->nik            = $request->nik;
            $profil->keterangan     = $request->keterangan;
            $profil->email          = $request->email;
            $profil->telepon        = $request->telepon;
            $profil->username       = $request->username;
            $profil->passwd         = bcrypt($request->password);
            $profil->group_akses	= $request->group_akses;
            $profil->status_akses	= $request->status_akses;
            $profil->reg_date       = date('Y-m-d H:i:s');
            $profil->save();

            DB::commit();
            Session::flash('success','Data Profil Pengguna Baru Berhasil Disimpan');
            return redirect()->route('data.pengguna.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            if(config('app.env') == 'local')
                Session::flash('fail',$th->getMessage().', Baris: '.$th->getLine());
            else
                Session::flash('fail','Simpan Data Profil Baru Pengguna Tidak Berhasil');

            return redirect()->route('data.pengguna.create');
        }
    }
    public function edit($uuid){
        $id     = Auth::user()->id;
        $user   = User::find($id);
        return view('pages.data.pengguna.edit')
                ->with('uuid', $uuid)
                ->with('user', $user);
    }

    public function update(Request $request, $uuid){
        try {
            DB::beginTransaction();

            $profil = User::where('id',Auth::user()->id)->first();
            $profil->nama           = $request->nama;
            $profil->nik            = $request->nik;
            $profil->keterangan     = $request->keterangan;
            $profil->email          = $request->email;
            $profil->telepon        = $request->telepon;
            $profil->username       = $request->username;

            if($request->password != '')
                $profil->passwd         = bcrypt($request->password);

            if($uuid != Auth::user()->id){
                $profil->group_akses    = $request->group_akses;
                $profil->status_akses   = $request->status_akses;
            }
            $profil->save();

            DB::commit();
            Session::flash('success','Data Profil Pengguna Berhasil Disimpan');
            return redirect()->route('data.pengguna.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            if(config('app.env') == 'local')
                Session::flash('fail',$th->getMessage().', Baris: '.$th->getLine());
            else
                Session::flash('fail','Simpan Data Profil Pengguna Tidak Berhasil');

            return redirect()->route('data.pengguna.edit', $uuid);
        }
    }

    public function destroy($id){
        $anggota    = User::find($id);
        $anggota->delete();
        Session::flash('success','Hapus Data Pengguna Berhasil');
        return redirect()->route('data.pengguna.index');
    }
}
