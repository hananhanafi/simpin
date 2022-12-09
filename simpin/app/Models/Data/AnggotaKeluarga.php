<?php

namespace App\Models\Data;

use App\Data\Master\Anggota;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnggotaKeluarga extends Model
{
    use SoftDeletes;

    protected $table = 't_anggota_keluarga';

    function anggota(){
        return $this->hasMany(Anggota::class,'no_anggota','no_anggota');
    }
}
