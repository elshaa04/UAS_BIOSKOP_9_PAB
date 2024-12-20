<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;

class MovieController extends Controller
{
    // Menampilkan daftar film
    public function index()
    {
        $movies = Movie::all();
        return response()->json([
            'message' => 'Movies retrieved successfully',
            'data' => $movies
        ]);
    }

    // Menambahkan film baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'genre' => 'required|string|max:100',
            'poster' => 'nullable|string',
        ]);

        $movie = Movie::create($request->all());
        return response()->json([
            'message' => 'Movie created successfully',
            'data' => $movie
        ], 201);
    }

    // Menampilkan detail film
    public function show($id)
    {
        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json(['message' => 'Movie not found'], 404);
        }

        return response()->json([
            'message' => 'Movie retrieved successfully',
            'data' => $movie
        ]);
    }

    // Memperbarui film
    public function update(Request $request, $id)
    {
        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json(['message' => 'Movie not found'], 404);
        }

        $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'genre' => 'sometimes|string|max:100',
            'poster' => 'nullable|string',
        ]);

        $movie->update($request->all());
        return response()->json([
            'message' => 'Movie updated successfully',
            'data' => $movie
        ]);
    }

    // Menghapus film
    public function destroy($id)
    {
        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json(['message' => 'Movie not found'], 404);
        }

        $movie->delete();
        return response()->json(['message' => 'Movie deleted successfully']);
    }
}