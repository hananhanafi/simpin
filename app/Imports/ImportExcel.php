<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportExcel implements ToModel
{
    public function model(array $rows)
    {

        $data = array();
        $index = 0;
        foreach ($rows as $row) {
            $data[$index] = $row;
            $index++;
        }

        return $data;
    }
}
