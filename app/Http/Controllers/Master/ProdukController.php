<?php

namespace App\Http\Controllers\Master;

use Exception;
use App\Imports\ImportExcel;
use Illuminate\Http\Request;
use App\Models\Master\Produk;
use Illuminate\Support\Facades\DB;
use App\Models\Master\ProdukMargin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Master\ProdukKategori;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Master\RequestProduk;

class ProdukController extends Controller
{
    public function index()
    {

        return view('pages.master.produk.index');
    }

    public function create()
    {
        $kategori = ProdukKategori::orderBy('kode')->get();
        return view('pages.master.produk.create')
            ->with('kategori', $kategori);
    }

    public function store(RequestProduk $request)
    {
        // return $request;
        try {
            DB::beginTransaction();

            list($kodeTipe, $tipeProduk) = explode('-', $request->tipe_produk);

            $produk = new Produk;
            $produk->kode                = $request->kode;
            $produk->nama_produk        = $request->nama_produk;
            $produk->tipe_produk        = $kodeTipe;
            $produk->tipe_margin        = $request->tipe_margin == '' ? '2' : $request->tipe_margin;
            $produk->tipe_akad            = 0;
            $produk->nilai_margin        = 0;
            $produk->tenor                = 0;
            $produk->admin_fee            = str_replace('.', '', $request->admin_fee);

            if ($request->asuransis != '')
                $produk->asuransi            = str_replace('.', '', $request->asuransis);
            else
                $produk->asuransi            = 0;


            $produk->minimal_saldo        = 0;
            $produk->status_produk        = 0;
            $produk->kode_potongan_hrd    = '-';
            $produk->created_date        = date('Y-m-d H:i:s');
            $produk->created_by         = Auth::user()->id;
            $produk->approv_date        = date('Y-m-d H:i:s');
            $produk->approv_by          = 0;
            $produk->approv_note        = '-';
            $produk->updated_date        = date('Y-m-d H:i:s');
            $produk->updated_by         = 0;
            $produk->delete_date        = date('Y-m-d H:i:s');
            $produk->delete_by          = 0;
            $produk->save();

            $jangka_waktu   = $request->jangka_waktu;
            $margin         = $request->margin;
            $margin_flat    = $request->margin_flat;
            $asuransi       = $request->asuransi;


            // if($tipeProduk == 2){

            $margins = ProdukMargin::where('produk_id', $produk->id)->pluck('produk_id')->toArray();

            if (count($margins) != 0) {
                ProdukMargin::whereIn('produk_id', $margins)->forceDelete();
            }

            foreach ($jangka_waktu as $idx => $item) {
                if ($item != null) {
                    $insertMargin = new ProdukMargin;
                    $insertMargin->produk_id    = $produk->id;
                    $insertMargin->jangka_waktu    = $item;
                    $insertMargin->margin        = $margin[$idx];
                    $insertMargin->margin_flat    = isset($margin_flat[$idx]) ? $margin_flat[$idx] : 0;
                    $insertMargin->asuransi        = $asuransi[$idx];
                    $insertMargin->save();
                }
            }
            // }

            DB::commit();
            Session::flash('success', 'Data Produk Berhasil Di Simpan');
        } catch (Exception $ex) {
            DB::rollback();
            // if (config('app.env') == 'local')
            //     Session::flash('fail', $ex->getMessage() . ', Baris :' . $ex->getLine());
            // else{
            //     Session::flash('fail', 'Data Produk Tidak Berhasil Di Simpan');
            // }
            $message = $ex->getMessage();
            if (strpos($message, "Duplicate entry") !== false) {
                Session::flash('fail', 'Kode Produk Harus Unik');
                return redirect()->back();
            } else {
                Session::flash('fail', 'Data Produk Tidak Berhasil Di Simpan');
            }
        }
        return redirect()->route('master.produk.index');
    }

    public function edit($id)
    {
        $produk = Produk::where('id', $id)
            ->with('margin')
            ->first();
        $kategori = ProdukKategori::orderBy('kode')->get();
        return view('pages.master.produk.edit')
            ->with('id', $id)
            ->with('kategori', $kategori)
            ->with('produk', $produk);
    }

