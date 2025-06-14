<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;

class EnsureIsGuest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (request()->bearerToken()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Akses dibatas',
                'data' => 'Mohon logout terlebih dahulu',
            ], 401);
        }

        return $next($request);
    }
}
