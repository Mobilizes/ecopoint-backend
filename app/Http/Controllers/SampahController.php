<?php

namespace App\Http\Controllers;

use App\Models\Sampah;
use Illuminate\Http\Request;

class SampahController extends Controller
{
    public function index()
    {
        $sampah = Sampah::all();

        if ($sampah->isEmpty()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Daftar sampah kosong',
                'data' => [],
            ], 200);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Daftar sampah berhasil diambil',
            'data' => $sampah,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kategori_sampah'  => 'required|string|max:255',
            'berat_sampah'     => 'required|numeric',
            'poin'             => 'nullable|numeric',
        ]);

        $sampah = Sampah::create($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'Sampah berhasil ditambahkan',
            'data' => $sampah,
        ], 201);
    }

    public function show($id)
    {
        $sampah = Sampah::findOrFail($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Detail sampah ditemukan',
            'data' => $sampah,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'transaksi_id'     => 'sometimes|required|string|max:255',
            'kategori_sampah'  => 'sometimes|required|string|max:255',
            'berat_sampah'     => 'sometimes|required|numeric',
            'poin'             => 'sometimes|nullable|numeric',
        ]);

        $sampah = Sampah::findOrFail($id);
        $sampah->update($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'Sampah berhasil diperbarui',
            'data' => $sampah,
        ]);
    }

    public function destroy($id)
    {
        $sampah = Sampah::findOrFail($id);
        $sampah->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Sampah berhasil dihapus',
        ]);
    }
}
