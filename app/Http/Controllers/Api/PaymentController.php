<?php

// app/Http/Controllers/PaymentController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function processPayment(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'amount' => 'required|numeric',
        ]);

        // Simulasi pemrosesan pembayaran
        // Di sini Anda dapat mengintegrasikan dengan gateway pembayaran
        $paymentSuccess = true; // Ganti dengan logika pemrosesan pembayaran yang sebenarnya
        $transactionId = 'TXN123456'; // ID transaksi dari sistem pembayaran

        if ($paymentSuccess) {
            // Simpan informasi pembayaran
            $payment = Payment::create([
                'order_id' => $validated['order_id'],
                'amount' => $validated['amount'],
                'status' => 'completed',
                'transaction_id' => $transactionId,
            ]);

            return response()->json([
                'status' => 'completed',
                'message' => 'Pembayaran berhasil!',
                'transaction_id' => $transactionId,
                'amount' => $validated['amount'],
                'timestamp' => now(),
                'order_details' => [
                    'order_id' => $validated['order_id'],
                    'movie' => Order::find($validated['order_id'])->movie_title,
                ],
            ], 201);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Pembayaran gagal! Silakan coba lagi.',
                'amount' => $validated['amount'],
                'timestamp' => now(),
                'order_details' => [
                    'order_id' => $validated['order_id'],
                    'movie' => Order::find($validated['order_id'])->movie_title,
                ],
            ], 400);
        }
    }

    public function getPaymentStatus($id)
    {
        $payment = Payment::findOrFail($id);
        return response()->json($payment);
    }
}