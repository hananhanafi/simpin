<?php

namespace App\Models\Data;

use App\Models\Data\Pinjaman;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PinjamanDetail extends Model
{
    use SoftDeletes;

    protected $table = 'pembiayaan_detail';

    function pinjaman()
    {
        return $this->belongsTo(Pinjaman::class, 'tabungan_id');
    }
}
