<?php

namespace App\Http\Controllers;

use App\Models\Penukaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenukaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = $user->penukarans()->orderBy('created_at', 'desc');

        $penukarans = $request->filled('limit')
            ? $query->paginate($request->limit)
            : $query->get();

        $meta = $request->filled('limit') ? [
            'page' => $penukarans->currentPage(),
            'per_page' => $penukarans->perPage(),
            'max_page' => $penukarans->lastPage(),
            'count' => $penukarans->total(),
        ] : null;

        if ($penukarans == null) {
            return response()->json([
                'status' => 'success',
                'message' => 'Daftar penukaran hadiah kosong',
                'data' => [],
            ], 200);
        }

        $penukarans = $penukarans->map(function ($penukaran) {
            return [
                'id' => $penukaran->id,
                'tanggal_penukaran' => $penukaran->created_at->translatedFormat('l, d F Y'),
                'jam_penukaran' => $penukaran->created_at->translatedFormat('H:i'),
                'status' => $penukaran->status,
                'hadiahs' => $penukaran->hadiahs,
                'poin_ditukar' => $penukaran->totalPoin(),
            ];
        });

        $response = [
            'status' => 'success',
            'message' => 'Daftar hadiah berhasil diambil',
            'data' => $penukarans
        ];

        if ($meta !== null) {
            $response['meta'] = $meta;
        }

        return response()->json($response);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = Auth::user();
        $penukaran = $user->penukarans()->with('hadiahs')
            ->where('id', $id)
            ->first();

        if ($penukaran == null) {
            return response()->json([
                'status' => 'success',
                'message' => 'Detail penukaran hadiah tidak ditemukan',
                'data' => (object) [],
            ], 200);
        }

        $data = [
            'id' => $penukaran->id,
            'tanggal_penukaran' => $penukaran->created_at->translatedFormat('l, d F Y'),
            'jam_penukaran' => $penukaran->created_at->translatedFormat('H:i'),
            'status' => $penukaran->status,
            'hadiahs' => $penukaran->hadiahs,
            'poin_ditukar' => $penukaran->totalPoin(),
        ];

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mendapatkan detail penukaran hadiah',
            'data' => $data,
        ], 200);
    }

    public function showHadiah(string $hadiah_id)
    {
        $user = Auth::user();
        $penukaran = Penukaran::where('user_id', $user->id)
            ->where('hadiah_id', $hadiah_id)
            ->first();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mendapatkan detail penukaran hadiah',
            'data' => $penukaran,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
