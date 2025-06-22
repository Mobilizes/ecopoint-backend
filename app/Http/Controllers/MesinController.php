<?php

namespace App\Http\Controllers;

use App\Models\Mesin;
use Illuminate\Http\Request;

class MesinController extends Controller
{
    public function index()
    {
        $mesins = Mesin::all();

        return response()->json([
            'status' => 'success',
            'message' => 'Daftar mesin berhasil diambil',
            'data' => $mesins,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_mesin' => 'required|string|max:255',
        ]);

        $mesin = Mesin::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Mesin berhasil ditambahkan',
            'data' => $mesin,
        ], 201);
    }

    public function show($id)
    {
        $mesin = Mesin::findOrFail($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Detail mesin ditemukan',
            'data' => $mesin,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_mesin' => 'required|string|max:255',
        ]);

        $mesin = Mesin::findOrFail($id);
        $mesin->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Mesin berhasil diperbarui',
            'data' => $mesin,
        ]);
    }

    public function destroy($id)
    {
        $mesin = Mesin::findOrFail($id);
        $mesin->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Mesin berhasil dihapus',
        ]);
    }
}
