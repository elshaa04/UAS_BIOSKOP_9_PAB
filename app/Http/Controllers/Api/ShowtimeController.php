<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Showtime;
use App\Models\Movie;

class ShowtimeController extends Controller
{
    // Menampilkan semua jadwal tayang
    public function index()
    {
        $showtimes = Showtime::with('movie')->get(); // Mengambil jadwal tayang beserta informasi film
        return response()->json([
            'message' => 'Showtimes retrieved successfully',
            'data' => $showtimes
        ]);
    }

    // Menambahkan jadwal tayang baru
    public function store(Request $request)
    {
        $request->validate([
            'movie_id' => 'required|exists:movies,id', // Menyaring film yang valid
            'start_time' => 'required|date_format:Y-m-d H:i:s',
            'available_seats' => 'required|integer|min:1',
        ]);

        // Membuat jadwal tayang baru
        $showtime = Showtime::create($request->all());

        return response()->json([
            'message' => 'Showtime created successfully',
            'data' => $showtime
        ], 201);
    }

    // Menampilkan detail jadwal tayang berdasarkan ID
    public function show($id)
    {
        $showtime = Showtime::with('movie')->find($id);

        if (!$showtime) {
            return response()->json(['message' => 'Showtime not found'], 404);
        }

        return response()->json([
            'message' => 'Showtime retrieved successfully',
            'data' => $showtime
        ]);
    }

    // Memperbarui jadwal tayang
    public function update(Request $request, $id)
    {
        $showtime = Showtime::find($id);

        if (!$showtime) {
            return response()->json(['message' => 'Showtime not found'], 404);
        }

        $request->validate([
            'movie_id' => 'sometimes|exists:movies,id',
            'start_time' => 'sometimes|date_format:Y-m-d H:i:s',
            'available_seats' => 'sometimes|integer|min:1',
        ]);

        $showtime->update($request->all());

        return response()->json([
            'message' => 'Showtime updated successfully',
            'data' => $showtime
        ]);
    }

    // Menghapus jadwal tayang
    public function destroy($id)
    {
        $showtime = Showtime::find($id);

        if (!$showtime) {
            return response()->json(['message' => 'Showtime not found'], 404);
        }

        $showtime->delete();

        return response()->json(['message' => 'Showtime deleted successfully']);
    }
}
