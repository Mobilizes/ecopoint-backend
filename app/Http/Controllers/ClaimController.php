<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Permintaan;
use App\Models\Transaksi;

class ClaimController extends Controller
{
    public function claim(Request $request)
    {
        $request->validate([
            'id_mesin' => 'required|uuid|exists:mesins,id',
            'kode_verifikasi' => 'required|integer|exists:permintaans,kode_verifikasi',
            'sampahs' => 'required|array|min:1',
            'sampahs.*.kategori_sampah' => 'required|in:plastik,kertas,kaca,organik,logam,lainnya',
            'sampahs.*.berat_sampah' => 'required|numeric|min:0.01',
            'sampahs.*.poin' => 'required|integer|min:1',
        ]);

        $user = Auth::user();

        $transaksi = new Transaksi();
        $transaksi->mesin_id = $request->mesin_id;
        $transaksi->user_id = $user->id;

        foreach ($request->sampahs as $sampah) {
            $user->sampahs()->create([
                'transaksi_id' => $transaksi->id,
                'kategori_sampah' => $sampah['kategori_sampah'],
                'berat_sampah' => $sampah['berat_sampah'],
                'poin' => $sampah['poin'],
            ]);
        }

        $permintaan = Permintaan::where('kode_verifikasi', $request->kode_verifikasi)
            ->where('mesin_id', $request->id_mesin)
            ->first();
        $permintaan->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengklaim sampah.',
            'data' => '',
        ], 201);
    }
}
