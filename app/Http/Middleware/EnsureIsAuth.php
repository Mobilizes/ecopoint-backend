<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;

class EnsureIsAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Akses dibatasi',
                'data' => 'Mohon login terlebih dahulu',
            ], 401);
        }

        return $next($request);
    }
}
