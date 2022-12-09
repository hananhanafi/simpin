<?php

namespace App\Exports;

use App\Models\Data\Anggota;
use App\Models\Data\Pinjaman;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PlafonPinjaman implements FromView, WithTitle, ShouldAutoSize
{
    use Exportable;

    function __construct(
        string $no_anggota = null,
        string $masa = null,
        string $gaji = null,
        string $bulan = null,
        string $jml_pengajuan_baru = null,
        string $angsuran = null
    ) {
        $this->no_anggota = $no_anggota;
        $this->masa = $masa;
        $this->gaji = $gaji;
        $this->bulan = $bulan;
        $this->jml_pengajuan_baru = $jml_pengajuan_baru;
        $this->angsuran = $angsuran;
    }

    public function view(): View
    {
        $gaji40 = 0;
        $this->gaji = str_replace('.', '', $this->gaji);
        $gaji40 = $this->gaji * 0.4;

        $pinjaman = Pinjaman::where('no_anggota', 'like', "%$this->no_anggota%")->get();

        $jml_baru = str_replace('.', '', $this->jml_pengajuan_baru ?? 0);
        $angsuran = str_replace('.', '', $this->angsuran ?? 0);
        $anggota = Anggota::where('no_anggota', $this->no_anggota)->firstOrFail();

        $data = [
            'masa' => $this->masa,
            'gaji' => $this->gaji,
            'bulan' => $this->bulan,
        ];

        return view('pages.data.pinjaman.plafon-xls')
            ->with('pinjaman', $pinjaman)
            ->with('jml_baru', $jml_baru)
            ->with('gaji40', $gaji40)
            ->with('anggota', $anggota)
            ->with('data', $data)
            ->with('angsuran', $angsuran);
    }


    public function title(): string
    {
        return 'Simulasi Pinjaman';
    }
}
