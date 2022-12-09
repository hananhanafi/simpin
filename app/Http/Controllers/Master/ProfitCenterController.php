<?php

namespace App\Http\Controllers\Master;

use App\Models\Master\ProfitCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Master\RequestProfitCenter;

class ProfitCenterController extends Controller
{
    public function index(){
        return view('pages.master.profit.index');
    }
    public function create(){
        return view('pages.master.profit.create');
    }

    public function store(RequestProfitCenter $request){
        try{
            DB::beginTransaction();

            $profitCenter = new ProfitCenter;
            $profitCenter->kode         = $request->kode;
            $profitCenter->nama         = $request->nama;
            $profitCenter->desc         = $request->desc;
            $profitCenter->save();

            DB::commit();
            Session::flash('success','Tambah Data Profit Center Baru Berhasil');

        }catch(Exception $ex){
            DB::rollback();
            Session::flash('fail','Tambah Data Profit Center Baru Tidak Berhasil');
        }
        return redirect()->route('master.profit.index');
    }

    public function edit($id){
        $profit = ProfitCenter::find($id);
        return view('pages.master.profit.edit')
            ->with('profit',$profit)
            ->with('id',$id);
    }

    public function show($id){
        $profitCenter = ProfitCenter::where('id',$id)
                    ->first();
        return view('pages.master.profit.show')
                ->with('id', $id)
                ->with('profit', $profitCenter);
    }

    public function update(RequestProfitCenter $request,$id){
        try{
            DB::beginTransaction();

            $profitCenter = ProfitCenter::find($id);
            $profitCenter->kode         = $request->kode;
            $profitCenter->nama         = $request->nama;
            $profitCenter->desc         = $request->desc;
            $profitCenter->save();

            DB::commit();
            Session::flash('success','Update Data Profit Center Berhasil');

        }catch(Exception $ex){
            DB::rollback();
            Session::flash('fail','Update Data Profit Center Tidak Berhasil');
        }
        return redirect()->route('master.profit.index');
    }

    public function destroy($id){
        $profitCenter = ProfitCenter::find($id);
        $profitCenter->delete();
        Session::flash('success','Hapus Data ProfitCenter Berhasil');
        return redirect()->route('master.profit.index');
    }
}
