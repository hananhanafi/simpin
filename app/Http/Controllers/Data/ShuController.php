<?php

namespace App\Http\Controllers\Data;

use Exception;
use App\Models\Data\Shu;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Imports\ImportExcel;
use App\Models\Data\ShuDetail;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Mockery\Undefined;

class ShuController extends Controller
{
    public function index()
    {
        return view('pages.data.shu.index');
    }

    public function create(Request $request)
    {

        $thn = date('Y');
        if (isset($request->tahun)) {
            if ($request->tahun != '') {
                $thn = $request->thn;
            }
        }

        return view('pages.data.shu.create')
            ->with('thn', $thn)
            ->with('request', $request);
    }
    public function show($uuid)
    {

        $shu = Shu::where('uuid', $uuid)->with('detail')->first();

        return view('pages.data.shu.show')
            ->with('uuid', $uuid)
            ->with('shu', $shu);
    }

    public function store(Request $request)
    {
        try {

            // FILE UPLOAD
            $file = $request->file('file');
            $nama_file = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/shu', $nama_file);
            // $file->move('file/shu', $nama_file);
            $files = storage_path('app/public/shu/' . $nama_file);
            $array = Excel::toArray(new ImportExcel, $files);

            // $shuId = Shu::latest('deleted_at')->first();
            // if ($shuId == null) {
            //     $shuId = 1;
            // } else {
            //     $shuId = $shuId->id + 1;
            // }

            // dd($shuId);
            DB::beginTransaction();

            $arr = $array[0];

            $shu = new Shu;
            $shu->uuid          = Str::uuid();
            $shu->tahun         = $arr[0][1];
            $shu->alokasi_shu    = $arr[25][2];
            $shu->shu_pengurus    = $arr[31][2];
            $shu->persen_pengurus = ($arr[31][1] * 100);
            $shu->shu_anggota    = $arr[26][2];
            $shu->persen_anggota = ($arr[26][1] * 100);
            $shu->status        = 0;
            $shu->save();

            $arrDet = [$arr[2], $arr[3], $arr[5], $arr[6], $arr[7]];
            for ($i = 27; $i < 31; $i++) {
                array_push($arrDet, $arr[$i]);
            }
            // return $arrDet;

            foreach ($arrDet as $idx => $item) {
                $shuKet = $idx > 4 ? 'pengurus' : 'anggota';
                $persen = $item[4] == null ? $item[1] : $item[4];

                $shuDetail = new ShuDetail();
                $shuDetail->shu_id      = $shu->id;
                $shuDetail->uuid        = Str::uuid();
                $shuDetail->tahun       = $shu->tahun;
                $shuDetail->keterangan  = $item[0];

                $shuDetail->kategori    = $shuKet;
                $shuDetail->nilai_shu   = $item[5] == null ? $item[2] : $item[5];
                $shuDetail->persen      = $persen * 100;
                $shuDetail->save();
            }

            DB::commit();
            Session::flash('success', 'Simpan Data SHU Berhasil, Dan Menunggu Approval');
            return redirect()->route('data.shu.index');
        } catch (Exception $er) {
            DB::rollback();
            if (config('app.env') == 'local')
                Session::flash('fail', $er->getMessage() . ', Baris: ' . $er->getLine());
            else
                Session::flash('fail', 'Simpan Data SHU Baru Tidak Berhasil');

            return redirect()->route('data.shu.index');
        }
    }

    public function destroy($id)
    {
        $shu    = Shu::where('uuid', $id)->first();
        $shu->delete();
        Session::flash('success', 'Hapus Data SHU Berhasil');
        return redirect()->route('data.shu.index');
    }

    public function rincian_anggota()
    {
        return view('pages.data.shu.rincian-anggota.index');
    }
}
