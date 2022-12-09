<?php

namespace App\Exports;

use App\Models\Master\Produk;
use App\Helpers\FunctionHelper;
use App\Helpers\FinancialHelper;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SimulasiSimpas implements FromView, WithTitle, ShouldAutoSize
{
    use Exportable;

    protected $produk_id;
    protected $bunga;
    protected $bulan;
    protected $saldo;
    protected $bungaEfektif;

    function __construct(string $produk_id, string $bunga, string $bulan, string $saldo, string $bungaEfektif)
    {
        $this->produk_id = $produk_id;
        $this->bunga = $bunga;
        $this->bulan = $bulan;
        $this->saldo = $saldo;
        $this->bungaEfektif = $bungaEfektif;
    }

    public function view(): View
    {
        $saldo = str_replace('.', '', $this->saldo);
        $bulan = $this->bulan;
        $bunga = $this->bunga;
        $produk_id = $this->produk_id;
        $bunga_efektif = $this->bungaEfektif;

        $startBulan = date('n');
        $startTahun = date('Y');
        $rangeBulan = FunctionHelper::rangeBulan($startBulan, $startTahun, $bulan);

        // return $rangeBulan;
        $produk = Produk::find($produk_id);
        $saldo = ($this->saldo == null ? 0 : $saldo);
        $bulan = ($this->bulan == null ? 1 : $bulan);
        $rangeBulan = FunctionHelper::rangeBulan($startBulan, $startTahun, ($bulan + 1));
        $simpas     = FunctionHelper::hitungSimpas($bulan, $bunga_efektif, $bunga, $saldo);
        return view('pages.data.simpanan.xls.simulasi-simpas')
            ->with('bulan', $bulan)
            ->with('saldo', $saldo)
            ->with('produk', $produk)
            ->with('simpas', $simpas)
            ->with('rangeBulan', $rangeBulan)
            ->with('bunga_efektif', $bunga_efektif)
            ->with('bunga', $bunga);
    }

    public function title(): string
    {
        return 'Simulai SIMPAS';
    }
}
