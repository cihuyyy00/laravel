<?php

namespace App\Http\Controllers;

use App\Exports\AbsensiExport;
use App\Exports\RekapExport;
use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\Siswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class AbsensiController extends Controller
{
    
    public function index(Request $request)
    {
        // Tangkap apa yg diketik
        $keyword = $request->keyword;   // ni namanya
        $kelas = $request->kelas_id;    // -> kelasnya
        
        // Eader loading => query awal buat ambil data siswa & kelas
        $query = Absensi::with('siswa')->latest(); // latest = data pling baru 
        
        // filter keyword = Cara bacanya: "Jika user mengetik sesuatu di kolom cari ($keyword), tolong saring data Absensi yang punya relasi siswa (whereHas('siswa')), 
        // di mana di dalam tabel siswa tersebut nama-nya mirip atau nis-nya mirip dengan yang diketik user."
        if ($keyword) {
            $query->whereHas('siswa', function($q) use ($keyword) {     
                $q->where('nama', 'LIKE', "%$keyword%")
                ->orWhere('nis', 'LIKE', "%$keyword%");
            });
        }
    
        // filter kelas = Cara bacanya: "Jika user memilih kelas tertentu, tolong saring data Absensi yang punya siswa, di mana siswa tersebut berada di kelas_id yang dipilih."
        if($kelas) {
            $query->whereHas('siswa', function($q) use ($kelas) {
                 $q->where('kelas_id', $kelas);
            }); 
        }

            $absensi = $query->paginate(17);                      // brp nama perhalaman
            $kelas = Kelas::all();

        return view('sekolah.absensi.index', compact('absensi', 'kelas'));
        
    }

    public function create()
    {
        $siswa = Siswa::all();
        return view('sekolah.absensi.create', compact('siswa'));
    }

    public function store(Request $request)
    {
        // biar g keliatan error ny di user
        try {
            // ni manggil data array
            foreach ($request->status as $siswa_id => $status) {

                Absensi::Create([
                    'siswa_id' => $siswa_id,
                    'tanggal' => now(),
                    'status' => $status
                ]);
            } 
            return redirect()->route('absensi.index')->with('success', 'Absen berhasil');
            } catch (\Exception $e) {
                    Log::error($e->getMessage());                                               // kirim error ke log
                    return redirect()->back()->with('error', 'Pendaftaran Gagal');
        }
    }

    public function rekap(Request $request)
    {
        $bulan = $request->query('bulan',  date('m'));
        $tahun = $request->query('tahun', date('y'));

        $rekap = Absensi::select(
            'siswa_id',

            // maksudnya kalo status "Hadir" kasih nilai 1, klo bukan kasi 0
        DB::raw("SUM(CASE WHEN status = 'Hadir' THEN 1 ELSE 0 END) as total_hadir"),
        DB::raw("SUM(CASE WHEN status = 'Sakit' THEN 1 ELSE 0 END) as total_sakit"),
        DB::raw("SUM(CASE WHEN status = 'Izin' THEN 1 ELSE 0 END) as total_izin"),
        DB::raw("SUM(CASE WHEN status = 'Alpa' THEN 1 ELSE 0 END) as total_alpa")
        )
        ->whereMonth('tanggal', $bulan)
        ->whereYear('tanggal', $tahun)
        ->groupBy('siswa_id') // make groupBy biar dibikin per siswa, klo tanpa ini jdi 1 ntar
        ->with('siswa') // biar relasi ke tabel siswa
        ->get();

        return view('sekolah.absensi.rekap', compact('rekap', 'bulan', 'tahun'));
    }

    // ni excel semua
    public function excel () {
        return Excel::download(new AbsensiExport, 'absensi.xlsx');
    }
    // ni yg rekapan
    public function excelRekap () {
        return Excel::download(new RekapExport, 'rekap.xlsx');
    }

    public function pdf () {
        $data = Absensi::with('siswa')->get();
        $pdf = Pdf::loadView('sekolah.absensi.pdf', compact('data'));
        return $pdf->download('siswa.pdf');
    }

    public function pdfRekap () {
        $rekap = Absensi::select(
            'siswa_id',

            // maksudnya kalo status "Hadir" kasih nilai 1, klo bukan kasi 0
        DB::raw("SUM(CASE WHEN status = 'Hadir' THEN 1 ELSE 0 END) as total_hadir"),
        DB::raw("SUM(CASE WHEN status = 'Sakit' THEN 1 ELSE 0 END) as total_sakit"),
        DB::raw("SUM(CASE WHEN status = 'Izin' THEN 1 ELSE 0 END) as total_izin"),
        DB::raw("SUM(CASE WHEN status = 'Alpa' THEN 1 ELSE 0 END) as total_alpa")
        )
        // ->whereMonth('tanggal', $bulan)
        // ->whereYear('tanggal', $tahun)
        ->groupBy('siswa_id') // make groupBy biar dibikin per siswa, klo tanpa ini jdi 1 ntar
        ->with('siswa') // biar relasi ke tabel siswa
        ->get();

        $pdf = Pdf::loadView('sekolah.absensi.pdfRekap', compact('rekap'));
        return $pdf->download('pdfRekap.pdf');
    }

    public function edit($id)
    {
        $absensi    = Absensi::findOrFail($id);
        $siswa      = Siswa::all();
        return view('sekolah.absensi.edit', compact('absensi','siswa'));
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'status'    => 'required|string',
        ]);

        $absensi    = Absensi::findOrFail($id);
        $absensi->update($validate);

        return redirect()->route('absensi.index')->with('success', 'Absen diupdate');
    }

    public function destroy($id)
    {
        $absensi    = Absensi::findOrFail($id);
        $absensi->delete();

        return redirect()->route('absensi.index')->with('success','absen dihapus');
    }
}
