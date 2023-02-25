<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Riskihajar\Terbilang\Facades\Terbilang;
use App\Exports\ExportArray;
use App\Exports\ExportArrayProduk;
use App\Exports\ExportArrayPotongan;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;

use App\Models\Master\ProdukKategori;
use App\Models\Master\Produk;
use App\Models\Master\Grade;
use App\Models\Master\Departemen;
use App\Models\Master\ProfitCenter;
use App\Models\Master\SumberDana;

use App\Models\Data\Anggota;

use App\Models\Data\Simpanan;
use Illuminate\Support\Str;



class Exports extends Controller
{
    public function produk_categori()
    {
        $produk = new ProdukKategori;
        $produk = $produk->get();
        $exportData = array();
        $exportData[] = ['', '', 'Master Data Produk Type'];
        $exportData[] = [''];
        $exportData[] = ['NO', 'KODE', 'NAMA PRODUK', 'TIPE PRODUK (1=Simpanan, 2=Pinnjaman)'];
        $no = 1;
        foreach ($produk as $a) {
            $collect[0] = $no++;
            $collect[1] = $a->kode;
            $collect[2] = $a->nama;
            $collect[3] = $a->tipe_produk;
            $exportData[] = $collect;
        }
        return  Excel::download(new ExportArray($exportData), 'master_produk_tipe.xlsx');
    }

    public function master_produk()
    {
        $produk = new Produk;
        $produk = $produk->get();
        $exportData = array();
        $exportData[] = ['', '', 'Master Produk'];
        $exportData[] = [''];
        $exportData[] = ['NO', 'KODE', 'NAMA PRODUK', 'TIPE PRODUK', 'JENIS', 'ADMIN FEE'];
        $no = 1;
        foreach ($produk as $a) {
            $collect[0] = $no++;
            $collect[1] = $a->kode;
            $collect[2] = $a->nama_produk;
            $collect[3] = $a->tipe;
            $collect[4] = $a->jenis_label;
            $collect[5] = $a->admin_fee;
            $exportData[] = $collect;
        }
        return  Excel::download(new ExportArrayProduk($exportData), 'master_produk.xlsx');
    }

    public function master_grade()
    {
        $produk = new Grade;
        $produk = $produk->get();
        $exportData = array();
        $exportData[] = ['', '', 'Master Grade'];
        $exportData[] = [''];
        $exportData[] = ['NO', 'KODE', 'NAMA GRADE', 'SIMPANAN POKOK (RP)', 'SIMPANAN WAJIB (RP)', 'SIMPANAN SUKARELA (RP)'];
        $no = 1;
        foreach ($produk as $a) {
            $collect[0] = $no++;
            $collect[1] = $a->kode;
            $collect[2] = $a->grade_name;
            $collect[3] = number_format($a->simp_pokok);
            $collect[4] = number_format($a->simp_wajib);
            $collect[5] = number_format($a->simp_sukarela);
            $exportData[] = $collect;
        }
        return  Excel::download(new ExportArray($exportData), 'master_grade.xlsx');
    }

    public function master_departemen()
    {
        $produk = new Departemen;
        $produk = $produk->get();
        $exportData = array();
        $exportData[] = ['', '', 'Master Departemen'];
        $exportData[] = [''];
        $exportData[] = ['NO', 'KODE', 'NAMA DEPARTEMEN', 'SUB DEPARTEMEN'];
        $no = 1;
        foreach ($produk as $a) {
            $collect[0] = $no++;
            $collect[1] = $a->kode;
            $collect[2] = $a->departemen;
            $collect[3] = ' ';
            $exportData[] = $collect;
        }
        return  Excel::download(new ExportArray($exportData), 'master_departemen.xlsx');
    }

