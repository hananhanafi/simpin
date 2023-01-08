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
        $produkTypeCheck = ProdukKategori::where('kode','=',$request->kode)->whereNull('deleted_at')->get();
        if(count($produkTypeCheck)>0){
            Session::flash('fail','Kode ' . $request->kode . ' Sudah Ada. Silahkan Gunakan Kode Produk Lain');
            return redirect()->back()->withInput();
        }
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
            if (config('app.env') == 'local')
                Session::flash('fail', $ex->getMessage() . ', Baris :' . $ex->getLine());
            else{
                Session::flash('fail', 'Data Produk Type Tidak Berhasil Di Simpan');
            }
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
            $message = $ex->getMessage();
            if(strpos( $message, "Duplicate entry") !== false){
                Session::flash('fail','Kode Produk Type Harus Unik');
                return redirect()->back();
            }else {
                Session::flash('fail','Update Data Produk Type Tidak Berhasil Di Simpan');
            }
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
            DB::beginTransaction();
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
                if($index>2)
                {
                    if($value[0]!='')
                    {
                        $produkTypeCheck = ProdukKategori::where('kode','=',$value[1])->whereNull('deleted_at')->get();
                        if(count($produkTypeCheck)>0){
                            ProdukKategori::where('kode','=',$value[1])->whereNull('deleted_at')->update([
                                'nama' => $value[2],
                                'tipe_produk' => $value[3],
                            ]);
                            $count++;
                        }
                        else {
                            $newProdukType = new ProdukKategori();
                            $newProdukType->kode               = $value[1];
                            $newProdukType->nama               = $value[2];
                            $newProdukType->tipe_produk        = $value[3];
                            $newProdukType->created_at         = date('Y-m-d H:i:s');
                            $newProdukType->updated_at         = date('Y-m-d H:i:s');
                            $newProdukType->save();
                            $count++;
                        };
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
            // if (config('app.env') == 'local') {
            //     Session::flash('fail',$ex->getMessage());
            // } else {
            //     Session::flash('fail','Import Data Tipe Produk Tidak Berhasil');
            // }
            $message = $ex->getMessage();
            if(strpos( $message, "Duplicate entry") !== false){
                Session::flash('fail','Import Data Tipe Produk Tidak Berhasil, Kode Harus Unik');
                return redirect()->back();
            }else {
                Session::flash('fail','Import Data Tipe Produk Tidak Berhasil');
            }
            return redirect()->route('master.produk-kategori.index');
        }
    }
}
