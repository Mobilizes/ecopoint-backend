<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Sampah;
use Illuminate\Support\Facades\Auth;

class SampahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $transaksis = $user->transaksis()->with(['mesin', 'sampahs'])->get()->map(
            function ($transaksi) {
                return [
                    'tanggal_transaksi' => $transaksi->created_at->translatedFormat('l, d F Y'),
                    'jam_penukaran' => $transaksi->created_at->translatedFormat('H:i'),
                    'nama_mesin' => $transaksi->mesin->nama_mesin,
                    'total_poin' => $transaksi->total_poin,
                    'sampah' => $transaksi->sampahs,
                ];
            }
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Data sampah berhasil diambil',
            'data' => $transaksis,
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