    public function update(RequestProduk $request, $id)
    {
        // return $request;
        try {
            DB::beginTransaction();

            list($kodeTipe, $tipeProduk) = explode('-', $request->tipe_produk);

            $produk = Produk::find($id);
            $produk->kode                = $request->kode;
            $produk->nama_produk        = $request->nama_produk;
            $produk->tipe_produk        = $kodeTipe;
            $produk->tipe_margin        = $request->tipe_margin == '' ? '2' : $request->tipe_margin;
            $produk->tipe_akad            = 0;
            $produk->tenor                = 0;
            $produk->nilai_margin        = 0;
            $produk->admin_fee            = str_replace('.', '', $request->admin_fee);

            if ($request->asuransis != '')
                $produk->asuransi            = str_replace('.', '', $request->asuransis);
            else
                $produk->asuransi            = 0;

            $produk->minimal_saldo        = 0;
            // $produk->status_produk        = 0;
            $produk->kode_potongan_hrd    = '-';
            $produk->created_date        = date('Y-m-d H:i:s');
            $produk->created_by         = 0;
            $produk->approv_date        = date('Y-m-d H:i:s');
            $produk->approv_by          = 0;
            $produk->approv_note        = '-';
            $produk->updated_date        = date('Y-m-d H:i:s');
            $produk->updated_by         = Auth::user()->id;
            $produk->delete_date        = date('Y-m-d H:i:s');
            $produk->delete_by          = 0;
            $produk->save();

            $jangka_waktu   = $request->jangka_waktu;
            $margin         = $request->margin;
            $margin_flat    = $request->margin_flat;
            $asuransi       = $request->asuransi;

            // if($tipeProduk == 2){

            $margins = ProdukMargin::where('produk_id', $produk->id)->pluck('produk_id')->toArray();

            if (count($margins) != 0) {
                ProdukMargin::whereIn('produk_id', $margins)->forceDelete();
            }

            foreach ($jangka_waktu as $idx => $item) {
                if ($item != null) {
                    $insertMargin = new ProdukMargin;
                    $insertMargin->produk_id    = $produk->id;
                    $insertMargin->jangka_waktu    = $item;
                    $insertMargin->margin        = $margin[$idx];
                    $insertMargin->margin_flat    = isset($margin_flat[$idx]) ? $margin_flat[$idx] : 0;
                    $insertMargin->asuransi        = $asuransi[$idx];
                    $insertMargin->save();
                }
            }
            // }

            DB::commit();
            Session::flash('success', 'Data Produk Berhasil Di Update');
        } catch (Exception $ex) {
            // if (config('app.env') == 'local')
            //     Session::flash('fail', $ex->getMessage() . ', Baris :' . $ex->getLine());
            // else{
            //     Session::flash('fail', 'Data Produk Tidak Berhasil Di Update');
            // }
            $message = $ex->getMessage();
            if (strpos($message, "Duplicate entry") !== false) {
                Session::flash('fail', 'Kode Produk Harus Unik');
                return redirect()->back();
            } else {
                Session::flash('fail', 'Data Produk Tidak Berhasil Di Update');
            }
        }
        return redirect()->route('master.produk.index');
    }

    public function show($id)
    {
        $produk = Produk::where('id', $id)
            ->with('margin')
            ->first();
        $kategori = ProdukKategori::orderBy('kode')->get();
        return view('pages.master.produk.show')
            ->with('id', $id)
            ->with('kategori', $kategori)
            ->with('produk', $produk);
    }

    public function destroy($id)
    {
        $produk = Produk::find($id);
        $produk->delete_date    = date('Y-m-d H:i:s');
        $produk->delete_by      = Auth::user()->id;
        $produk->save();

        if ($produk) {
            $produk->delete();
            Session::flash('success', 'Hapus Data Produk Berhasil');
        } else {
            Session::flash('fail', 'Hapus Data Produk Tidak Berhasil');
        }
        return redirect()->route('master.produk.index');
    }

    public function importXlsProses(Request $request)
    {

        try {
            $file = $request->file('file');
            $nama_file = time() . '_' . $file->getClientOriginalName();
            // $file->storeAs('public/donatur', $nama_file);
            $file->move('file', $nama_file);
            $files = public_path('file/' . $nama_file);
            $array = Excel::toArray(new ImportExcel, $files);

            $count = $already = 0;
            $donatur = Produk::pluck('kode')->toArray();

            foreach ($array[0] as $index => $value) {
                if ($index != 0) {
                    if ($value[0] != '') {
                        if (!in_array($value[1], $donatur)) {

                            $newProduk = new Produk();
                            $newProduk->kode                = $value[1];
                            $newProduk->nama_produk         = $value[2];
                            $newProduk->tipe_produk         = $value[3];
                            $newProduk->tipe_margin         = $value[4];
                            $newProduk->tipe_akad           = $value[5];
                            $newProduk->nilai_margin        = $value[6] == '' ? 0 : $value[6];
                            $newProduk->tenor               = $value[7] == '' ? 0 : $value[7];
                            $newProduk->admin_fee           = $value[8] == '' ? 0 : $value[8];
                            $newProduk->asuransi            = 0;
                            $newProduk->minimal_saldo        = $value[9] == '' ? 0 : $value[9];
                            $newProduk->status_produk        = $value[10];
                            $newProduk->kode_potongan_hrd    = $value[11] == '' ? '-' : $value[11];
                            $newProduk->created_date        = date('Y-m-d H:i:s');
                            $newProduk->created_by            = 0;
                            $newProduk->approv_date            = date('Y-m-d H:i:s');
                            $newProduk->approv_by            = 0;
                            $newProduk->approv_note            = 0;
                            $newProduk->updated_date        = date('Y-m-d H:i:s');
                            $newProduk->updated_by            = 0;
                            $newProduk->delete_date            = date('Y-m-d H:i:s');
                            $newProduk->delete_by            = 0;
                            $newProduk->created_at          = date('Y-m-d H:i:s');
                            $newProduk->updated_at          = date('Y-m-d H:i:s');
                            $newProduk->save();
                            $count++;
                        }
                    }
                }
            }

            DB::commit();
            if ($count == 0)
                Session::flash('fail', 'Import Data Produk Tidak Berhasil');
            else
                Session::flash('success', 'Import Data Produk Berhasil');

            return redirect()->route('master.produk.index');
        } catch (Exception $ex) {
            DB::rollback();
            if (config('app.env') == 'local') {
                Session::flash('fail', $ex->getMessage());
            } else {
                Session::flash('fail', 'Import Data Produk Tidak Berhasil');
            }
            return redirect()->route('master.produk.index');
        }
    }
}
