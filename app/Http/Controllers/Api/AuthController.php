<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $validated = $request->validate([
            'showtime_id' => 'required|exists:showtimes,id',
            'seats_reserved' => 'required|integer|min:1',
            'payment_method' => 'required|string',
        ]);
        
        
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('YourAppName')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'token' => $token
            ]);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
