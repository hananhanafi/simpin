<?php

namespace App\Models\Data;

use App\Models\Master\Produk;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pembiayaan extends Model
{
    use SoftDeletes;
    protected $table = 't_pembiayaan';
    protected $appends = ['jenis_pembiayaan'];
    function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    function getJenisSimpananAttribute()
    {
        if (isset($this->produk->nama_produk))
            return $this->produk->nama_produk;
        else
            return  '-';
    }

    function getStatusAttribute()
    {
        $xstatus = '';
        if ($this->status_rekening == "0") {
            $xstatus = "<span class='badge badge-warning'>Pengajuan</span>";
        } elseif ($this->status_rekening == "1") {
            $xstatus = "<span class='badge badge-success'>Aktif</span>";
        } elseif ($this->status_rekening == "2") {
            $xstatus = "<span class='badge badge-info'>Pencairan</span>";
        } elseif ($this->status_rekening == "3") {
            $xstatus = "<span class='badge badge-primary'>Pelusanan</span>";
        } elseif ($this->status_rekening == "4") {
            $xstatus = "<span class='badge badge-secondary'>Terminasi</span>";
        } elseif ($this->status_rekening == "5") {
            $xstatus = "<span class='badge badge-danger'>Tidak Aktif</span>";
        }
        return $xstatus;
    }
}
