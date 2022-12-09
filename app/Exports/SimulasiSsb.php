<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SimulasiSsb implements WithMultipleSheets
{
    use Exportable;

    protected $produk_id;
    protected $bunga;
    protected $bulan;
    protected $saldo;
    protected $bungaEfektif;

    function __construct(string $produk_id, string $bunga, string $bulan, string $saldo, string $bungaEfektif) {
        $this->produk_id = $produk_id;
        $this->bunga = $bunga;
        $this->bulan = $bulan;
        $this->saldo = $saldo;
        $this->bungaEfektif = $bungaEfektif;
    }

    public function sheets(): array
    {

        $sheets[] = new SimulasiSsbDibayar($this->produk_id,$this->bunga,$this->bulan,$this->saldo,$this->bungaEfektif);
        $sheets[] = new SimulasiSsbRollover($this->produk_id,$this->bunga,$this->bulan,$this->saldo,$this->bungaEfektif);

        return $sheets;
    }
}
?>