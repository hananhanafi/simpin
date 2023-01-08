<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ExportArrayProduk implements FromArray, WithChunkReading, WithColumnFormatting
{
    protected $datas;

    public function __construct(array $datas)
    {
        $this->datas = $datas;
    }

    function array(): array
    {
        return $this->datas;
    }
    
    public function chunkSize(): int
    {
        return 1000;
    }
    
    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }
}
