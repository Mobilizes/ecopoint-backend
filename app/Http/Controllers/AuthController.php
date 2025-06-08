<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return response()->json([
                'message' => 'Login successful',
            ], 200);
        }

        return response()->json([
            'message' => 'Login failed'
        ], 300);
    }

    public function register(Request $request)
    {
        $credentials = $request->validate([
            'first_name' => ['required'],
            'last_name' => [],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required'],
            'confirm_password' => ['required', 'same:password'],
        ]);

        $user = new User();
        $user->first_name = $credentials['first_name'];
        $user->email = $credentials['email'];
        $user->password = Hash::make($credentials['password']);

        if ($credentials['last_name']) {
            $user->last_name = $credentials['last_name'];
        }

        $user->saveOrFail();

        return response()->json([
            'message' => 'Register successful',
        ], 200);
    }
}
