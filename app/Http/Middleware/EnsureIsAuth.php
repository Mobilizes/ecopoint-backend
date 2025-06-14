<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Sanctum\PersonalAccessToken;

use Illuminate\Support\Facades\Auth;

class EnsureIsAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Akses dibatasi',
                'data' => 'Mohon login terlebih dahulu',
            ], 401);
        }

        $accessToken = PersonalAccessToken::findToken($token);

        if (!$accessToken) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Akses dibatasi',
                'data' => "Token tidak valid",
            ], 401);
        }


        $user = $accessToken->tokenable;

        $request->setUserResolver(fn() => $user);
        Auth::setUser($user);

        $request->attributes->set('accessToken', $accessToken);

        return $next($request);
    }
}
