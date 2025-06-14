<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LeaderboardController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Permintaan;

Route::middleware('ensure.guest')->group(function () {
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

Route::middleware('ensure.auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
    Route::get('/me', [UserController::class, 'me']);

    Route::prefix('/history')->group(function () {
        Route::get('/poin', [HistoryController::class, 'poin']);
        Route::get('/penukaran', [HistoryController::class, 'penukaran']);
    });

    Route::post('/claim', [ClaimController::class, 'claims']);
});

Route::get('/leaderboard', [LeaderboardController::class, 'index']);
