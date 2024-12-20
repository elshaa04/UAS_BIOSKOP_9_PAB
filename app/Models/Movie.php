<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    // Tentukan kolom yang bisa diisi
    protected $fillable = [
        'title', 
        'description', 
        'genre', 
        'poster'
    ];

     // Relasi ke model Showtime
     public function showtimes()
     {
         return $this->hasMany(Showtime::class);
     }
}