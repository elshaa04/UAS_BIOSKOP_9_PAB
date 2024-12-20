<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'showtime_id',
        'seats_reserved',
        'payment_method',
        'status',
    ];

    // Relasi dengan model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi dengan model Showtime
    public function showtime()
    {
        return $this->belongsTo(Showtime::class);
    }
}
