<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Relasi ke tabel users
            $table->unsignedBigInteger('showtime_id'); // Relasi ke tabel showtimes
            $table->integer('seats_reserved'); // Jumlah kursi yang dipesan
            $table->string('payment_method'); // Metode pembayaran (misalnya: "Credit Card", "PayPal", dll)
            $table->string('status')->default('pending'); // Status pemesanan (pending, confirmed, canceled, dll)
            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('showtime_id')->references('id')->on('showtimes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
