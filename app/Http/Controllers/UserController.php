<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function me()
    {
        $plain_token = Auth::user()->currentAccessToken()->id . '|';
        $plain_token = $plain_token . Auth::user()->currentAccessToken()->tokenable_id;

        return response()->json([
            'status' => 'success',
            'message' => 'User data berhasil dikirim',
            'data' => [
                "user" => Auth::user(),
                "token" => $plain_token,
            ],
        ], 200);
    }
}
