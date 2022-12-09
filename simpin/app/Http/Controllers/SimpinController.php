<?php

namespace App\Http\Controllers;

use File;
use Illuminate\Http\Request;
use App\Models\Master\Variabel;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class SimpinController extends Controller
{
    public function index(){
        $req = Variabel::get();
        $txt = array();
        if($req) foreach($req as $val) {
            $txt[$val->variables_id] = $val->variables_value;
        }
        $npwp = "<a href='".url("download/$txt[2]")."' target='_blank'>[Download NPWP]</a>";
        $adrt = "<a href='".url("download/$txt[3]")."' target='_blank'>[Download AD/ART]</a>";
        $akta = "<a href='".url("download/$txt[4]")."' target='_blank'>[Download Akta Pendirian]</a>";
        $tahu = "<a href='".url("download/$txt[5]")."' target='_blank'>[Download Laporan Tahunan]</a>";
        $orga = "<a href='".url("download/$txt[6]")."' target='_blank'>[Download Struktur Organisasi]</a>";

        $res = $txt[1];
        $res = str_replace(array("{npwp}", "{adart}", "{akta}", "{lap_tahunan}", "{organ}"),
                        array($npwp, $adrt, $akta, $tahu, $orga), $res);

        $obj = new \stdClass();
        $obj->origin  = $txt[1];
        $obj->npwp    = $txt[2];
        $obj->adart   = $txt[3];
        $obj->akta    = $txt[4];
        $obj->tahunan = $txt[5];
        $obj->organ   = $txt[6];
        $obj->parsed  = $res;

        $jam = date('H:i');
        if ($jam > '05:30' && $jam < '10:00') {
            $salam = 'Selamat Pagi, ';
        } elseif ($jam >= '10:00' && $jam < '15:00') {
            $salam = 'Selamat Siang, ';
        } elseif ($jam < '18:00') {
            $salam = 'Selamat Sore, ';
        } else {
            $salam = 'Selamat Malam, ';
        }
        return view('pages.home.index')
            ->with('obj', $obj)
            ->with('salam', $salam . Auth::user()->username);
    }
    public function edit()
    {
        $data = Variabel::get();
        $txt = array();
        foreach($data as $val) {
            $txt[$val->variables_id] = $val->variables_value;
        }
        return view('pages.home.setting')->with('data', $txt);
    }

    public function update(Request $request)
    {
        $update = Variabel::where('variables_id',1)->first();
        $update->variables_value = $request->text;
        $update->save();

        $data = Variabel::get();
        $txt = array();
        foreach($data as $val) {
            $txt[$val->variables_id] = $val->variables_value;
        }
        return redirect()
            ->back()
            ->with('data', $txt);
    }

    public function uploadfile (Request $request) {
		if ($request->hasFile('file')) {
            $tipe = $request->info;
            $update = Variabel::where('variables_id',$tipe)->first();

            if(!empty($update->variables_value)) {
                File::delete('download/'.$update->variables_value);
            }

            $file = $request->file('file');
            $path = public_path().'/download/';
            $filename = $file->getClientOriginalName();
            $file->move($path, $filename);

            $update->variables_value = $filename;
            $update->save();

            $data = Variabel::get();
            $txt = array();
            foreach($data as $val) {
                $txt[$val->variables_id] = $val->variables_value;
            }
            return redirect()
                ->back()
                ->with('data', $txt);
        }
    }
}
