<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Override;

class StoreSiswaReq extends FormRequest
{
    // 1. ubah jadi true biar semua user diizinkan make form ini
    public function authorize(): bool
    {
        return true;
    }

    // 2. Logic baru, dipindah disini
    public function rules(): array
    {
        return [
            'nama'      => 'required',
            'nis'       => 'required|unique:siswas',
            'kelas_id'  => 'required|exists:kelas,id',
            'alamat'    => 'required'
        ];
    }

    #[Override]
    // klo mao make pesan disini
    public function messages(): array
    {
        return [
            'nis.required'      => 'NIS wajid diisi',
            'nis.unique'        => 'NIS udh dipake, ganti!!',
            'nama.required'     => 'Nama g boleh kosong'
        ];
    }
}
