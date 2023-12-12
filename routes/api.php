<?php

use App\Http\Controllers\CutiController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('auth/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [UserController::class, 'fetch']);
    Route::post('/auth/logout', [UserController::class, 'logout']);

    Route::get('/cuti', [CutiController::class, 'index']);
    Route::post('/cuti', [CutiController::class, 'store']);
    Route::get('/cuti/{id}', [CutiController::class, 'show']);
    Route::put('/cuti/{id}', [CutiController::class, 'updatecuti']);

    Route::get('/dokumen', [DokumenController::class, 'index']);
    Route::post('/dokumen/upload', [DokumenController::class, 'upload']);
    Route::get('/dokumen/{id}', [DokumenController::class, 'show']);

    Route::apiResource('dokumen', 'DokumenController');
    Route::apiResource('cuti', 'CutiController');
    Route::apiResource('karyawan', 'KaryawanController');
});