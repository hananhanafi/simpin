<?php
namespace App\Http\Controllers;

use DB;
use Terbilang;
use App\Exports\ExportArray;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf;

use Maatwebsite\Excel\Facades\Excel;

use App\Models\Master\ProdukKategori;
use App\Models\Master\Produk;
use App\Models\Master\Grade;
use App\Models\Master\Departemen;
use App\Models\Master\ProfitCenter;
use App\Models\Master\SumberDana;

use App\Models\Data\Anggota;

use App\Models\Data\Simpanan;



class Exports extends Controller
{
    public function produk_categori()
    {
        $produk = new ProdukKategori;
        $produk = $produk->get();
        $exportData = array();
        $exportData[] = ['','','Master Data Produk Type'];
        $exportData[] = [''];
        $exportData[] = ['NO','KODE','NAMA PRODUK','TIPE PRODUK'];
        $no=1;
        foreach($produk as $a){
            $collect[0] = $no++;
            $collect[1] = $a->kode;
            $collect[2] = $a->nama;
            $collect[3] = $a->tipe_produk;
            $exportData[] = $collect;
        }
        return  Excel::download(new ExportArray($exportData),'master_produk_tipe.xlsx');
    }

    public function master_produk()
    {
        $produk = new Produk;
        $produk = $produk->get();
        $exportData = array();
        $exportData[] = ['','','Master Produk'];
        $exportData[] = [''];
        $exportData[] = ['NO','KODE','NAMA PRODUK','TIPE PRODUK','JENIS','ADMIN FEE'];
        $no=1;
        foreach($produk as $a){
            $collect[0] = $no++;
            $collect[1] = $a->kode;
            $collect[2] = $a->nama_produk;
            $collect[3] = $a->tipe_produk;
            $collect[4] = $a->tipe_akad;
            $collect[5] = $a->admin_fee;
            $exportData[] = $collect;
        }
        return  Excel::download(new ExportArray($exportData),'master_produk.xlsx');
    }

    public function master_grade()
    {
        $produk = new Grade;
        $produk = $produk->get();
        $exportData = array();
        $exportData[] = ['','','Master Grade'];
        $exportData[] = [''];
        $exportData[] = ['NO','KODE','NAMA GRADE','SIMPANAN POKOK (RP)','SIMPANAN WAJIB (RP)','SIMPANAN SUKARELA (RP)'];
        $no=1;
        foreach($produk as $a){
            $collect[0] = $no++;
            $collect[1] = $a->kode;
            $collect[2] = $a->grade_name;
            $collect[3] = number_format($a->simp_pokok);
            $collect[4] = number_format($a->simp_wajib);
            $collect[5] = number_format($a->simp_sukarela);
            $exportData[] = $collect;
        }
        return  Excel::download(new ExportArray($exportData),'master_grade.xlsx');
    }

    public function master_departemen()
    {
        $produk = new Departemen;
        $produk = $produk->get();
        $exportData = array();
        $exportData[] = ['','','Master Departemen'];
        $exportData[] = [''];
        $exportData[] = ['NO','KODE','NAMA DEPARTEMEN','SUB DEPARTEMEN'];
        $no=1;
        foreach($produk as $a){
            $collect[0] = $no++;
            $collect[1] = $a->kode;
            $collect[2] = $a->departemen;
            $collect[3] = ' ';
            $exportData[] = $collect;
        }
        return  Excel::download(new ExportArray($exportData),'master_departemen.xlsx');
    }

    public function master_profit()
    {
        $produk = new ProfitCenter;
        $produk = $produk->get();
        $exportData = array();
        $exportData[] = ['','','Master Profit Center'];
        $exportData[] = [''];
        $exportData[] = ['NO','KODE','NAMA PROFIT CENTER','KETERANGAN'];
        $no=1;
        foreach($produk as $a){
            $collect[0] = $no++;
            $collect[1] = $a->kode;
            $collect[2] = $a->nama;
            $collect[3] = $a->desc;
            $exportData[] = $collect;
        }
        return  Excel::download(new ExportArray($exportData),'master_profit_center.xlsx');
    }


    public function potongan_hrd()
    {
        $anggota = new Anggota;
        $anggota = $anggota->get();
        $exportData = array();
        $exportData[] = ['','','Potongan HRD'];
        $exportData[] = [''];
        $exportData[] = ['NO','KODE PC','KODPEG','NAMA','TOTAL POTONGAN', 'POTONGAN POKOK', 'POTONGAN WAJIB', 'POTONGAN SIMPAS', 'POTONGAN KOPERASI', 'POTONGAN DKM', 'SISA POTONGAN'];
        $no=1;
        foreach($anggota as $a){
            $collect[0] = $no++;
            if($a->profits===null){
                $collect[1] = '-';
            }else{
                $collect[1] = $a->profits->kode;
            }
            $collect[2] = $a->no_anggota;
            $collect[3] = $a->nama;
            $collect[4] = 'total_potongan';
            $collect[5] = 'simpanan_pokok';
            $collect[6] = 'simpanan_wajib';
            $collect[7] = 'simpanan_simpas';
            $collect[8] = 'simpanan_koperasi';
            $collect[9] = 'simpanan_dkm';
            $collect[10] = 'sisa_potongan';
            $exportData[] = $collect;
        }
        return  Excel::download(new ExportArray($exportData),'potongan_hrd.xlsx');
    }

