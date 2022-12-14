<?php

namespace App\Models\Data;

use App\Models\Master\Produk;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SimpananSsbDetail extends Model
{
    use SoftDeletes;

    protected $table = 'simpanan_ssb_detail';

    function produk(){
        return $this->belongsTo(Produk::class,'produk_id');
    }
    function simpanan(){
        return $this->belongsTo(Simpanan::class,'simpanan_id');
    }

    function scopeRollover($query){
        return $query->where('jenis','rollover');
    }
    function scopeDibayar($query){
        return $query->where('jenis','dibayar');
    }
}
