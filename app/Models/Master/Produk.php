<?php

namespace App\Models\Master;

use App\Models\Master\ProdukMargin;
use App\Models\Master\ProdukKategori;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produk extends Model
{
    use SoftDeletes;

    protected $table = 'p_produk';
    protected $appends  = ['tipe_kode'];
    function tipePr()
    {
        return $this->belongsTo(ProdukKategori::class, 'tipe_produk', 'kode');
    }

    function margin()
    {
        return $this->hasMany(ProdukMargin::class, 'produk_id');
    }


    function getTipeAttribute()
    {
        if (isset($this->tipePr->nama))
            return $this->tipePr->nama;
        else
            return '<i class="text-muted">not-set</i>';
    }

    function getTipeKodeAttribute()
    {
        if (isset($this->tipePr->kode))
            return $this->tipePr->kode;
        else
            return '';
    }

    function getJenisAttribute()
    {
        if (isset($this->tipePr->tipe_produk)) {
            if ($this->tipePr->tipe_produk == 1)
                return '<span class="badge font-size-13 bg-success">Simpanan</span>';
            else
                return '<span class="badge font-size-13 bg-info">Pinjaman</span>';
        } else
            return '<i class="text-muted">not-set</i>';
    }

    function getJenisLabelAttribute()
    {
        if (isset($this->tipePr->tipe_produk)) {
            if ($this->tipePr->tipe_produk == 1)
                return 'Simpanan';
            else
                return 'Pinjaman';
        } else
            return '-';
    }
    
    function getTipeJenisAttribute()
    {
        if (isset($this->tipePr->tipe_produk)) {
            return $this->tipePr->tipe_produk;
        } else
            return 0;
    }
    function getTipeMarginsAttribute()
    {
        if ($this->tipe_margin == 2)
            return '<span class="badge font-size-13 bg-success">Annuity</span>';
        else
            return '<span class="badge font-size-13 bg-info">Flat</span>';
    }

    function getStatusProduksAttribute()
    {
        if ($this->status_produk == 0)
            return '<span class="badge font-size-13 bg-secondary">Draft</span>';
        elseif ($this->status_produk == 1)
            return '<span class="badge font-size-13 bg-success">Aktif</span>';
        else
            return '<span class="badge font-size-13 bg-danger">Tidak Aktif</span>';
    }
}
