<?php

use App\Http\Controllers\LeaderboardController;

Route::get('leaderboard', [LeaderboardController::class, 'index'])->middleware('auth');
