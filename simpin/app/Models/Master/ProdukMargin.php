<?php

namespace App\Models\Master;

use App\Models\Master\Produk;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProdukMargin extends Model
{
    use SoftDeletes;

    protected $table = 'p_produk_margin';

    function produk(){
        return $this->belongsTo(Produk::class,'produk_id');
    }
}