    public function master_profit()
    {
        $produk = new ProfitCenter;
        $produk = $produk->get();
        $exportData = array();
        $exportData[] = ['', '', 'Master Profit Center'];
        $exportData[] = [''];
        $exportData[] = ['NO', 'KODE', 'NAMA PROFIT CENTER', 'KETERANGAN'];
        $no = 1;
        foreach ($produk as $a) {
            $collect[0] = $no++;
            $collect[1] = $a->kode;
            $collect[2] = $a->nama;
            $collect[3] = $a->desc;
            $exportData[] = $collect;
        }
        return  Excel::download(new ExportArray($exportData), 'master_profit_center.xlsx');
    }


    public function potongan_hrd(Request $request)
    {
        $anggota = new Anggota;
        // $anggota = $anggota->get();

        $anggota = Anggota::select(DB::raw('*'))
            ->with([
                'simpananAnggota' => function ($q) use ($request) {
                    $q
                        ->with(['detailSimpas' => function ($q2) use ($request) {
                            $q2
                                ->whereNull('deleted_at')
                                ->where('tahun', $request->tahun)
                                ->where('bulan', $request->bulan);
                        }])
                        ->where([
                            ['produk_id', '=', 4],
                            ['status_rekening', '=', 1]
                        ]);
                },
                'pinjamanAnggota' => function ($q) use ($request) {
                    $q
                        ->with(['detail' => function ($q2) use ($request) {
                            $q2
                                ->whereNull('deleted_at')
                                ->where('tahun', $request->tahun)
                                ->where('bulan', $request->bulan);
                        }])
                        ->whereIn('status_rekening', [2, 3])
                        ->where('sisa_hutangs', '>', '0');
                }
            ])
            ->orderBy('t_anggota.no_anggota')->get();

        $exportData = array();
        $exportData[] = ['', '', 'Potongan HRD'];
        $exportData[] = [''];
        $exportData[] = ['KODE PC', 'KODPEG', 'NAMA', 'TOTAL POTONGAN', 'POTONGAN KOPERASI', 'POTONGAN SEMBAKO', 'POTONGAN SIMPAS', 'POTONGAN DKM', 'SISA POTONGAN', 'POTONGAN POKOK', 'POTONGAN WAJIB'];
        $no = 1;
        foreach ($anggota as $a) {
            if (count($a->simpananAnggota) > 0) {
                $simpananArr = json_decode(json_encode($a->simpananAnggota), true);
                $totalAngsuranSimpas = 0;
                if (count($simpananArr) > 0 && count($simpananArr[0]['detail_simpas']) > 0) {
                    $detailsimpananArr = array_map(function ($val) {
                        return $val['tabungan_per_bulan'];
                    }, $simpananArr[0]['detail_simpas']);
                    $totalAngsuranSimpas = array_sum($detailsimpananArr);
                }
            } else {
                $totalAngsuranSimpas = 0;
            }
            if (count($a->pinjamanAnggota) > 0) {
                $pinjamanArr = json_decode(json_encode($a->pinjamanAnggota), true);
                // $totalAngsuranPinjaman = array_sum(array_column($pinjamanArr, 'angsuran'));
                $totalAngsuranPinjaman = 0;
                if (count($pinjamanArr) > 0 && count($pinjamanArr[0]['detail']) > 0) {
                    $detailPinjamanArr = array_map(function ($val) {
                        return $val['total_angsuran'];
                    }, $pinjamanArr[0]['detail']);
                    $totalAngsuranPinjaman = array_sum($detailPinjamanArr);
                }
                $totalHutang = array_sum(array_column($pinjamanArr, 'sisa_hutangs'));
            } else {
                $totalAngsuranPinjaman = 0;
                $totalHutang = 0;
            }

            $totalPotongan = $totalAngsuranSimpas + $totalAngsuranPinjaman;

            if ($a->profits === null) {
                $collect[0] = '-';
            } else {
                $collect[1] = $a->profits->kode;
            }
            $collect[1] = $a->no_anggota;
            $collect[2] = $a->nama;
            $collect[3] = $totalPotongan;
            $collect[4] = $totalAngsuranPinjaman;
            $collect[5] = '$row->db_POS';
            $collect[6] = $totalAngsuranSimpas;
            $collect[7] = $a->dkm;
            $collect[8] = $totalHutang;
            $collect[9] = $a->sim_pokok;
            $collect[10] = $a->sim_wajib;
            $exportData[] = $collect;
        }
        return  Excel::download(new ExportArrayPotongan($exportData), 'potongan_hrd.xlsx');
    }

