<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(['user' => Auth::user(), 'message' => "Hello!"]);
});

Route::get('/csrf-token', function () {
    return response()->json(['token' => csrf_token()]);
});

Route::middleware('web')->group(function () {
    Route::get('/login', function () {})->name('login')->middleware('web');
    Route::post('/login', [AuthController::class, 'login'])->middleware('web');

    Route::get('/register', function () {})->name('register')->middleware('web');
    Route::post('/register', [AuthController::class, 'register'])->middleware('web');
});

/* Route::resource('/user', UserController::class)->middleware('auth'); */
Route::get('/user', function () {
    return response()->json(Auth::user());
})->middleware('auth');
