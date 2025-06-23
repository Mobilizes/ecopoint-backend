<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocialNetworkController extends Controller
{
    public function login(string $provider, Request $request)
    {
        if (!in_array($provider, array('google'))) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Provider tidak didukung',
                'data' => (object) [],
            ], 400);
        }

        $request->validate([
            'oauth_token' => 'required|string'
        ]);

        try {
            $providerUser = Socialite::driver($provider)
                ->stateless()
                ->userFromToken($request->oauth_token);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => `Gagal autentikasi dengan '{$provider}': ` . $e->getMessage(),
                'data' => (object) [],
            ], 401);
        }

        $user = User::where('provider_name', $provider)
            ->where('provider_id', $providerUser->id)->first();

        if (!$user) {
            $user = User::create([
                'nama_depan' => $providerUser->getName(),
                'email' => $providerUser->getEmail(),
                'link_foto' => $providerUser->getAvatar(),
                'provider_name' => $provider,
                'provider_id' => $providerUser->getId(),
            ]);
        }

        Auth::login($user);

        return response()->json([
            'status' => 'success',
            'message' => 'Login dengan `' . $provider . '` berhasil',
            'data' => [
                'user' => Auth::user(),
                'token' => Auth::user()->createToken('auth_token')->plainTextToken,
            ]
        ]);
    }
}
