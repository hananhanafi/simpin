<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ExportArray implements FromArray, WithChunkReading
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
}
