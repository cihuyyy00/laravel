<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'user_id'];

    // 1 post dimiliki 1 user 
    public function user() {
        return $this->belongsTo(User::class);      // belongsTo -> relasi ke pemilik post
    }
}
