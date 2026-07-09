<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $fillable = ([
        'siswa_id',
        'tanggal',
        'status'
    ]);

    public function siswa() {
        return $this->belongsTo(Siswa::class);
    }

    // Accesor => ubah format tgl
    protected function tanggal(): Attribute {
        return Attribute::make(
            get: fn (string $value) => Carbon::parse($value)->translatedFormat('d F Y'),
        );
    }
}
