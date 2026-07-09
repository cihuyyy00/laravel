<?php

namespace App\Http\Controllers;

use App\Exports\SiswaExport;
use App\Http\Requests\StoreSiswaReq;
use App\Imports\SiswaImport;
use App\Models\Kelas;
use App\Models\Siswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Prompts\Key;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{

    // 1. ni fungsi index asli/awal
    // public function index() {
    //     $siswa = Siswa::with('kelas')->get(); // diambaah with biar sekalian ambil tabel kelas didb
    //     return view('sekolah.siswa.index', compact('siswa'));  // compact tu bkin variabel di view
    // }

    // 2. klo ini fungsi index+search
    public function index(Request $request) {
        // ambil keyword dri form
        $keyword = $request->keyword;
        $kelas = $request->kelas_id;

        // query awal buat ambil kelas
        $query = Siswa::with('kelas');
        
        // filter keyword
        if ($keyword) {
            $query->where(function($q) use ($keyword) {
                $q->where('nama', 'LIKE', "%$keyword%")
                ->orWhere('nis', 'LIKE', "%$keyword%");
            });
        }
    
        // filter kelas
        if($kelas) {
            $query->where('kelas_id', $kelas);
        }

        $siswa = $query->paginate(10);                      // brp nama perhalaman
        $kelas = Kelas::all();
        return view('sekolah.siswa.index', compact('siswa', 'kelas'));
    }

    // fungsi ekpor file
    public function export() {
        return Excel::download(new SiswaExport, 'siswa.xlsx');
    }

    public function exportPdf() {
        $siswa = Siswa::all();
        $pdf = Pdf::loadView('sekolah.siswa.pdf', compact('siswa'));
        return $pdf->download('siswa.pdf');
    }


    // fungsi import
    public function import(Request $request) {
        $request->validate([
            'file'      => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new SiswaImport, $request->file('file'));

        return redirect()->back()->with('succes', 'Data berhasil diimpor');
    }


    public function create() {
        $kelas = Kelas::all();
        return view('sekolah.siswa.create', compact('kelas'));
    }

    public function store(StoreSiswaReq $request) {
        $validate = $request->validated();

        Siswa::create($validate);

    return redirect()->route('siswa.index')->with('success', 'Data berhasil ditambah');
    }


    public function edit($id) {
        $siswa = Siswa::findOrFail($id);
        $kelas = Kelas::all();
        return view('sekolah.siswa.edit', compact('siswa','kelas'));
    }

    // 5. fungsi update data
    public function update(Request $request, $id) {
        $siswa = Siswa::findOrFail($id); 
     
        $siswa->update($request->all());

        $siswa->save();

        return redirect()->route('siswa.index')->with('success', 'siswa berhasil diupdate');
    }


    // 6. fungsi hapus
    public function destroy($id) {
        $siswa = Siswa::findOrFail($id);

        $siswa->delete();

        return redirect()->route('siswa.index')->with('success', 'siswa berhasil dihapus');
    }
}
