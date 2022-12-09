<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProdukKategori extends Model
{
    use SoftDeletes;

    protected $table = 'p_produk_tipe';

    public function scopeTipe($query, $value)
    {
        return $query->where('tipe_produk', $value);
    }

    function getTipeAttribute(){
        if($this->tipe_produk == 1)
            return '<span class="badge font-size-13 bg-primary">Simpanan</span>';
        elseif($this->tipe_produk == 2)
            return '<span class="badge font-size-13 bg-success">Pinjaman</span>';
    }
}
