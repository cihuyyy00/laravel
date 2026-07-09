<?php

namespace App\Exports;

use App\Models\Absensi;
use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\FromCollection; // nyediain data yg mau di export
use Maatwebsite\Excel\Concerns\WithHeadings; //buat nama kolom paling atas

class AbsensiExport implements FromCollection, WithHeadings {
    public function collection() {
        return Absensi::with('siswa')->get() // get() = buat ambil semua data

        // map-$absensi = looping data trus diubah strukturny biar sesuai sama yg mau kita export
        // trus dibikin array, intinya format data sebelum jdi file gtu
        ->map(function($absensi) {
            return [
                'id'        => $absensi->id,
                'nama'      => $absensi->siswa->nama,
                'status'    => $absensi->status,
                'tanggal'   => $absensi->tanggal,
            ];
        });
    }

    public function headings(): array {
        return ['ID', 'Nama', 'Status', 'Tanggal'];
    }
    
}


?>