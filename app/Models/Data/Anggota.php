<?php

namespace App\Models\Data;

use App\Models\Master\Grade;
use App\Models\Data\Simpanan;
use App\Models\Data\Pembiayaan;
use App\Models\Master\Departemen;
use App\Models\Master\ProfitCenter;
use App\Models\Data\AnggotaKeluarga;
use App\Models\Data\AnggotaAspresiasi;
use App\Models\Data\TempAnggota;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Anggota extends Model
{
    use SoftDeletes;

    protected $table = 't_anggota';
    protected $appends = ['age'];

    function apresiasi()
    {
        return $this->hasMany(AnggotaAspresiasi::class, 'no_anggota', 'no_anggota');
    }

    function departemen()
    {
        return $this->belongsTo(Departemen::class, 'departement_id');
    }

    function grades()
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }

    function profits()
    {
        return $this->belongsTo(ProfitCenter::class, 'profit_id');
    }

    function keluarga()
    {
        return $this->hasMany(AnggotaKeluarga::class, 'no_anggota', 'no_anggota');
    }

    function simpananAnggota()
    {
        return $this->hasMany(Simpanan::class, 'no_anggota', 'no_anggota');
    }

    function pembiayaanAnggota()
    {
        return $this->hasMany(Pembiayaan::class, 'no_anggota', 'no_anggota');
    }

    function shuDetail()
    {
        return $this->belongsTo(TempAnggota::class, 'no_anggota', 'no_anggota');
    }

    function getAgeAttribute()
    {
        return Carbon::parse($this->attributes['tgl_lahir'])->age;
    }

    function getGradeNamaAttribute()
    {
        if (isset($this->grades->grade_name))
            return $this->grades->grade_name;
        else
            return '-';
    }
    function getProfitNamaAttribute()
    {
        if (isset($this->profits->nama))
            return $this->profits->nama;
        else
            return '-';
    }

    function getDepartemenNamaAttribute()
    {
        if (isset($this->departemen->departemen))
            return $this->departemen->departemen;
        else
            return '-';
    }

    function getStatusAttribute()
    {
        if ($this->status_anggota == 0)
            return '<span class="badge font-size-13 bg-secondary">Pengajuan Aktivasi</span>';
        elseif ($this->status_anggota == 1)
            return '<span class="badge font-size-13 bg-success">Aktif</span>';
        elseif ($this->status_anggota == 4)
            return '<span class="badge font-size-13 bg-warning">Pengajuan Terminasi</span>';
        else
            return '<span class="badge font-size-13 bg-danger">Tidak Aktif</span>';
    }

    function setDepartementIdAttribute($value)
    {
        $this->attributes['departement_id'] = $value;
        $get = Departemen::find($value);
        if ($get)
            $this->attributes['departement'] = $get->departemen;
    }

    function setGradeIdAttribute($value)
    {
        $this->attributes['grade_id'] = $value;
        $get = Grade::find($value);
        if ($get)
            $this->attributes['grade'] = $this->grades->grade_name;
    }

    function setProfitIdAttribute($value)
    {
        $this->attributes['profit_id'] = $value;
        $get = ProfitCenter::find($value);
        if ($get)
            $this->attributes['profit'] = $this->profits->nama;
    }
}
