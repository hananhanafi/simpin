<?php

namespace App\Models\Data;

use App\Data\Master\Anggota;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnggotaAspresiasi extends Model
{
    use SoftDeletes;

    protected $table = 't_anggota_apresiasi';

    function anggota(){
        return $this->hasMany(Anggota::class,'no_anggota','no_anggota');
    }
}
