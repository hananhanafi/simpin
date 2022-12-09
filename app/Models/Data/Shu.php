<?php

namespace App\Models\Data;

use App\Models\Data\ShuDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shu extends Model
{
    use SoftDeletes;

    protected $table = 'shu';

    function detail()
    {
        return $this->hasMany(ShuDetail::class, 'shu_id');
    }
}
