<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nis',
        'kelas_id',
        'alamat',
    ];

    public function kelas() {
        return $this->belongsTo(Kelas::class);
    }

    public function absensi() {
        return $this->belongsTo(Absensi::class);
    }

    // Mutaator => Bkin nama inputan selalu rapi
    protected function nama(): Attribute {
        return Attribute::make (
            set: fn (string $value) => ucwords(strtolower($value)),
        );
    }
}
