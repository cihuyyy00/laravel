<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Mapel;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    public function index() {
        $guru = Guru::all();
        return view('sekolah.guru.index', compact('guru'));
    }

    public function create() {
        $kelas = Kelas::all();
        return view('sekolah.guru.create', compact('kelas'));
    }

    public function store(Request $request) {
        $request->validate([
            'nama'          => 'required',
            'nip'           => 'required|unique:gurus',
            'mapel_utama'   => 'required',
            'pw'            => 'required',
            'role'          => 'nullable'
        ]);

    Guru::create(['nama'          => $request->nama,
                  'nip'           => $request->nip,
                  'mapel_utama'   => $request->mapel_utama,
                  'role'          => $request->role,
                  'password'      => Hash::make($request->password)
                 ]);

    return redirect()->route('guru.index')->with('succes', 'data berhasil ditambah');
    }

    public function show($id) {
        // ambil data guru
        $guru = Guru::with('mapels')->findOrFail($id);
        return view('sekolah.guru.show', compact('guru'));
    }

    // mapel tambhan
    public function addMapel($id) {
        $guru = Guru::findOrFail($id);
        $mapels = Mapel::all();

        return view('sekolah.guru.addMapel', compact('guru', 'mapels'));
    }

    public function storeMapel(Request $request, $id) {
        $guru = Guru::findOrFail($id);

        // simpen relasi guru-mapel
        $guru->mapels()->sync($request->mapel);

        return redirect()->route('guru.show', $guru->id)->with('success', 'Mapel berhasil ditambah');
    }


    public function edit($id) {
        $guru = Guru::findOrFail($id);
        return view('sekolah.guru.edit', compact('guru'));
    }

    // 5. fungsi update data
    public function update(Request $request, $id) {
        $guru = Guru::findOrFail($id); 
     
        $guru->update([
            'nama'          => $request->nama,
            'nip'           => $request->nip,
            'mapel_utama'   => $request->mapel_utama,
            'password'      => Hash::make($request->password),
            'role'          => $request->role
        ]);

        return redirect()->route('guru.index')->with('success', 'guru berhasil diupdate');
    }

    // 6. fungsi hapus
    public function destroy($id) {
        $guru = Guru::findOrFail($id);

        $guru->delete();

        return redirect()->route('guru.index')->with('success', 'guru berhasil dihapus');
    }
}

