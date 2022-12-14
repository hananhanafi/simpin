<?php

namespace App\Models\Data;

use App\Models\Data\Shu;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShuDetail extends Model
{
    use SoftDeletes;
    protected $table = 'shu_detail';

    function shu(){
        return $this->belongsTo(Shu::class,'shu_id');
    }
}
