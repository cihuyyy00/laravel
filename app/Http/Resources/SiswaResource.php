<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SiswaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'nama'          => $this->nama,
            'nis'           => $this->nis,
            'alamat'        => $this->alamat,
            'kelas_id'      => $this->kelas->nama_kelas ?? null
        ];
    }

    // ===> buat nampilin status
    public function with($request)
    {
        return [
            'status'    => 'success',
            'message'   => 'Data siswa berhasil diambil'
        ];
    }
}
