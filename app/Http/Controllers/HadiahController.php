<?php

namespace App\Http\Controllers;

use App\Models\Hadiah;
use Illuminate\Http\Request;

class HadiahController extends Controller
{
    public function index(Request $request)
    {
        $query = Hadiah::query();

        $hadiahs = $request->filled('limit')
            ? $query->simplePaginate($request->limit)->items()
            : $query->get();

        if ($hadiahs == null) {
            return response()->json([
                'status' => 'success',
                'message' => 'Daftar hadiah kosong',
                'data' => (object) []
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Daftar hadiah berhasil diambil',
            'data' => $hadiahs
        ]);
    }

    public function show(string $id)
    {
        $hadiah = Hadiah::find($id);

        if ($hadiah == null) {
            return response()->json([
                'status' => 'success',
                'message' => 'Detail hadiah tidak ditemukan',
                'data' => (object) [],
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Detail hadiah berhasil diambil',
            'data' => $hadiah
        ]);
    }
}
