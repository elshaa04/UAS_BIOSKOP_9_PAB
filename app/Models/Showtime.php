<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Showtime extends Model
{
    use HasFactory;

    protected $fillable = [
        'movie_id',
        'start_time',
        'available_seats',
    ];

    // Relasi ke model Movie
    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

     // Relasi ke model Order
     public function orders()
     {
         return $this->hasMany(Order::class);
     }
}
