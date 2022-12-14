<?php

namespace App\Http\Controllers\Data;

use App\Exports\PlafonPinjaman;
use Exception;
use Illuminate\Support\Str;
use App\Models\Data\Anggota;
use Illuminate\Http\Request;
use App\Models\Data\Pinjaman;
use App\Models\Data\Simpanan;
use App\Models\Data\Pencairan;
use App\Models\Data\Pelunasan;
use App\Models\Master\Produk;
use App\Helpers\FunctionHelper;
use App\Helpers\FinancialHelper;
use App\Exports\SimulasiPinjaman;
use Illuminate\Support\Facades\DB;
use App\Models\Data\PinjamanDetail;
use App\Http\Controllers\Controller;
use App\Models\Temp\Anggota as TempAnggota;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class HrdController extends Controller
{


    public function imporHRD()
    {

        return view('pages.data.hrd.impor');
    }
}
