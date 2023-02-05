<?php

namespace App\Models\Data;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SimpananTransaksi extends Model
{
    use SoftDeletes;

    protected $table = 't_simpanan_transaksi';
    //
}
