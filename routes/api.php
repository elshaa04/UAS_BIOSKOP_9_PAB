<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\ShowtimeController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PaymentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', function () {
    return view('welcome'); // Pastikan ada file welcome.blade.php di folder resources/views
});
Route::middleware('api')->group(function () {
    Route::post('/auth/login', [AuthController::class, 'login']);
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->post('/orders', [OrderController::class, 'store']);

Route::post('/auth/login', [AuthController::class, 'login']);

Route::get('/movies', [MovieController::class, 'index']); // Menampilkan daftar film **
Route::post('/movies', [MovieController::class, 'store']); // Menambahkan film baru 
Route::get('/movies/{id}', [MovieController::class, 'show']); // Menampilkan detail film
Route::post('/movies/{id}', [MovieController::class, 'update']); // Memperbarui film
Route::delete('/movies/{id}', [MovieController::class, 'destroy']); // Menghapus film

Route::get('/showtimes', [ShowtimeController::class, 'index']); // Menampilkan semua jadwal tayang **
Route::post('/showtimes', [ShowtimeController::class, 'store']); // Menambahkan jadwal tayang baru
Route::get('/showtimes/{id}', [ShowtimeController::class, 'show']); // Menampilkan detail jadwal tayang
Route::post('/showtimes/{id}', [ShowtimeController::class, 'update']); // Memperbarui jadwal tayang
Route::delete('/showtimes/{id}', [ShowtimeController::class, 'destroy']); // Menghapus jadwal tayang

Route::get('/orders', [OrderController::class, 'index']); // Menampilkan semua pemesanan (admin) **
Route::post('/orders', [OrderController::class, 'store']); // Membuat pemesanan baru **
Route::get('/orders/{id}', [OrderController::class, 'show']); // Menampilkan status pemesanan
Route::post('/orders/{id}/status', [OrderController::class, 'updateStatus']); // Memperbarui status pemesanan
Route::delete('/orders/{id}', [OrderController::class, 'destroy']); // Menghapus pemesanan

Route::post('/payments', [PaymentController::class, 'processPayment']); // Route untuk memproses pembayaran
Route::get('/payments/{id}', [PaymentController::class, 'getPaymentStatus']); // Route untuk mendapatkan status pembayaran

