<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): JsonResponse
    {
        $request->authenticate();

        $user = User::where('email', $request->email)->first();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil masuk',
            'data' => [
                'token' => $user->createToken('auth_token')->plainTextToken,
                'user' => $user,
            ],
        ], 200);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): JsonResponse
    {
        Auth::guard('web')->logout();

        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil keluar'
        ], 200);
    }

    /**
     * Get the user authenticated by the session.
     */
    public function user(Request $request): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => 'User retrieved successfully',
            'data' => $request->user(),
        ], 200);
    }
}
