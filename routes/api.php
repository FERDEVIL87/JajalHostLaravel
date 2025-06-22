<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// Impor semua controller API yang dibutuhkan
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HardwareController;
use App\Http\Controllers\Api\PcPartController;
use App\Http\Controllers\CustomerServiceController;
use App\Http\Controllers\Api\ConsoleAndHandheldController;
use App\Http\Controllers\Api\LaptopController;
use App\Http\Controllers\Api\TechNewsController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\PcRakitanController;
use App\Http\Controllers\Api\SimulasiController;
use App\Http\Controllers\Api\CheckoutController;


// Rute publik (tidak perlu login)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// ==========================================================
// TAMBAHKAN RUTE INI
// ==========================================================
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);

// ==========================================================
// TAMBAHKAN RUTE INI
// ==========================================================
// Rute ini tidak akan dipanggil langsung oleh Vue, tetapi dibutuhkan oleh Laravel
// untuk membuat URL reset. Kita beri nama yang dibutuhkan: 'password.reset'.
Route::get('/reset-password/{token}', function (string $token) {
    // URL frontend Anda (ambil dari .env)
    $frontendUrl = config('app.frontend_url', 'http://localhost:5173');
    // Arahkan pengguna ke halaman reset password di Vue dengan membawa token
    return redirect($frontendUrl . '/reset-password?token=' . $token);
})->name('password.reset');
// ==========================================================

// Rute yang dilindungi (butuh token)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    // ... rute API lain yang butuh login
});

// ... Rute produk, dll ...
Route::get('/hardware', [HardwareController::class, 'index']);
Route::post('/checkout', [CheckoutController::class, 'store']);
Route::get('/console-and-handhelds', [ConsoleAndHandheldController::class, 'index']);
Route::get('/laptops', [LaptopController::class, 'index']);
Route::post('/customer-service', [CustomerServiceController::class, 'store']);
Route::get('/tech-news', [TechNewsController::class, 'index']);
Route::get('/banners', [BannerController::class, 'index']);
Route::get('/pc-rakitans', [PcRakitanController::class, 'index']);
Route::get('/simulasi-parts', [SimulasiController::class, 'getPcParts']);
Route::post('/order-status', [CheckoutController::class, 'status']);