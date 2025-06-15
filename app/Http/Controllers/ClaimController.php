<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Permintaan;
use App\Models\Transaksi;

class ClaimController extends Controller
{
    public function claims(Request $request)
    {
        $request->validate([
            'id_mesin' => 'required|uuid|exists:mesins,id',
            'kode_verifikasi' => 'required|integer|exists:permintaans,kode_verifikasi',
            'sampahs' => 'required|array|min:1',
            'sampahs.*.kategori_sampah' => 'required|in:plastik,kertas,kaca,organik,logam,lainnya',
            'sampahs.*.berat_sampah' => 'required|numeric|min:0.01',
            'sampahs.*.poin' => 'required|integer|min:1',
        ], [
            'id_mesin.required' => 'Mesin wajib diisi.',
            'id_mesin.uuid' => 'Format ID tidak valid',
            'id_mesin.exists' => 'Mesin tidak valid.',

            'kode_verifikasi.required' => 'Kode verifikasi wajib diisi.',
            'kode_verifikasi.integer' => 'Kode verifikasi harus berupa angka.',
            'kode_verifikasi.exists' => 'Kode verifikasi tidak valid.',

            'sampahs.required' => 'Data sampah harus diisi.',
            'sampahs.array' => 'Format data sampah tidak valid.',
            'sampahs.min' => 'Minimal satu data sampah harus diisi.',

            'sampahs.*.kategori_sampah.required' => 'Kategori sampah wajib diisi.',
            'sampahs.*.kategori_sampah.in' => 'Kategori sampah tidak valid.',

            'sampahs.*.berat_sampah.required' => 'Berat sampah wajib diisi.',
            'sampahs.*.berat_sampah.numeric' => 'Berat sampah harus berupa angka.',
            'sampahs.*.berat_sampah.min' => 'Berat sampah minimal 0.01.',

            'sampahs.*.poin.required' => 'Poin wajib diisi.',
            'sampahs.*.poin.integer' => 'Poin harus berupa angka bulat.',
            'sampahs.*.poin.min' => 'Poin minimal 1.',
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
