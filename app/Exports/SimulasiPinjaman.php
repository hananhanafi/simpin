<?php

namespace App\Exports;

use App\Models\Master\Produk;
use App\Helpers\FunctionHelper;
use App\Helpers\FinancialHelper;
use App\Models\Data\Anggota;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SimulasiPinjaman implements FromView, WithTitle, ShouldAutoSize
{
    use Exportable;

    protected $produk_id;
    protected $bunga;
    protected $bulan;
    protected $saldo;
    protected $bungaEfektif;
    protected $no_anggota;

    function __construct(string $produk_id, string $bunga, string $bulan, string $saldo, string $bungaEfektif, string $no_anggota = null, string $jml_pengajuan_baru = null, string $masa = null, string $angsuran = null)
    {
        $this->produk_id = $produk_id;
        $this->bunga = $bunga;
        $this->bulan = $bulan;
        $this->saldo = $saldo;
        $this->bungaEfektif = $bungaEfektif;
        $this->no_anggota = $no_anggota;
    }

    public function view(): View
    {
        $saldo = str_replace('.', '', $this->saldo);

        $startBulan = date('n');
        $startTahun = date('Y');
        $rangeBulan = FunctionHelper::rangeBulan($startBulan, $startTahun, $this->bulan);
        $produk = Produk::find($this->produk_id);
        $saldo = ($saldo == null ? 0 : $saldo);
        $bulan = ($this->bulan == null ? 1 : $this->bulan);
        $rangeBulan = FunctionHelper::rangeBulan($startBulan, $startTahun, ($bulan + 1));
        $simpas     = FunctionHelper::hitungSimpas($bulan, $this->bungaEfektif, $this->bunga, $saldo);
        $financial = new FinancialHelper;

        if ($this->no_anggota != null) {
            $anggota = Anggota::where('no_anggota', $this->no_anggota)->firstOrFail();
            return view('pages.data.pinjaman.unduh-pengajuan-xls')
                ->with('bulan', $bulan)
                ->with('financial', $financial)
                ->with('saldo', $saldo)
                ->with('anggota', $anggota)
                ->with('produk', $produk)
                ->with('simpas', $simpas)
                ->with('rangeBulan', $rangeBulan)
                ->with('bunga_efektif', $this->bungaEfektif)
                ->with('bunga', $this->bunga);
        } else {
            return view('pages.data.pinjaman.unduh-xls')
                ->with('bulan', $bulan)
                ->with('financial', $financial)
                ->with('saldo', $saldo)
                ->with('produk', $produk)
                ->with('simpas', $simpas)
                ->with('rangeBulan', $rangeBulan)
                ->with('bunga_efektif', $this->bungaEfektif)
                ->with('bunga', $this->bunga);
        }
    }

    public function title(): string
    {
        return 'Simulasi Pinjaman';
    }
}
