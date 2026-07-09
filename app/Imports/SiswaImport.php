<?php

namespace App\Imports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;

class SiswaImport implements ToModel
{
    public function model(array $row)
    {
        return new Siswa([
            'nama'          => $row[0],
            'nis'           => $row[1],
            'kelas_id'      => $row[2],
            'alamat'        => $row[3],
            'wali_kelas'    => $row[4]
        ]);
    }
}
