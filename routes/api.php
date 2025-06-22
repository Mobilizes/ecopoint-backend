<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\HadiahController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\PenukaranController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\SampahController;
use App\Http\Controllers\PermintaanController;
use App\Http\Controllers\MesinController;

Route::middleware('ensure.guest')->group(function () {
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

Route::middleware('ensure.auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
    Route::get('/me', [UserController::class, 'me']);

    Route::get('/penukaran', [PenukaranController::class, 'index']);
    Route::get('/penukaran/{id}', [PenukaranController::class, 'show']);
    Route::get('/penukaran/hadiah/{id}', [PenukaranController::class, 'showHadiah']);

    Route::get('/poin', [TransaksiController::class, 'index']);
    Route::get('/poin/{id}', [TransaksiController::class, 'show']);

    Route::post('/claim', [ClaimController::class, 'claim']);

    Route::get('/cart', [CartController::class, 'show']);
    Route::post('/cart/add', [CartController::class, 'store']);
    Route::post('/cart/remove', [CartController::class, 'destroy']);
    Route::post('/cart/checkout', [CartController::class, 'checkout']);
});

Route::get('/hadiah', [HadiahController::class, 'index']);
Route::get('/hadiah/search', [HadiahController::class, 'search']);
Route::get('/hadiah/{id}', [HadiahController::class, 'show']);

Route::get('/leaderboard', [LeaderboardController::class, 'index']);

Route::get('/sampah', [SampahController::class, 'index']);
Route::get('/sampah/{id}', [SampahController::class, 'show']);
Route::post('/sampah', [SampahController::class, 'store']);
Route::put('/sampah/{id}', [SampahController::class, 'update']);
Route::delete('/sampah/{id}', [SampahController::class, 'destroy']);

Route::get('/permintaan', [PermintaanController::class, 'index']);
Route::get('/permintaan/{id}', [PermintaanController::class, 'show']);
Route::post('/permintaan', [PermintaanController::class, 'store']);
Route::put('/permintaan/{id}', [PermintaanController::class, 'update']);
Route::delete('/permintaan/{id}', [PermintaanController::class, 'destroy']);

Route::get('/mesin', [MesinController::class, 'index']);
Route::get('/mesin/{id}', [MesinController::class, 'show']);
Route::post('/mesin', [MesinController::class, 'store']);
Route::put('/mesin/{id}', [MesinController::class, 'update']);
Route::delete('/mesin/{id}', [MesinController::class, 'destroy']);
