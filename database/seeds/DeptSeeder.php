<?php

use App\Models\Master\Departemen;
use Illuminate\Database\Seeder;
// use Illuminate\Filesystem\Filesystem as File;
use Illuminate\Support\Facades\Storage;

class DeptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {

        Departemen::truncate();

        // $json = File::get("database/data/dept.json");
        // $json = Storage::disk("database/data/dept.json");
        $path = 'database/data/dept.json';
        $data = json_decode(file_get_contents($path), true);
        // dd($data);
        foreach ($data as $key => $value) {
            Departemen::insert([
                // 'id' => $value->id,
                'parent_id' => $value->parent_id,
                'kode' => $value->kode,
                'departemen' => $value->departemen,
            ]);
        }
    }
}
