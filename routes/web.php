<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

require __DIR__ . '/auth.php';

Route::prefix('user')->group(function () {
    require __DIR__ . '/user.php';
});
