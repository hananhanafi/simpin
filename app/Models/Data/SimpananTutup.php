<?php

namespace App\Models\Data;

use App\Models\Data\Simpanan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SimpananTutup extends Model
{
    use SoftDeletes;

    protected $table = 'simpanan_tutup';

    function simpanan(){
        return $this->belongsTo(Simpanan::class,'simpanan_id');
    }
}
