<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function () {
    require __DIR__ . '/api/auth.php';

    Route::prefix('user')->group(function () {
        require __DIR__ . '/api/user.php';
    });
});

