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
    public function index()
    {
        $user = Auth::user();

        $penukarans = $user->penukarans()->with('hadiah')->get()->map(
            function ($penukaran) {
                return [
                    'id' => $penukaran->id,
                    'tanggal_penukaran' => $penukaran->created_at->translatedFormat('l, d F Y'),
                    'jam_penukaran' => $penukaran->created_at->translatedFormat('H:i'),
                    'status' => $penukaran->status,
                    'nama_hadiah' => $penukaran->hadiah->nama_hadiah,
                    'poin_ditukar' => $penukaran->hadiah->poin,
                    'gambar_hadiah' => $penukaran->hadiah->link_foto,
                ];
            }
        );

        $sum = $penukarans->sum(function ($p) {
            return $p['poin_ditukar'] ?? 0;
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mendapatkan daftar penukaran hadiah',
            'data' => [
                'penukaran' => $penukarans,
                'poin' => $sum,
            ],
        ]);
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
        $penukaran = $user->penukarans()->with('hadiah')
            ->where('id', $id)
            ->first();

        if ($penukaran == null) {
            $data = [];
        } else {
            $data = [
                'id' => $penukaran->id,
                'tanggal_penukaran' => $penukaran->created_at->translatedFormat('l, d F Y'),
                'jam_penukaran' => $penukaran->created_at->translatedFormat('H:i'),
                'status' => $penukaran->status,
                'nama_hadiah' => $penukaran->hadiah->nama_hadiah,
                'poin_ditukar' => $penukaran->hadiah->poin,
                'gambar_hadiah' => $penukaran->hadiah->link_foto,
            ];
        }

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
