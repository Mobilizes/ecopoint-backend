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
                    'status' => 'error',
                    'message' => 'Permintaan dengan token tersebut tidak ditemukan atau sudah tidak aktif.',
                ], 404);
            }

        $totalPoin = 0;
        if (is_array($permintaan->daftar_sampah)) {
            $sampahs = Sampah::whereIn('id', $permintaan->daftar_sampah)->get();

            foreach ($sampahs as $sampah) {
                $totalPoin += $sampah->poin ?? 0;
            }
        }

        $transaksi = Transaksi::create([
            'user_id' => $user->id,
            'mesin_id' => $permintaan->mesin_id,
            'total_poin' => $totalPoin,
        ]);
        if (is_array($permintaan->daftar_sampah)) {
            Sampah::whereIn('id', $permintaan->daftar_sampah)
                ->update(['transaksi_id' => $transaksi->id]);
        }

        $permintaan->status = 'confirmed';
        $permintaan->save();

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
