<?php

namespace App\Http\Controllers\Data;

use Exception;
use App\Models\Data\Shu;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Data\ShuDetail;
use Illuminate\Support\Facades\Session;

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

            DB::beginTransaction();

            $shu = new Shu;
            $shu->uuid          = Str::uuid();
            $shu->tahun         = $request->tahun;
            $shu->persen_anggota = str_replace(',', '.', str_replace('.', '', $request->shu_anggota_persen));
            $shu->persen_pengurus = str_replace(',', '.', str_replace('.', '', $request->shu_pengurus_persen));
            $shu->alokasi_shu    = str_replace(',', '.', str_replace('.', '', $request->alokasi_shu));
            $shu->shu_pengurus    = str_replace(',', '.', str_replace('.', '', $request->shu_pengurus));
            $shu->shu_anggota    = str_replace(',', '.', str_replace('.', '', $request->shu_anggota));
            $shu->status        = 0;
            $shu->save();

            $shuId = $shu->id;
            $pengurus_persen = $request->ppengurus_persen;

            foreach ($request->pengurus as $idx => $item) {

                $shuDetail = new ShuDetail();
                $shuDetail->shu_id          = $shuId;
                $shuDetail->uuid              = Str::uuid();
                $shuDetail->tahun             = $request->tahun;
                $shuDetail->keterangan      = $idx;
                $shuDetail->nilai_shu       = str_replace(',', '.', str_replace('.', '', $item));
                $shuDetail->persen            = $pengurus_persen[$idx];
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
}