    public function master_sumber()
    {
        $produk = new SumberDana;
        $produk = $produk->get();
        $exportData = array();
        $exportData[] = ['', '', 'Master Sumber Dana'];
        $exportData[] = [''];
        $exportData[] = ['NO', 'KODE', 'SUMBER DANA'];
        $no = 1;
        foreach ($produk as $a) {
            $collect[0] = $no++;
            $collect[1] = $a->kode;
            $collect[2] = $a->sumber_dana;
            $exportData[] = $collect;
        }
        return  Excel::download(new ExportArray($exportData), 'master_sumber_dana.xlsx');
    }

    public function sertifikat_ssb($id)
    {

        $simpanan = Simpanan::where('id', $id)->with(['produk', 'anggota', 'detail', 'detailsimpas'])->first();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(2);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(2);
        $sheet->getColumnDimension('E')->setWidth(45);
        $sheet->getColumnDimension('F')->setWidth(20);

        // $sheet->mergeCells('A1:A2');
        // $sheet->mergeCells('F1:F2');
        $sheet->mergeCells('B1:E1');
        $sheet->mergeCells('B2:E2');
        $sheet->mergeCells('A3:F3');
        $sheet->mergeCells('A4:F4');

        $sheet->mergeCells('A5:C5');
        $sheet->mergeCells('A6:C6');
        $sheet->mergeCells('A7:C7');
        $sheet->mergeCells('A8:C8');
        $sheet->mergeCells('A9:C9');

        $sheet->mergeCells('E5:F5');
        $sheet->mergeCells('E6:F6');
        $sheet->mergeCells('E7:F7');
        $sheet->mergeCells('E8:F8');
        $sheet->mergeCells('E9:F9');
        $sheet->mergeCells('A10:C10');
        $sheet->mergeCells('A11:C11');
        $sheet->mergeCells('A12:C12');
        $sheet->mergeCells('A13:C13');
        $sheet->mergeCells('A14:C14');
        $sheet->mergeCells('E10:F10');
        $sheet->mergeCells('E11:F11');
        $sheet->mergeCells('E12:F12');
        $sheet->mergeCells('E13:F13');
        $sheet->mergeCells('E14:F14');

        $sheet->mergeCells('A15:F15');
        $sheet->mergeCells('A16:F16');
        $sheet->mergeCells('A17:F17');
        $sheet->mergeCells('B18:E18');
        // $sheet->mergeCells('A18:A19');
        // $sheet->mergeCells('F18:F19');

        $sheet->mergeCells('B19:E19');
        $sheet->mergeCells('A20:F20');
        $sheet->mergeCells('A21:F21');

        $sheet->mergeCells('A22:C22');
        $sheet->mergeCells('A23:C23');
        $sheet->mergeCells('A24:C24');
        $sheet->mergeCells('A25:C25');
        $sheet->mergeCells('A26:C26');
        $sheet->mergeCells('A27:C27');
        $sheet->mergeCells('A28:C28');
        $sheet->mergeCells('A29:C29');
        $sheet->mergeCells('A30:C30');
        $sheet->mergeCells('A31:C31');
        $sheet->mergeCells('E26:F26');

        $sheet->mergeCells('A32:F32');
        $sheet->mergeCells('A33:F33');
        // $sheet->mergeCells('A34:B34');
        // $sheet->mergeCells('C35:C40');
        // $sheet->mergeCells('D35:D40');
        // $sheet->mergeCells('E35:E40');
        // $sheet->mergeCells('F35:F40');
        // $sheet->mergeCells('A41:F41');
        $sheet->mergeCells('A34:F34');
        $sheet->mergeCells('A35:F35');

        $boldStyle = ['font' => ['bold' => true]];
        $sheet->getStyle('A1:F2')->applyFromArray($boldStyle);
        $sheet->getStyle('A18:F19')->applyFromArray($boldStyle);

        $borderStyle = ['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM]]];
        // $sheet->getStyle('A34:B34')->applyFromArray($borderStyle);
        // $sheet->getStyle('A35:B40')->applyFromArray($borderStyle);
        // $sheet->getStyle('C34:C34')->applyFromArray($borderStyle);
        // $sheet->getStyle('C35:C40')->applyFromArray($borderStyle);
        // $sheet->getStyle('E34:E34')->applyFromArray($borderStyle);
        // $sheet->getStyle('E35:E40')->applyFromArray($borderStyle);
        // $sheet->getStyle('F34:F34')->applyFromArray($borderStyle);
        // $sheet->getStyle('F35:F40')->applyFromArray($borderStyle);
        $sheet->getStyle('A3:F3')->getBorders()->getTop()->setBorderStyle(Border::BORDER_THICK);
        $sheet->getStyle('A20:F20')->getBorders()->getTop()->setBorderStyle(Border::BORDER_THICK);

        $sheet->getStyle('B1:E1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('B2:E2')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('left');
        $sheet->getStyle('F1')->getAlignment()->setHorizontal('right');
        $sheet->getStyle('A19')->getAlignment()->setHorizontal('left');
        $sheet->getStyle('F19')->getAlignment()->setHorizontal('right');

        $sheet->getStyle('B18:E19')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A34:F40')->getAlignment()->setHorizontal('center');

        $sheet->getStyle('A3')->getAlignment()->setHorizontal('right');
        $sheet->getStyle('A15')->getAlignment()->setHorizontal('right');
        $sheet->getStyle('A16')->getAlignment()->setHorizontal('right');
        $sheet->getStyle('A20')->getAlignment()->setHorizontal('right');
        $sheet->getStyle('A5:F14')->getAlignment()->setHorizontal('left');
        $sheet->getStyle('A22:F31')->getAlignment()->setHorizontal('left');


        $sheet->getStyle('A33')->getAlignment()->setHorizontal('right');
        $sheet->getStyle('A34')->getAlignment()->setHorizontal('right');
        $sheet->getStyle('A35')->getAlignment()->setHorizontal('right');

        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('PhpSpreadsheet logo');
        $drawing->setDescription('PhpSpreadsheet logo');
        $drawing->setPath('assets/images/sertif-logo-left.jpg'); // put your path and image here
        $drawing->setHeight(50);
        $drawing->setCoordinates('A1');
        $drawing->setOffsetX(10);
        $drawing->setWorksheet($spreadsheet->getActiveSheet());


        $drawing2 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing2->setName('sertif-logo-right');
        $drawing2->setDescription('sertif-logo-right');
        $drawing2->setPath('assets/images/sertif-logo-right.jpg'); // put your path and image here
        $drawing2->setHeight(50);
        $drawing2->setCoordinates('F1');
        $drawing2->setOffsetX(10);
        $drawing2->setWorksheet($spreadsheet->getActiveSheet());


        $drawing18 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing18->setName('PhpSpreadsheet logo');
        $drawing18->setDescription('PhpSpreadsheet logo');
        $drawing18->setPath('assets/images/sertif-logo-left.jpg'); // put your path and image here
        $drawing18->setHeight(50);
        $drawing18->setCoordinates('A19');
        $drawing18->setOffsetX(10);
        $drawing18->setWorksheet($spreadsheet->getActiveSheet());


        $drawingf18 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawingf18->setName('sertif-logo-right');
        $drawingf18->setDescription('sertif-logo-right');
        $drawingf18->setPath('assets/images/sertif-logo-right.jpg'); // put your path and image here
        $drawingf18->setHeight(50);
        $drawingf18->setCoordinates('F19');
        $drawingf18->setOffsetX(10);
        $drawingf18->setWorksheet($spreadsheet->getActiveSheet());

        $sheet->setCellValue('B1', "SERTIFIKAT\n" . $simpanan->produk->nama_produk);
        // $sheet->setCellValue('A2', "Simpanan Sukarela Berjangka");
        // $sheet->setCellValue('B2',  $simpanan->produk->nama_produk);

        $sheet->setCellValue('A3', "ASLI");

        $sheet->getRowDimension('3')->setRowHeight(30);
        $sheet->getStyle('A3:F3')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getRowDimension('1')->setRowHeight(30);
        $sheet->getRowDimension('2')->setRowHeight(10);
        $sheet->getStyle('B1:E1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('B2:E2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        $sheet->getStyle('B1:E1')->getFont()->setSize(16);
        $sheet->getStyle('B2:E2')->getFont()->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('F1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        // $sheet->setCellValue('B18', "SERTIFIKAT");
        $sheet->setCellValue('B19', "SERTIFIKAT\n" . $simpanan->produk->nama_produk);
        // $sheet->setCellValue('A19', "Simpanan Sukarela Berjangka");
        // $sheet->setCellValue('B19', $simpanan->produk->nama_produk);
        $sheet->setCellValue('A20', "COPY");

        $sheet->getRowDimension('20')->setRowHeight(30);
        $sheet->getStyle('A20:F20')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getRowDimension('18')->setRowHeight(60);
        $sheet->getRowDimension('19')->setRowHeight(60);
        $sheet->getStyle('B18:E18')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_BOTTOM);
        $sheet->getStyle('B19:E19')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('B18:E18')->getFont()->setSize(16);
        $sheet->getStyle('B19:E19')->getFont()->setSize(16);
        $sheet->getStyle('A19')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('F19')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        // $sheet->setCellValue('A34', "TTD 1");
        // $sheet->setCellValue('C34', "TTD 2");
        // $sheet->setCellValue('E34', "Petugas Koperasi");
        // $sheet->setCellValue('F34', "Diperiksa/Disahkan");
        $sheet->setCellValue('A33', "KOPERASI KARYAWAN MULIA INDUSTRY");
        $sheet->getRowDimension('33')->setRowHeight(20);
        $sheet->getStyle('A33:F33')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_BOTTOM);
        $sheet->setCellValue('A34', date('d M Y'));
        // $sheet->setCellValue('A41', "Mohon Tanda Tangan Tidak Melewati Kotak");

        $sheet->setCellValue('D5', ':');
        $sheet->setCellValue('D6', ':');
        $sheet->setCellValue('D7', ':');
        $sheet->setCellValue('D8', ':');
        $sheet->setCellValue('D9', ':');
        $sheet->setCellValue('D10', ':');
        $sheet->setCellValue('D11', ':');
        $sheet->setCellValue('D12', ':');
        $sheet->setCellValue('D13', ':');
        $sheet->setCellValue('D14', ':');
        $sheet->setCellValue('D22', ':');
        $sheet->setCellValue('D23', ':');
        $sheet->setCellValue('D24', ':');
        $sheet->setCellValue('D25', ':');
        $sheet->setCellValue('D26', ':');
        $sheet->setCellValue('D27', ':');
        $sheet->setCellValue('D28', ':');
        $sheet->setCellValue('D29', ':');
        $sheet->setCellValue('D30', ':');
        $sheet->setCellValue('D31', ':');

        $sheet->setCellValue('A5', 'NOMOR SERTIFIKAT');
        $sheet->getRowDimension('5')->setRowHeight(22);
        $sheet->setCellValue('A6', 'NIK/NOMOR ANGGOTA');
        $sheet->getRowDimension('6')->setRowHeight(22);
        $sheet->setCellValue('A7', 'NAMA ANGGOTA');
        $sheet->getRowDimension('7')->setRowHeight(32);
        $sheet->setCellValue('A8', 'JUMLAH NOMINAL');
        $sheet->getRowDimension('8')->setRowHeight(22);
        $sheet->setCellValue('A9', 'TERBILANG');
        $sheet->getRowDimension('9')->setRowHeight(32);
        $sheet->setCellValue('A10', 'JANGKA WAKTU');
        $sheet->getRowDimension('10')->setRowHeight(22);
        $sheet->setCellValue('A11', 'BUNGA PER TAHUN');
        $sheet->getRowDimension('11')->setRowHeight(22);
        if (strpos(Str::slug($simpanan->produk->nama_produk), "simpanan-pasti") !== false) {
            $sheet->setCellValue('A12', 'ANGSURAN PER BULAN');
        } else {
            $sheet->setCellValue('A12', 'JENIS BUNGA');
        }
        $sheet->getRowDimension('12')->setRowHeight(32);
        // $sheet->setCellValue('A12', 'Jenis Simpanan');
        $sheet->setCellValue('A13', 'TANGGAL PENEMPATAN');
        $sheet->getRowDimension('13')->setRowHeight(22);
        $sheet->setCellValue('A14', 'TANGGAL JATUH TEMPO');
        $sheet->getRowDimension('14')->setRowHeight(22);
        $sheet->getStyle('A5:F14')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        $sheet->getStyle('A5:F16')->getFont()->setSize(12);

        $sheet->getStyle('A5:A14')->applyFromArray($boldStyle);
        $sheet->getStyle('A22:A31')->applyFromArray($boldStyle);

        $sheet->setCellValue('A22', 'NOMOR SERTIFIKAT');
        $sheet->getRowDimension('22')->setRowHeight(22);
        $sheet->setCellValue('A23', 'NIK/NOMOR ANGGOTA');
        $sheet->getRowDimension('23')->setRowHeight(22);
        $sheet->setCellValue('A24', 'NAMA ANGGOTA');
        $sheet->getRowDimension('24')->setRowHeight(32);
        $sheet->setCellValue('A25', 'JUMLAH NOMINAL');
        $sheet->getRowDimension('25')->setRowHeight(22);
        $sheet->setCellValue('A26', 'TERBILANG');
        $sheet->getRowDimension('26')->setRowHeight(32);
        $sheet->setCellValue('A27', 'JANGKA WAKTU');
        $sheet->getRowDimension('27')->setRowHeight(22);
        $sheet->setCellValue('A28', 'BUNGA PER TAHUN');
        $sheet->getRowDimension('28')->setRowHeight(22);
        if (strpos(Str::slug($simpanan->produk->nama_produk), "simpanan-pasti") !== false) {
            $sheet->setCellValue('A29', 'ANGSURAN PER BULAN');
        } else {
            $sheet->setCellValue('A29', 'JENIS BUNGA');
        }
        $sheet->getRowDimension('29')->setRowHeight(32);
        // $sheet->setCellValue('A29', 'Jenis Simpanan');
        $sheet->setCellValue('A30', 'TANGGAL PENEMPATAN');
        $sheet->getRowDimension('30')->setRowHeight(22);
        $sheet->setCellValue('A31', 'TANGGAL JATUH TEMPO');
        $sheet->getRowDimension('31')->setRowHeight(22);
        $sheet->getStyle('A22:F31')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        $sheet->getStyle('A22:F33')->getFont()->setSize(12);

        $sheet->setCellValue('A15', "KOPERASI KARYAWAN MULIA INDUSTRY");
        $sheet->getRowDimension('15')->setRowHeight(20);
        $sheet->getStyle('A15:F15')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_BOTTOM);

        $sheet->setCellValue('A16', date('d M Y'));

        $created = $simpanan->created_at;
        $add_month = '+' . ($simpanan->jangka_waktu - 1) . ' months';
        $tempo = date('d M Y', strtotime($add_month, strtotime($created)));


        $word_2 = $simpanan->no_anggota;
        $word_3 = $simpanan->nama;
        $word_4 = 'Rp. ' . number_format($simpanan->saldo_akhir, 0, ',', '.');
        $word_5 =  strtoupper(Terbilang::make($simpanan->saldo_akhir, ' rupiah'));
        $word_6 = $simpanan->jangka_waktu . ' Bulan';
        $word_7 = $simpanan->jumlah_bunga . '%';
        // $word_8 = strtoupper($simpanan->detail[0]->jenis);
        // $word_8 = strtoupper($simpanan->produk->nama_produk);
        $numberingSertif = [
            '1' => '0000',
            '2' => '000',
            '3' => '00',
            '4' => '0',
            '5' => '',
        ];
        if (strpos(Str::slug($simpanan->produk->nama_produk), "simpanan-pasti") !== false) {
            $word_1 = 'SP' . date('Y', strtotime($simpanan->created_at)) . $numberingSertif[(strlen($simpanan->id))] . $simpanan->id;
            $word_8 = 'Rp. ' . number_format($simpanan->detailsimpas[0]->tabungan_per_bulan ?? 0, 2, ',', '.');
        } else {
            $word_1 = 'SSB' . date('Y', strtotime($simpanan->created_at)) . $numberingSertif[(strlen($simpanan->id))] . $simpanan->id;
            // $word_1 = 'SSB' . $numberingSertif[(strlen($simpanan->id))];

            $word_8 = strtoupper($simpanan->detail[0]->jenis ?? '-');
        }
        $word_9 = date('d M Y', strtotime($simpanan->created_at));
        $word_10 = $tempo;

        $sheet->setCellValue('E5', $word_1);
        $sheet->setCellValue('E6', $word_2);
        $sheet->setCellValue('E7', $word_3);
        $sheet->setCellValue('E8', $word_4);
        $sheet->setCellValue('E9', $word_5);
        $sheet->setCellValue('E10', $word_6);
        $sheet->setCellValue('E11', $word_7);
        $sheet->setCellValue('E12', $word_8);
        $sheet->setCellValue('E13', $word_9);
        $sheet->setCellValue('E14', $word_10);

        $sheet->setCellValue('E22', $word_1);
        $sheet->setCellValue('E23', $word_2);
        $sheet->setCellValue('E24', $word_3);
        $sheet->setCellValue('E25', $word_4);
        $sheet->setCellValue('E26', $word_5);
        $sheet->setCellValue('E27', $word_6);
        $sheet->setCellValue('E28', $word_7);
        $sheet->setCellValue('E29', $word_8);
        $sheet->setCellValue('E30', $word_9);
        $sheet->setCellValue('E31', $word_10);

        // $sheet->setCellValue('A17', 'ooooooooooooooooooooo');
        // $sheet->setCellValue('A32', 'ooooooooooooooooooooo');
        // $sheet->setCellValue('A36', 'ooooooooooooooooooooo');
        // $sheet->setCellValue('A37', 'ooooooooooooooooooooo');
        // $sheet->setCellValue('A38', 'ooooooooooooooooooooo');
        // $sheet->setCellValue('A39', 'ooooooooooooooooooooo');
        // $sheet->setCellValue('A40', 'ooooooooooooooooooooo');

        // $transparent = array('font' => array('color' => array('rgb' => 'FFFFFF')));
        // $sheet->getStyle('A17')->applyFromArray($transparent);
        // $sheet->getStyle('A32')->applyFromArray($transparent);
        // $sheet->getStyle('A35:F40')->applyFromArray($transparent);

        /*
        $writer = new Xlsx($spreadsheet);
        $fileName =  strtotime('now').'.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . urlencode($fileName) . '"');
        $writer->save('php://output');
        */
        header("Content-type:application/pdf");
        header('Content-Disposition:attachment;filename="Sertifikat-' . Str::slug($simpanan->produk->nama_produk) . '-' . $word_1 . '.pdf"');
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf($spreadsheet);
        ob_end_clean();
        $writer->save('php://output');
    }
}
