<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AbsenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'tanggal'   => $this->tanggal,
            'status'    => $this->status,
            'siswa'     => new SiswaResource($this->whenLoaded('siswa'))
        ];
    }

    public function with(Request $request)
    {
        return [
            'status'    => 'success',
            'message'   => 'Data berhasil diambil'
        ];
    }
}
