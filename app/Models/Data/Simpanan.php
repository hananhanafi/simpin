<?php

namespace App\Models\Data;

use App\Models\Master\Produk;
use App\Models\Data\SimpananSsbDetail;
use Illuminate\Database\Eloquent\Model;
use App\Models\Data\SimpananSimpasDetail;
use Illuminate\Database\Eloquent\SoftDeletes;

class Simpanan extends Model
{
    use SoftDeletes;
    protected $table = 't_simpanan';
    protected $appends = ['jenis_simpanan'];

    function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    function detail()
    {
        return $this->hasMany(SimpananSsbDetail::class, 'simpanan_id', 'id');
    }

    function detailsimpas()
    {
        return $this->hasMany(SimpananSimpasDetail::class, 'simpanan_id', 'id');
    }

    function anggota()
    {
        return $this->belongsTo(Anggota::class, 'no_anggota', 'no_anggota');
    }

    function scopeRollover($query)
    {
        return $query->whereHas('detail', function ($q) {
            $q->where('jenis', 'rollover');
        });
    }
    function scopeDibayar($query)
    {
        return $query->whereHas('detail', function ($q) {
            $q->where('jenis', 'dibayar');
        });
    }

    function getNamaAttribute()
    {
        if (isset($this->anggota->nama))
            return $this->anggota->nama;
        else
            return '';
    }

    function getJenisSimpananAttribute()
    {
        if (isset($this->produk->nama_produk))
            return $this->produk->nama_produk;
        else
            return  '-';
    }

    function getProdukSimpananAttribute()
    {
        if (isset($this->produk->tipe_kode))
            return $this->produk->tipe_kode;
        else
            return  '';
    }

    function getStatusAttribute()
    {
        $xstatus = '';
        if ($this->status_rekening == "0") {
            $xstatus = "<span class='btn btn-sm btn-rounded btn-secondary'>Draft</span>";
        } elseif ($this->status_rekening == "1") {
            $xstatus = "<span class='btn btn-sm btn-rounded btn-success'>Aktif</span>";
        } elseif ($this->status_rekening == "4") {
            $xstatus = '<span class="badge font-size-13 bg-warning">Pengajuan Penutupan</span>';
        } elseif ($this->status_rekening == "5") {
            $xstatus = "<span class='btn btn-sm btn-rounded btn-danger'>Tidak Aktif</span>";
        }
        return $xstatus;
    }
}
