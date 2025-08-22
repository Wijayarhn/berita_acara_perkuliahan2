<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\BapApiController;
use App\Http\Controllers\Api\MataKuliahApiController;
use App\Http\Controllers\Api\JadwalApiController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/login', [AuthController::class, 'apiLogin']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/bap', [BapApiController::class, 'index']);
    Route::post('/bap', [BapApiController::class, 'store']);
    Route::get('/bap/{id}', [BapApiController::class, 'show']);
    Route::put('/bap/{id}', [BapApiController::class, 'update']);
    Route::delete('/bap/{id}', [BapApiController::class, 'destroy']);

    Route::get('/bap/pending', [BapApiController::class, 'pending']);
    Route::post('/bap/{id}/approve', [BapApiController::class, 'approve']);
    Route::post('/bap/{id}/reject', [BapApiController::class, 'reject']);
    Route::get('/bap/approved', [BapApiController::class, 'approved']);

    Route::get('/bap/mahasiswa/list', [BapApiController::class, 'mahasiswaBaps']);
    Route::get('/bap/mahasiswa/{id}', [BapApiController::class, 'mahasiswaShow']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/matakuliah', [MataKuliahApiController::class, 'index']);
    Route::post('/matakuliah', [MataKuliahApiController::class, 'store']);
    Route::get('/matakuliah/{id}', [MataKuliahApiController::class, 'show']);
    Route::put('/matakuliah/{id}', [MataKuliahApiController::class, 'update']);
    Route::delete('/matakuliah/{id}', [MataKuliahApiController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/jadwal', [JadwalApiController::class, 'index']);
    Route::post('/jadwal', [JadwalApiController::class, 'store']);
    Route::get('/jadwal/{id}', [JadwalApiController::class, 'show']);
    Route::put('/jadwal/{id}', [JadwalApiController::class, 'update']);
    Route::delete('/jadwal/{id}', [JadwalApiController::class, 'destroy']);
});