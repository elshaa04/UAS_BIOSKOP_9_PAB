<?php

// database/migrations/2024_12_08_000001_create_payments_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id'); // Relasi ke tabel orders
            $table->decimal('amount', 10, 2); // Jumlah pembayaran
            $table->string('status')->default('pending'); // Status pembayaran
            $table->string('transaction_id')->nullable(); // ID transaksi dari sistem pembayaran
            $table->timestamps();

            // Foreign key
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}