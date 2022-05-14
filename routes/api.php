<?php

use App\Http\Controllers\API\ChatController;
use App\Http\Controllers\API\DataGuruController;
use App\Http\Controllers\API\HasilUJianController;
use App\Http\Controllers\API\JadwalController;
use App\Http\Controllers\API\KelasController;
use App\Http\Controllers\API\LaporController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function(){

    Route::get('fetch',[UserController::class, 'fetch']);

    Route::get('logout',[UserController::class, 'logout']);

    Route::get('jadwal/siswa',[JadwalController::class, 'allJadwalSiswa']);
    Route::get('jadwal/ujian',[JadwalController::class, 'allJadwalUjian']);

    Route::get('data/guru',[DataGuruController::class, 'all']);

    Route::get('hasil-ujian',[HasilUJianController::class, 'all']);

    Route::get('lapor',[LaporController::class, 'all']);

    Route::get('kelas',[KelasController::class, 'all']);

    // Chat Begin

    Route::get('chat',[ChatController::class, 'getGrubChat']);

    Route::get('chat/{id}',[ChatController::class, 'getMessage']);

    Route::post('chat/input',[ChatController::class, 'sendMessage']);


});
