<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Movie;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Movie::create([
            'title' => 'Avengers: Endgame',
            'description' => 'The final battle for the universe.',
            'genre' => 'Action, Sci-Fi',
            'poster' => 'https://example.com/avengers-poster.jpg',
        ]);

        Movie::create([
            'title' => 'The Lion King',
            'description' => 'The king of the jungle learns what it means to be a true leader.',
            'genre' => 'Animation, Family',
            'poster' => 'https://example.com/lion-king-poster.jpg',
        ]);

        Movie::create([
            'title' => 'Inception',
            'description' => 'A thief who steals corporate secrets through the use of dream-sharing technology.',
            'genre' => 'Sci-Fi, Thriller',
            'poster' => 'https://example.com/inception-poster.jpg',
        ]);
    }
}
