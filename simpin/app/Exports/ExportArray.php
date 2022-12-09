<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExportArray implements FromArray, ShouldAutoSize
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
}
