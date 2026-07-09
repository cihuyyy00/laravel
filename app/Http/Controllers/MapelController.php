<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use App\Models\Guru;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mapel = Mapel::all();
        return view('sekolah.mapel.index', compact('mapel'));
    }


    public function create()
    {
        return view('sekolah.mapel.create');
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'nama_mapel'        => 'required',
            'kode_mapel'        => 'required|unique:mapels',
            'jam_pel'           => 'nullable'
        ]);

        Mapel::create($request->all());

        return redirect()->route('mapel.index')->with('success', 'Data berhasil ditambah');
    }

    public function addGuru($id) {
        $mapel = Mapel::findOrFail($id);
        $guru = Guru::all();

        return view('sekolah.mapel.addGuru', compact('mapel', 'guru'));
    }

    public function storeGuru(Request $request, $id){
        $mapel = Mapel::findOrFail($id);

        // simpen relasi guru-mapel
        $mapel->gurus()->sync($request->guru);

        return redirect()->route('mapel.show', $mapel->id)->with('success', 'Guru berhasil ditambah');
    }

   
    public function show($id)
    {
        $mapel = Mapel::with('gurus')->findOrFail($id);
        return view('sekolah.mapel.show', compact('mapel'));
    }


    public function edit($id)
    {
        $mapel = Mapel::findOrFail($id);
        return view('sekolah.mapel.edit', compact('mapel'));
    }

  
    public function update(Request $request, $id)
    {
        $mapel = Mapel::findOrFail($id);

        $mapel->update($request->all());

        return redirect()->route('mapel.index')->with('success','Data diedit');
    }
    
    
    public function destroy($id)
    {
        $mapel = Mapel::findOrFail($id);
        
        $mapel->delete();
        return redirect()->route('mapel.index')->with('success','Data dihapus');
        
    }
}
