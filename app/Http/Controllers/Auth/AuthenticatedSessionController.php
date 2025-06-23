<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Login gagal',
                'data' => (object) [],
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Login sukses',
            'data' => [
                'user' => Auth::user(),
                'token' => Auth::user()->createToken('auth_token')->plainTextToken,
            ]
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        $accessToken = $request->attributes->get('accessToken');

        if ($accessToken) {
            $accessToken->delete();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Logout sukses',
            'data' => ''
        ]);
    }
}
