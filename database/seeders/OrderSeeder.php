<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;
use App\Models\Showtime;
use Illuminate\Support\Facades\Auth;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Memastikan ada pengguna yang tersedia
        $user1 = User::first(); // Asumsi pengguna pertama sudah ada
        if (!$user1) {
            $this->command->error('User not found! Please make sure to seed User data first.');
            return;
        }

        // Memastikan ada showtime yang tersedia
        $showtime1 = Showtime::where('start_time', '2024-12-15 14:00:00')->first();
        $showtime2 = Showtime::where('start_time', '2024-12-15 18:00:00')->first();

        if (!$showtime1 || !$showtime2) {
            $this->command->error('Showtimes not found! Please make sure to seed Showtime data first.');
            return;
        }

        // Membuat pemesanan jika pengguna dan showtime ditemukan
        Order::create([
            'user_id' => $user1->id,
            'showtime_id' => $showtime1->id,
            'seats_reserved' => 2,
            'payment_method' => 'Credit Card',
            'status' => 'confirmed',
        ]);

        Order::create([
            'user_id' => $user1->id,
            'showtime_id' => $showtime2->id,
            'seats_reserved' => 3,
            'payment_method' => 'PayPal',
            'status' => 'pending',
        ]);
    }
}
