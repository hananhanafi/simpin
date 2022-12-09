<?php

namespace App\Http\Controllers\Data;

use App\Models\Data\Shu;
use App\Models\Data\Anggota;
use Illuminate\Http\Request;
use App\Models\Data\Pinjaman;
use App\Models\Data\Simpanan;
use App\Models\Master\Produk;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PembiayaanController extends Controller
{
    public function pembukaan()
    {
        return view('pages.data.pembiayaan.pembukaan');
    }

    public function setoran()
    {
        return view('pages.data.pembiayaan.setoran');
    }

    public function mutasi()
    {
        return view('pages.data.pembiayaan.mutasi');
    }

    public function pelunasanAwal()
    {
        return view('pages.data.pembiayaan.pelunasan-awal');
    }
}
