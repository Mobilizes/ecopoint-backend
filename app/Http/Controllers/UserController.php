<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function me()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'User data berhasil dikirim',
            'data' => [
                'user' => Auth::user(),
                'token' => Auth::user()->createToken('auth_token')->plainTextToken,
            ],
        ], 200);
    }
}
