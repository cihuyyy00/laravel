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

    public function analisAI() {
        $siswamasalah = DB::table('absensis')
        ->join('users', 'absensis.siswa_id', '=', 'users.id') // sesuaikan kolom FK lu jika beda
        ->select('users.name', DB::raw('count(*) as total_alpa'))
        ->where('absensis.status', 'Alpa')
        ->groupBy('users.name')
        ->orderBy('total_alpa', 'desc')
        ->take(5) // Ambil 5 teratas yang paling sering alpa
        ->get();

    if ($siswamasalah->isEmpty()) {
        return response()->json([
            'status' => 'success',
            'message' => 'Semua siswa rajin! Tidak ada data absensi buruk untuk dianalisis AI.'
        ]);
    }

    // 3. Susun bahan laporan (Prompt) untuk disuapkan ke AI
    $dataTeks = "";
    foreach ($siswamasalah as $s) {
        $dataTeks .= "- Siswa bernama {$s->name} telah Alpa sebanyak {$s->total_alpa} kali.\n";
    }

    $prompt = "Kamu adalah seorang konselor sekolah dan psikolog pendidikan profesional. "
            . "Berikut adalah data siswa yang sering membolos/Alpa di sekolah kami:\n\n"
            . $dataTeks . "\n"
            . "Tolong berikan analisis singkat, prediksi risiko akademis mereka, "
            . "dan berikan rekomendasi tindakan nyata yang harus dilakukan oleh Guru atau Wali Kelas. "
            . "Gunakan bahasa Indonesia yang profesional, ramah, dan solutif. Jangan terlalu panjang, langsung ke poin penting.";

    // 4. Ambil API Key dari file .env
    $apiKey = env('AQ.Ab8RN6L7YOlFKbKZJHqZ6N83UwkVUA3qgpcl1vIaUWHGVWyk4A');

    // 5. Tembak API Gemini menggunakan HTTP Client bawaan Laravel
    $response = Http::withHeaders([
        'Content-Type' => 'application/json'
    ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}", [
        'contents' => [
            [
                'parts' => [
                    ['text' => $prompt]
                ]
            ]
        ]
    ]);

    // 6. Handle jika API AI-nya lagi eror atau down
    if ($response->failed()) {
        return response()->json([
            'status' => 'error',
            'message' => 'Gagal terhubung ke AI Konselor. Coba beberapa saat lagi.'
        ], 500);
    }

    // 7. Ekstrak teks jawaban dari struktur JSON bawaan Gemini
    $hasilAI = $response->json('candidates.0.content.parts.0.text');

    // 8. Kembalikan respons sukses ke Postman/Frontend
    return response()->json([
        'status' => 'success',
        'message' => 'Analisis AI Konselor berhasil dibuat',
        'data' => [
            'tren_alpa_siswa' => $siswamasalah,
            'analisis_dan_rekomendasi_ai' => $hasilAI
        ]
    ], 200);
}
}