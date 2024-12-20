<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Showtime;
use App\Models\Movie;

class ShowtimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $movie1 = Movie::where('title', 'Avengers: Endgame')->first();
        $movie2 = Movie::where('title', 'The Lion King')->first();
        $movie3 = Movie::where('title', 'Inception')->first();

        // Menambahkan showtime untuk movie pertama
        Showtime::create([
            'movie_id' => $movie1->id,
            'start_time' => '2024-12-15 14:00:00',
            'available_seats' => 50,
        ]);

        Showtime::create([
            'movie_id' => $movie1->id,
            'start_time' => '2024-12-15 18:00:00',
            'available_seats' => 50,
        ]);

        // Menambahkan showtime untuk movie kedua
        Showtime::create([
            'movie_id' => $movie2->id,
            'start_time' => '2024-12-15 10:00:00',
            'available_seats' => 30,
        ]);

        Showtime::create([
            'movie_id' => $movie2->id,
            'start_time' => '2024-12-15 13:00:00',
            'available_seats' => 30,
        ]);

        // Menambahkan showtime untuk movie ketiga
        Showtime::create([
            'movie_id' => $movie3->id,
            'start_time' => '2024-12-15 16:00:00',
            'available_seats' => 40,
        ]);
    }
}
