<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfitCenter extends Model
{
    use SoftDeletes;

    protected $table = 'p_profit_center';
}
