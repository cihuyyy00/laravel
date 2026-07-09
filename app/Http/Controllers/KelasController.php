<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index() {
        $kelas = Kelas::all();
        return view('sekolah.kelas.index', compact('kelas'));
    }

    public function show($id) {
        $kelas = Kelas::with('siswa')->findOrFail($id);
        return view('sekolah.kelas.show', compact('kelas'));
    }

    public function create() {
        return view('sekolah.kelas.create');
    }

    public function store(Request $request) {
        $request->validate([
            'nama_kelas'    => 'required',
            'wali_kelas'    => 'nullable'
        ]);

        Kelas::create($request->all());

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil ditambah');
    }

    public function edit ($id) {
        $kelas = Kelas::findOrFail($id);
        return view('sekolah.kelas.edit', compact('kelas'));
    }

    public function update(Request $request, $id) {
        $kelas = Kelas::findOrFail($id);

        $kelas->update($request->all());

        return redirect()->route('kelas.index')->with('success', 'Kelas berasil diedit');
    }
    
    public function destroy($id) {
        $kelas = Kelas::findOrFail($id);
        
        $kelas->delete();
        return redirect()->route('kelas.index')->with('success', 'Kelas berasil diapus');

    }
}
