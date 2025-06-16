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
