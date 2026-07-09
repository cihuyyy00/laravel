<?php

namespace App\Exports;

use App\Models\Absensi;
use App\Models\Siswa;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection; // nyediain data yg mau di export
use Maatwebsite\Excel\Concerns\WithHeadings; //buat nama kolom paling atas

class RekapExport implements FromCollection, WithHeadings {
    public function collection() {
        return $rekap = Absensi::select(
            'siswa_id',

            // maksudnya kalo status "Hadir" kasih nilai 1, klo bukan kasi 0
        DB::raw("SUM(CASE WHEN status = 'Hadir' THEN 1 ELSE 0 END) as total_hadir"),
        DB::raw("SUM(CASE WHEN status = 'Sakit' THEN 1 ELSE 0 END) as total_sakit"),
        DB::raw("SUM(CASE WHEN status = 'Izin' THEN 1 ELSE 0 END) as total_izin"),
        DB::raw("SUM(CASE WHEN status = 'Alpa' THEN 1 ELSE 0 END) as total_alpa")
        )

        ->groupBy('siswa_id') // make groupBy biar dibikin per siswa, klo tanpa ini jdi 1 ntar
        ->with('siswa') // biar relasi ke tabel siswa
        ->get()
        ->map(function($rekap) {
            return [
                'nama'      => $rekap->siswa->nama,
                'Hadir'     => $rekap->total_hadir,
                'Sakit'     => $rekap->total_sakit,
                'Izin'      => $rekap->total_izin,
                'Alpa'      => $rekap->total_alpa,
            ];
        });
    }


    // make heading buat bkin Kolom pling atas di excel
    public function headings(): array {
        return ['Nama Siswa', 'Hadir', 'Sakit', 'Izin', 'Alpa'];
    }
    
}


?>