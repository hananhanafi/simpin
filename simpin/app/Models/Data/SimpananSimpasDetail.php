<?php

namespace App\Models\Data;

use App\Models\Data\Simpanan;
use App\Models\Master\Produk;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SimpananSimpasDetail extends Model
{
    use SoftDeletes;

    protected $table = 'simpanan_simpas_detail';

    function produk(){
        return $this->belongsTo(Produk::class,'produk_id');
    }
    function simpanan(){
        return $this->belongsTo(Simpanan::class,'simpanan_id');
    }
}
