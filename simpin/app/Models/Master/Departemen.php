<?php

namespace App\Models\Master;

// use App\Models\Master\Departemen;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departemen extends Model
{
    use SoftDeletes;

    protected $table = 'p_departemen';

    public function parent()
    {
        return $this->belongsTo(Departemen::class, 'parent_id');
    }

    public function sub_departemen()
    {
        return $this->hasMany(Departemen::class, 'parent_id');
    }
}
