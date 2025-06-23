<?php

namespace App\Http\Controllers;

use App\Models\Permintaan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PermintaanController extends Controller
{
    public function index()
    {
        $permintaans = Permintaan::all();

        if ($permintaans->isEmpty()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Tidak ada data permintaan',
                'data' => [],
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data permintaan berhasil diambil',
            'data' => $permintaans,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'mesin_id' => 'required|uuid|exists:mesins,id',
            'daftar_sampah'  => 'nullable|array',
            'daftar_sampah.*'=> 'uuid|exists:sampahs,id',
        ]);

        do {
            $kode = str_pad(mt_rand(0, 99999), 5, '0', STR_PAD_LEFT);
            $exists = Permintaan::where('status', 'pending')
                        ->where('kode_verifikasi', $kode)
                        ->exists();
        } while ($exists);
        $validated['kode_verifikasi'] = $kode;
        $validated['status'] = 'pending';

        $permintaan = Permintaan::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Permintaan berhasil dibuat',
            'data' => $permintaan,
        ], 201);
    }

    public function show($id)
    {
        $permintaan = Permintaan::findOrFail($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Detail permintaan ditemukan',
            'data' => $permintaan,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'mesin_id' => 'sometimes|required|uuid|exists:mesins,id',
        ]);

        $permintaan = Permintaan::findOrFail($id);
        $permintaan->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Permintaan berhasil diperbarui',
            'data' => $permintaan,
        ]);
    }

    public function destroy($id)
    {
        $permintaan = Permintaan::findOrFail($id);
        $permintaan->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Permintaan berhasil dihapus',
        ]);
    }
}
