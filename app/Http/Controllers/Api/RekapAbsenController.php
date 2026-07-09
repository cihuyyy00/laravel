<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class RekapAbsenController extends Controller
{
    public function index(Request $request) {

        $t_siswa = Siswa::count();  // count = hitung total

        $rekap = Absensi::select('siswa_id', 
        DB::raw("SUM(CASE WHEN status = 'Hadir' THEN 1 ELSE 0 END) as total_hadir"),
        DB::raw("SUM(CASE WHEN status = 'Sakit' THEN 1 ELSE 0 END) as total_sakit"),
        DB::raw("SUM(CASE WHEN status = 'Izin' THEN 1 ELSE 0 END) as total_izin"),
        DB::raw("SUM(CASE WHEN status = 'Alpa' THEN 1 ELSE 0 END) as total_alpa")
    )
    ->groupBy('siswa_id')
    ->with('siswa');

    $absentotal = DB::table('absensis')
    ->select('status', DB::raw('count(*) as total'))    // MySQL ngitung brp bnyk data di masing2 kelompok lalu menamainy sbg kolom "total".
    ->groupBy('status')                                 // SQL ngelompokin data sesuai isi kolom "status"
    ->pluck('total', 'status')                          // ubah format jdi key-value("hadir" => 12), klo g pake("status": "hadir", "total": 12)
    ->toArray();

    $daftarStatus   = ['Hadir', 'Izin', 'Sakit', 'Alpa'];
    $grafik         = [];

    foreach ($daftarStatus as $s) {
        // Null Coalescing Operator
        $grafik[$s] = $absentotal[$s] ?? 0; // baca : coba cek di variabel $absentotal ada data untuk status ini gak? Kalau ada, masukin angkanya. Tapi kalau GAK ADA (alias null), paksa set jadi 0.
    }
    
    $query = $rekap
    ->get()
    ->map(function ($item) {
        return [
            'nama'  => $item->siswa->nama ?? '-',
            'hadir' => $item->total_hadir,
            'sakit' => $item->total_sakit,
            'izin'  => $item->total_izin,
            'alpa'  => $item->total_alpa
        ];
    });

    return response()->json([
        'status'    => 'succes',
        'total_siswa'   => $t_siswa,
        'grafik'        => $grafik,
        'data'          => $query
    ]);

    }
}