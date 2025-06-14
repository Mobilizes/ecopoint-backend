<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use App\Http\Middleware\EnsureLogin;
use App\Http\Middleware\EnsureIsAuth;
use App\Http\Middleware\EnsureIsGuest;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'ensure.login' => EnsureLogin::class,
            'ensure.auth' => EnsureIsAuth::class,
            'ensure.guest' => EnsureIsGuest::class,
        ]);

        $middleware->append(EnsureLogin::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
