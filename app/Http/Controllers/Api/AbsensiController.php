<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAbsensiReq;
use App\Http\Resources\AbsenResource;
use App\Models\Absensi;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index(Request $request) {
    $absensi = Absensi::query()->with('siswa')->get();

    if ($request->has('search')) {
        $absensi->where('nama', 'LIKE', '%' . $request->search . '%');
    }

    return AbsenResource::collection($absensi);
    }

    public function show($id) {
        $absensi = Absensi::with('siswa')->findOrFail($id);

        if(!$absensi) {
            return response()->json([
                'status'    => 'error',
                'message'   => 'Data ga ketemu'
            ], 404);
        }
        
        return response()->json([
            'status'    => 'success',
            'data'      => $absensi
        ]);
    }

    public function store(StoreAbsensiReq $request) {
        $data = $request->validated();

        $absensi = Absensi::create($data);
        return response()->json([
            'status'    => 'success',
            'message'   => 'Data berhasil ditambah',
            'data'      => $absensi
        ]);
    }

    public function update(Request $request, $id) {
        $data = Absensi::findOrFail($id);

        if (!$data) {
            return response()->json([
                'status'    => 'error',
                'message'   => 'Data g ketemu'
            ], 404);
        }

        $data->update($request->all());
        return response()->json([
            'status'    => 'succes',
            'message'   => 'Data berhasildi',
            'data'      => $data
        ]);
    }

    public function destroy($id) {
        $data = Absensi::findOrFail($id);

        if(!$data)  {
            return response()->json([
                'status'    => 'error',
                'message'   => 'Data g ketemu'
            ], 404);
        }

        $data = Absensi::destroy($data);
        return response()->json([
            'status'    => 'success',
            'message'   => 'Data berhasil dihapus',
            'data'  => $data
        ]);
    }
    
}
