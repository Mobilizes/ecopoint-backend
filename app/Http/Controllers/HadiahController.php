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
            ? $query->paginate($request->limit)
            : $query->get();

        $meta = $request->filled('limit') ? [
            'current_page' => $hadiahs->currentPage(),
            'from' => $hadiahs->firstItem(),
            'per_page' => $hadiahs->perPage(),
            'to' => $hadiahs->lastItem(),
            'next_page_url' => $hadiahs->nextPageUrl(),
            'prev_page_url' => $hadiahs->previousPageUrl(),
            'path' => $hadiahs->path(),
        ] : null;

        if ($hadiahs == null) {
            return response()->json([
                'status' => 'success',
                'message' => 'Daftar hadiah kosong',
                'data' => (object) []
            ]);
        }

        $hadiahs = $meta !== null ? $hadiahs->items() : $hadiahs;

        $response = [
            'status' => 'success',
            'message' => 'Daftar hadiah berhasil diambil',
            'data' => $hadiahs
        ];

        if ($meta !== null) {
            $response['meta'] = $meta;
        }

        return response()->json($response);
    }

    public function show(string $id)
    {
        $hadiah = Hadiah::find($id);

        if ($hadiah == null) {
            return response()->json([
                'status' => 'success',
                'message' => 'Detail hadiah tidak ditemukan',
                'data' => (object) [],
            ], 200);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Detail hadiah berhasil diambil',
            'data' => $hadiah
        ]);
    }

    public function search(Request $request)
    {
        $query = Hadiah::where('nama_hadiah', 'like', "%{$request["nama"]}%");

        $hadiahs = $request->filled('limit')
            ? $query->paginate($request->limit)
            : $query->get();

        $meta = $request->filled('limit') ? [
            'page' => $hadiahs->currentPage(),
            'per_page' => $hadiahs->perPage(),
            'max_page' => $hadiahs->lastPage(),
            'count' => $hadiahs->total(),
        ] : null;

        if ($hadiahs == null) {
            return response()->json([
                'status' => 'success',
                'message' => 'Daftar hadiah kosong',
                'data' => (object) []
            ], 200);
        }

        $hadiahs = $meta !== null ? $hadiahs->items() : $hadiahs;

        $response = [
            'status' => 'success',
            'message' => 'Daftar hadiah berhasil diambil',
            'data' => $hadiahs
        ];

        if ($meta !== null) {
            $response['meta'] = $meta;
        }

        return response()->json($response);
    }
}
