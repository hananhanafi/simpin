<?php

namespace App\Http\Controllers\Master;

use Exception;
use App\Imports\ImportExcel;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Master\ProdukKategori;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Master\RequestProdukType;
use App\Models\Master\ProdukMargin;

class ProdukKategoriController extends Controller
{
    public function index(){

        return view('pages.master.produk-type.index');
    }
    public function create(){
        return view('pages.master.produk-type.create');
    }

    public function store(RequestProdukType $request){
        try{
            DB::beginTransaction();

            $produk = new ProdukKategori;
            $produk->kode	            = $request->kode;
            $produk->nama	            = $request->nama;
            $produk->tipe_produk	    = $request->tipe_produk;
            $produk->save();


            DB::commit();
            Session::flash('success','Data Produk Type Berhasil Di Simpan');
        } catch(Exception $ex){
            DB::rollback();
            Session::flash('fail','Data Produk Type Tidak Berhasil Di Simpan');
        }
        return redirect()->route('master.produk-kategori.index');
    }

    public function edit($id){
        $productType = ProdukKategori::find($id);
        return view('pages.master.produk-type.edit')
                ->with('productType', $productType)
                ->with('id',$id);
    }

    public function update(RequestProdukType $request,$id){
        try{
            DB::beginTransaction();

            $produk = ProdukKategori::find($id);
            $produk->kode	            = $request->kode;
            $produk->nama	            = $request->nama;
            $produk->tipe_produk	    = $request->tipe_produk;
            $produk->save();


            DB::commit();
            Session::flash('success','Update Data Produk Type Berhasil Di Simpan');
        } catch(Exception $ex){
            DB::rollback();
            Session::flash('fail','Update Data Produk Type Tidak Berhasil Di Simpan');
        }
        return redirect()->route('master.produk-kategori.index');
    }

    public function destroy($id){
        $productType = ProdukKategori::find($id);
        $productType->delete();
        Session::flash('success','Hapus Data Tipe Produk Berhasil');
        return redirect()->route('master.produk-kategori.index');
    }

    public function importXlsProses(Request $request){

        try{
            $file = $request->file('file');
            $nama_file = time().'_'.$file->getClientOriginalName();
            // $file->storeAs('public/donatur', $nama_file);
            $file->move('file',$nama_file);
            $files = public_path('file/'.$nama_file);
            $array = Excel::toArray(new ImportExcel, $files);

            $count = $already = 0;
            $donatur = ProdukKategori::pluck('kode')->toArray();

            foreach($array[0] as $index => $value)
            {
                if($index!=0)
                {
                    if($value[0]!='')
                    {
                        if(!in_array($value[1], $donatur)){
                            
                            $newDonatur = new ProdukKategori();
                            $newDonatur->kode               = $value[1];
                            $newDonatur->nama               = $value[2];
                            $newDonatur->tipe_produk        = $value[3];
                            $newDonatur->created_at         = date('Y-m-d H:i:s');
                            $newDonatur->updated_at         = date('Y-m-d H:i:s');
                            $newDonatur->save();
                            $count++;

                        }

                    }
                }
            }

            DB::commit();
            if($count == 0)
                Session::flash('fail','Import Data Tipe Produk Tidak Berhasil');
            else
                Session::flash('success','Import Data Tipe Produk Berhasil');

            return redirect()->route('master.produk-kategori.index');
        }
        catch(Exception $ex)
        {
            DB::rollback();
            if (config('app.env') == 'local') {
                Session::flash('fail',$ex->getMessage());
            } else {
                Session::flash('fail','Import Data Tipe Produk Tidak Berhasil');
            }
            return redirect()->route('master.produk-kategori.index');
        }
    }
}
