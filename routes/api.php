<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware('guest');
Route::post('/register', [AuthenticatedSessionController::class, 'store'])->middleware('guest');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
    Route::get('/me', [AuthenticatedSessionController::class, 'user']);
});