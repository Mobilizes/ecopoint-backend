<?php

use App\Http\Middleware\EnsureIsAuth;
use App\Http\Controllers\UserController;

use Illuminate\Support\Facades\Route;

Route::get('/me', [UserController::class, 'me'])
    ->middleware(EnsureIsAuth::class)
    ->name('user.me');