    public function master_sumber()
    {
        $produk = new SumberDana;
        $produk = $produk->get();
        $exportData = array();
        $exportData[] = ['','','Master Sumber Dana'];
        $exportData[] = [''];
        $exportData[] = ['NO','KODE','SUMBER DANA'];
        $no=1;
        foreach($produk as $a){
            $collect[0] = $no++;
            $collect[1] = $a->kode;
            $collect[2] = $a->sumber_dana;
            $exportData[] = $collect;
        }
        return  Excel::download(new ExportArray($exportData),'master_sumber_dana.xlsx');
    }

    public function sertifikat_ssb($id)
    {

        $simpanan = Simpanan::where('id', $id)->with(['produk', 'anggota', 'detail', 'detailsimpas'])->first();
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(2);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(2);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(20);

        $sheet->mergeCells('A1:F1');
        $sheet->mergeCells('A2:F2');
        $sheet->mergeCells('A3:F3');
        $sheet->mergeCells('A4:F4');

        $sheet->mergeCells('A5:C5');
        $sheet->mergeCells('A6:C6');
        $sheet->mergeCells('A7:C7');
        $sheet->mergeCells('A8:C8');
        $sheet->mergeCells('A9:C9');
        $sheet->mergeCells('A10:C10');
        $sheet->mergeCells('A11:C11');
        $sheet->mergeCells('A12:C12');
        $sheet->mergeCells('A13:C13');
        $sheet->mergeCells('A14:C14');

        $sheet->mergeCells('E5:F5');
        $sheet->mergeCells('E6:F6');
        $sheet->mergeCells('E7:F7');
        $sheet->mergeCells('E8:F8');
        $sheet->mergeCells('E9:F9');
        $sheet->mergeCells('E10:F10');
        $sheet->mergeCells('E11:F11');
        $sheet->mergeCells('E12:F12');
        $sheet->mergeCells('E13:F13');
        $sheet->mergeCells('E14:F14');

        $sheet->mergeCells('A15:F15');
        $sheet->mergeCells('A16:F16');
        $sheet->mergeCells('A17:F17');
        $sheet->mergeCells('A18:F18');

        $sheet->mergeCells('A19:F19');
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

        $sheet->mergeCells('A32:F32');
        $sheet->mergeCells('A33:F33');
        $sheet->mergeCells('A34:B34');
        $sheet->mergeCells('C35:C40');
        $sheet->mergeCells('D35:D40');
        $sheet->mergeCells('E35:E40');
        $sheet->mergeCells('F35:F40');
        $sheet->mergeCells('A41:F41');

        $boldStyle = ['font' => ['bold' => true]];
        $sheet->getStyle('A1:F2')->applyFromArray($boldStyle);
        $sheet->getStyle('A18:F19')->applyFromArray($boldStyle);

        $borderStyle = ['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM]]];
        $sheet->getStyle('A34:B34')->applyFromArray($borderStyle);
        $sheet->getStyle('A35:B40')->applyFromArray($borderStyle);
        $sheet->getStyle('C34:C34')->applyFromArray($borderStyle);
        $sheet->getStyle('C35:C40')->applyFromArray($borderStyle);
        $sheet->getStyle('E34:E34')->applyFromArray($borderStyle);
        $sheet->getStyle('E35:E40')->applyFromArray($borderStyle);
        $sheet->getStyle('F34:F34')->applyFromArray($borderStyle);
        $sheet->getStyle('F35:F40')->applyFromArray($borderStyle);
        $sheet->getStyle('A3:F3')->getBorders()->getTop()->setBorderStyle(Border::BORDER_THICK);
        $sheet->getStyle('A20:F20')->getBorders()->getTop()->setBorderStyle(Border::BORDER_THICK);

        $sheet->getStyle('A1:F2')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A18:F19')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A34:F40')->getAlignment()->setHorizontal('center');

        $sheet->getStyle('A3')->getAlignment()->setHorizontal('right');
        $sheet->getStyle('A15')->getAlignment()->setHorizontal('right');
        $sheet->getStyle('A16')->getAlignment()->setHorizontal('right');
        $sheet->getStyle('A20')->getAlignment()->setHorizontal('right');
        $sheet->getStyle('A5:F14')->getAlignment()->setHorizontal('left');
        $sheet->getStyle('A22:F31')->getAlignment()->setHorizontal('left');

        $sheet->setCellValue('A1', "SERTIFIKAT");
        // $sheet->setCellValue('A2', "Simpanan Sukarela Berjangka");
        $sheet->setCellValue('A2',  $simpanan->produk->nama_produk);
       
        $sheet->setCellValue('A3', "Copy Ke 1");

        $sheet->setCellValue('A18', "TANDA TANGAN");
        // $sheet->setCellValue('A19', "Simpanan Sukarela Berjangka");
        $sheet->setCellValue('A19', $simpanan->produk->nama_produk);
        $sheet->setCellValue('A20', "Copy Ke 2");

        $sheet->setCellValue('A34', "TTD 1");
        $sheet->setCellValue('C34', "TTD 2");
        $sheet->setCellValue('E34', "Petugas Koperasi");
        $sheet->setCellValue('F34', "Diperiksa/Disahkan");
        $sheet->setCellValue('A41', "Mohon Tanda Tangan Tidak Melewati Kotak");

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

        $sheet->setCellValue('A5','Nomor Sertifikat');
        $sheet->setCellValue('A6','Nomor Anggota');
        $sheet->setCellValue('A7','Nama Anggota');
        $sheet->setCellValue('A8','Jumlah Nominal');
        $sheet->setCellValue('A9','Terbilang');
        $sheet->setCellValue('A10','Jangka Waktu');
        $sheet->setCellValue('A11','Bunga per tahun	');
        $sheet->setCellValue('A12','Jenis Simpanan');
        $sheet->setCellValue('A13','Tanggal Penempatan');
        $sheet->setCellValue('A14','Tangga Jatuh Tempo');

        $sheet->setCellValue('A22', 'Nomor Sertifikat');
        $sheet->setCellValue('A23', 'Nomor Anggota');
        $sheet->setCellValue('A24', 'Nama Anggota');
        $sheet->setCellValue('A25', 'Jumlah Nominal');
        $sheet->setCellValue('A26', 'Terbilang');
        $sheet->setCellValue('A27', 'Jangka Waktu');
        $sheet->setCellValue('A28', 'Bunga per tahun	');
        $sheet->setCellValue('A29', 'Jenis Simpanan');
        $sheet->setCellValue('A30', 'Tanggal Penempatan');
        $sheet->setCellValue('A31', 'Tangga Jatuh Tempo');

        $sheet->setCellValue('A15', "Koperasi Karyawan Mulia Industri");
        $sheet->setCellValue('A16', "22 Desember 2022");

        $created = $simpanan->created_at;
        $add_month = '+' . ($simpanan->jangka_waktu - 1) . ' months -1 day';
        $tempo = date('d M Y', strtotime($add_month, strtotime($created)));

        $word_1 = date('Y', strtotime($simpanan->created_at)) . $simpanan->id . $simpanan->no_anggota;
        $word_2 = $simpanan->no_anggota;
        $word_3 = $simpanan->nama;
        $word_4 = 'Rp. '. number_format($simpanan->saldo_akhir, 0, ',', '.');
        $word_5=  strtoupper(Terbilang::make($simpanan->saldo_akhir, ' rupiah')) ;
        $word_6 = $simpanan->jangka_waktu;
        $word_7 = $simpanan->jumlah_bunga .'%';
        // $word_8 = strtoupper($simpanan->detail[0]->jenis);
        $word_8 = strtoupper($simpanan->produk->nama_produk);
        $word_9 = date('d M Y', strtotime($simpanan->created_at));
        $word_10 = $tempo;

        $sheet->setCellValue('E5',$word_1);
        $sheet->setCellValue('E6',$word_2);
        $sheet->setCellValue('E7',$word_3);
        $sheet->setCellValue('E8',$word_4);
        $sheet->setCellValue('E9',$word_5);
        $sheet->setCellValue('E10',$word_6);
        $sheet->setCellValue('E11',$word_7);
        $sheet->setCellValue('E12',$word_8);
        $sheet->setCellValue('E13',$word_9);
        $sheet->setCellValue('E14',$word_10);

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

        $sheet->setCellValue('A17', 'ooooooooooooooooooooo');
        $sheet->setCellValue('A32', 'ooooooooooooooooooooo');
        $sheet->setCellValue('A36', 'ooooooooooooooooooooo');
        $sheet->setCellValue('A37', 'ooooooooooooooooooooo');
        $sheet->setCellValue('A38', 'ooooooooooooooooooooo');
        $sheet->setCellValue('A39', 'ooooooooooooooooooooo');
        $sheet->setCellValue('A40', 'ooooooooooooooooooooo');

        $transparent = array('font' => array('color' => array('rgb' => 'FFFFFF')));
        $sheet->getStyle('A17')->applyFromArray($transparent);
        $sheet->getStyle('A32')->applyFromArray($transparent);
        $sheet->getStyle('A35:F40')->applyFromArray($transparent);

        /*
        $writer = new Xlsx($spreadsheet);
        $fileName =  strtotime('now').'.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . urlencode($fileName) . '"');
        $writer->save('php://output');
        */
        header("Content-type:application/pdf");
        header('Content-Disposition:attachment;filename="Sertifikat-SSB-' . $word_1 . '.pdf"');
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf($spreadsheet);
        ob_end_clean();
        $writer->save('php://output');


    }
}
?>
