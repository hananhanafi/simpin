<?php

namespace App\Data;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PembiayaanDetail extends Model
{
    use SoftDeletes;
    protected $table = 'pembiayaan_detail';
}
