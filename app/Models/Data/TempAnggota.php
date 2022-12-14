<?php


namespace App\Models\Data;

use Illuminate\Database\Eloquent\Model;

class TempAnggota extends Model
{
    protected $table = 'temp_anggota';

    function anggota()
    {
        return $this->belongsTo(Anggota::class, 'no_anggota', 'no_anggota');
    }
}
