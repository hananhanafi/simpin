<?php

namespace App\Models\Data;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PembiayaanTransaksi extends Model
{
    //
    use SoftDeletes;

    protected $table = 't_pembiayaan_transaksi';

    // function detail()
    // {
    //     return $this->hasMany(ShuDetail::class, 'shu_id');
    // }
}
