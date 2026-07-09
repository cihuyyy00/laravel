<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_mapel',
        'nama_mapel',
        'jam_pel'
    ];

    public function gurus() {
        return $this->belongsToMany(Guru::class, 'guru_mapel');
    }
}
