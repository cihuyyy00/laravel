<?php

use App\Http\Controllers\Api\AbsensiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RekapAbsenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SiswaController;
use App\Http\Controllers\Api\UserController;

use function PHPUnit\Framework\returnArgument;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// >>>>>>>>>> PUBLIK <<<<<<<<<<<
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/regis', [AuthController::class, 'register']);


// ================ HARUS LOGIN ===================
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    Route::get('/me', function (Request $request) {
        return $request->user();
        });    
        
        
    // ==================================================================
    // =========== SECURITY ALERT / MIDDLEWARE/AUTHORIZATION ============
    // ==================================================================
    
    // rekapAbsens
    Route::get('/rekap-absen', [RekapAbsenController::class, 'index']);
        
        // ADMIN
    Route::middleware('role:admin')->group(function () {
        Route::apiResource('user', UserController::class);
        Route::apiResource('siswa',SiswaController::class);
        Route::apiResource('absensi', AbsensiController::class)->names('api.absensi');
        Route::get('/user', [UserController::class, 'index']);
    });
        
    // USERRR
    Route::middleware('role:user')->group(function () {
    
    // Absensi 
        Route::get('/absensi', [AbsensiController::class, 'index']);
        Route::get('/absensi/{$id}', [AbsensiController::class, 'show']);
        
    // Siswa
        Route::get('/siswa', [SiswaController::class, 'index']);
        Route::get('/siswa/{$id}', [SiswaController::class, 'show']);

    });
    
    
});
    
    
