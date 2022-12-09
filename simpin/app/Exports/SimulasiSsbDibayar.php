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

class SimulasiSsbDibayar implements FromView, WithTitle, ShouldAutoSize
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

    public function view(): View
    {
        $saldo = str_replace('.','',$this->saldo);

        $startBulan = date('n');
        $startTahun = date('Y');
        $rangeBulan = FunctionHelper::rangeBulan($startBulan, $startTahun, $this->bulan);
        $produk = Produk::find($this->produk_id);
        $saldo = ($saldo == null ? 0 : $saldo);
        $bulan = ($this->bulan == null ? 1 : $this->bulan);
        $rangeBulan = FunctionHelper::rangeBulan($startBulan, $startTahun, ($bulan+1));
       
        $financial = new FinancialHelper;

        return view('pages.data.simpanan.xls.simulasi-ssb-dibayar')
                        ->with('bulan', $bulan)
                        ->with('saldo', $saldo)
                        ->with('produk', $produk)
                        ->with('rangeBulan', $rangeBulan)
                        ->with('bunga_efektif', $this->bungaEfektif)
                        ->with('bunga', $this->bunga);
    }

    public function title(): string
    {
        return 'Simulai Simpanan SSB Dibayar';
    }
}