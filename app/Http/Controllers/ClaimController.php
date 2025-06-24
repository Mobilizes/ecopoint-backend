<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Permintaan;
use App\Models\Transaksi;
use App\Models\Sampah;

class ClaimController extends Controller
{
    public function claim(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'token' => ['required', 'regex:/^\d{5}$/'],
        ]);

        $permintaan = Permintaan::where('kode_verifikasi', $validated['token'])
            ->where('status', 'pending')
            ->first();

        if (!$permintaan) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Permintaan dengan token tersebut tidak ditemukan atau sudah tidak aktif.',
            ], 404);
        }

        $transaksi = Transaksi::create([
            'user_id' => $user->id,
            'mesin_id' => $permintaan->mesin_id,
        ]);

        Sampah::factory(2)->create([
            'transaksi_id' => $transaksi->id,
        ]);

        /* $permintaan->status = 'confirmed'; */
        /* $permintaan->save(); */

        $response = [
            'permintaan' => $permintaan,
            'transaksi' => $transaksi,
        ];

        return response()->json([
            'status' => 'success',
            'message' => 'Permintaan berhasil dikonfirmasi',
            'data' => $response,
        ]);
    }
}
