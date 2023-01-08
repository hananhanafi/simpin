<?php

namespace App\Models\Data;

use App\Models\Data\Anggota;
use App\Models\Data\PinjamanDetail;
use App\Models\Master\Produk;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pinjaman extends Model
{
    use SoftDeletes;

    protected $table = 't_pembiayaan';

    function detail()
    {
        return $this->hasMany(PinjamanDetail::class, 'tabungan_id');
    }

    function anggota()
    {
        return $this->belongsTo(Anggota::class, 'no_anggota', 'no_anggota');
    }

    function jenispinjaman()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'id');
    }

    function getNamaProduksAttribute()
    {
        if (isset($this->jenispinjaman->nama_produk))
            return $this->jenispinjaman->nama_produk;
        else
            return '-';
    }

    function getAngsuranAttribute()
    {
        if (isset($this->detail->total_angsuran))
            return $this->detail->total_angsuran;
        else
            return '-';
    }

    function getXStatusAttribute()
    {
        $xstatus = '';
        if ($this->status_rekening == "0") {
            $xstatus = "<span class='btn btn-sm btn-rounded btn-secondary'>Draft</span>";
        } elseif ($this->status_rekening == "1") {
            $xstatus = "<span class='btn btn-sm btn-rounded btn-success'>Aktif</span>";
        } elseif ($this->status_rekening == "2") {
            $xstatus = "<span class='btn btn-sm btn-rounded btn-info'>Pencairan</span>";
        } elseif ($this->status_rekening == "3") {
            $xstatus = "<span class='btn btn-sm btn-rounded btn-success'>Pelunasan</span>";
        } elseif ($this->status_rekening == "4") {
            $xstatus = '<span class="badge font-size-13 bg-warning">Pengajuan Penutupan</span>';
        } elseif ($this->status_rekening == "5") {
            $xstatus = "<span class='btn btn-sm btn-rounded btn-danger'>Tidak Aktif</span>";
        }
        return $xstatus;
    }
}
