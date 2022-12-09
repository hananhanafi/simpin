<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SumberDana extends Model
{
    use SoftDeletes;

    protected $table = 'p_sumberdana';
}
