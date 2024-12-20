<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Showtime;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Menampilkan semua pemesanan (untuk admin)
    public function index()
    {
        // Hanya admin yang dapat melihat semua pemesanan
        $this->authorize('viewAny', Order::class);

        $orders = Order::with('showtime.movie', 'user')->get(); // Mengambil semua pemesanan dengan showtime dan movie
        return response()->json([
            'message' => 'Orders retrieved successfully',
            'data' => $orders
        ]);
    }

    // Membuat pemesanan baru
    public function store(Request $request)
{
    // Validasi input
    $validated = $request->validate([
        'showtime_id' => 'required|exists:showtimes,id',
        'seats_reserved' => 'required|integer|min:1',
        'payment_method' => 'required|string',
    ]);

    // Ambil showtime berdasarkan ID
    $showtime = Showtime::findOrFail($validated['showtime_id']);

    // Cek ketersediaan kursi
    if ($showtime->available_seats < $validated['seats_reserved']) {
        return response()->json(['message' => 'Not enough seats available'], 400);
    }

    // Ambil user_id dari pengguna yang terautentikasi
    $user_id = auth()->id();  // Mendapatkan ID pengguna yang sedang login

    if (!$user_id) {
        return response()->json(['message' => 'User is not authenticated'], 401);
    }

    // Buat pesanan dengan user_id yang terautentikasi
    $order = Order::create([
        'user_id' => $user_id,  // Menyimpan ID pengguna yang sedang login
        'showtime_id' => $validated['showtime_id'],
        'seats_reserved' => $validated['seats_reserved'],
        'payment_method' => $validated['payment_method'],
        'status' => 'pending',
    ]);

    // Kurangi kursi yang tersedia
    $showtime->available_seats -= $validated['seats_reserved'];
    $showtime->save();

    return response()->json([
        'message' => 'Order created successfully',
        'order' => $order
    ], 201);
}

    // Melihat status pemesanan berdasarkan ID
    public function show($id)
    {
        $order = Order::with('showtime.movie', 'user')->find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json([
            'message' => 'Order retrieved successfully',
            'data' => $order
        ]);
    }

    // Memperbarui status pemesanan (untuk admin)
    public function updateStatus(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'status' => 'required|string|in:pending,confirmed,canceled',
        ]);

        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Hanya admin yang dapat memperbarui status pemesanan
        $this->authorize('update', $order);

        $order->update([
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => 'Order status updated successfully',
            'data' => $order
        ]);
    }

    // Menghapus pemesanan
    public function destroy($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Hanya pengguna yang dapat menghapus pemesanan mereka sendiri
        $this->authorize('delete', $order);

        // Mengembalikan kursi yang dibatalkan
        $showtime = $order->showtime;
        $showtime->increment('available_seats', $order->seats_reserved);

        $order->delete();

        return response()->json(['message' => 'Order deleted successfully']);
    }
}
