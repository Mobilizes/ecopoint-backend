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
        try {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required']
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Login gagal',
                'data' => $e->errors(),
            ], 422);
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return response()->json([
                'message' => 'Login sukses',
                'data' => [
                    'user' => Auth::user(),
                    'token' => $request->session()->getId(),
                ]
            ]);
        }

        return response()->json([
            'message' => 'Login gagal',
            'data' => 'Kredensial tidak ditemukan',
        ], 401);
    }

    public function register(Request $request)
    {
        $credentials = $request->validate([
            'nama_depan' => ['required'],
            'nama_belakang' => [],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required'],
            'confirm_password' => ['required', 'same:password'],
        ]);

        $user = new User();
        $user->nama_depan = $credentials['nama_depan'];
        $user->email = $credentials['email'];
        $user->password = Hash::make($credentials['password']);

        if ($credentials['nama_belakang']) {
            $user->nama_belakang = $credentials['nama_belakang'];
        }

        $user->saveOrFail();

        return response()->json([
            'message' => 'Register successful',
        ], 200);
    }
}
