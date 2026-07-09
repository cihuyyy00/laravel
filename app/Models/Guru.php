<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nip',
        'mapel_utama',
        'password',
        'role'
    ];

    public function mapels() {
        return $this->belongsToMany(Mapel::class, 'guru_mapel');
    }
}
