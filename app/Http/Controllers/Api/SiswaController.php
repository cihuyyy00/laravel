<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSiswaReq;
use App\Http\Resources\SiswaResource;
use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index(Request $request) {

        // ni yg default
        // return response()->json([
        //     'status'    => 'success',
        //     'data'      => Siswa::all()
        // ]);

    $siswa = Siswa::query();

    if ($request->has('search')) {
        $siswa->where('nama', 'LIKE', '%'. $request->search . '%');
    }

    // ni yg resource buat nampilin data
    return SiswaResource::collection($siswa->paginate(10));  // paginate = batesin jdi 10 data, makenya di postman = siswa?page=2

        
    }

    public function show($id) {
        $siswa = Siswa::with('kelas')->find($id);

        if(!$siswa) {
            return response()->json([
                'status'    => 'error',
                'massage'   => 'Siswa dengan id ' . $id . ' tidak ditemukan'
            ], 404);
        }

        // ini biar bisa nampilin 1 data aja
        return new SiswaResource($siswa);

        // klo di sini yg cuma 1 ada notif suksesnya
    }

    // ===== Ini function/cara/method store lama
    // public function store(Request $request) {
    //     $data = $request->validate([
    //         'nama'      => 'required|string',
    //         'nis'       => 'required|string|unique:siswas,nis',
    //         'kelas_id'  => 'required|integer',
    //         'alamat'    => 'nullable|string'
    //     ]);

    //     $siswa = Siswa::create($data);

    //     return response()->json([
    //         'status'    => 'succes',
    //         'massage'   => 'Siswa berhasil ditambah',
    //         'data'      => new SiswaResource($siswa)
    //     ]);
    // }

    // klo mau update harus dikasih id, ex. api/siswa/3 bru ditulis mana yg mau diganti


    public function store(StoreSiswaReq $request) {
        $validate = $request->validated();

        $siswa = Siswa::create($validate);

        return response()->json([
            'message'   => 'Siswa berhasil ditambah',
            'data'      => $siswa
        ]);
    }

    public function update(Request $request, $id) {
        $siswa = Siswa::findOrFail($id);

        if(!$siswa) {
            return response()->json([
                'status'    => 'error',
                'massage'   => 'Siswa tidak ditemukan'
            ], 404);
        }
        
        $siswa->update($request->all());
        
        return response()->json([
            'status'    => 'success',
            'massage'   => 'Siswa berhasil diupdate',
            'data'      => new SiswaResource($siswa)
        ]);
    }

    public function destroy($id) {
        $siswa = Siswa::findOrFail($id);
        
        if(!$siswa) {
            return response()->json([
                'status'    => 'error',
                'massage'   => 'Siswa tidak ditemukan'
            ], 404);
        }

        $siswa->delete();

        return response()->json([
            'status'    => 'success',
            'massage'   => 'Siswa berhasil dihapus',
            'data'      => new SiswaResource($siswa)
        ]);
    }
}
