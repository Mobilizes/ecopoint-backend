<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(['message' => csrf_token()]);
});

Route::get('/csrf-token', function () {
    return response()->json(['token' => csrf_token()]);
});

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::resource('user', UserController::class)->middleware('auth');
