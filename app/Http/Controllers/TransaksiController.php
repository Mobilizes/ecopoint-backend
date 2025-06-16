<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = $user->transaksis()->with(['mesin', 'sampahs']);

        $transaksis = $request->filled('limit')
            ? $query->paginate($request->limit)
            : $query->get();

        $meta = $request->filled('limit') ? [
            'page' => $transaksis->currentPage(),
            'per_page' => $transaksis->perPage(),
            'max_page' => $transaksis->lastPage(),
            'count' => $transaksis->total(),
        ] : null;

        if ($transaksis == null) {
            return response()->json([
                'status' => 'success',
                'message' => 'Daftar transaksi kosong',
                'data' => [],
            ], 200);
        }

        $transaksis = $transaksis->map(function ($transaksi) {
            return [
                'id' => $transaksi->id,
                'tanggal_transaksi' => $transaksi->created_at->translatedFormat('l, d F Y'),
                'jam_transaksi' => $transaksi->created_at->translatedFormat('H:i'),
                'nama_mesin' => $transaksi->mesin->nama_mesin,
                'total_poin' => $transaksi->total_poin,
                'sampah' => $transaksi->sampahs,
            ];
        });

        $response = [
            'status' => 'success',
            'message' => 'Daftar hadiah berhasil diambil',
            'data' => $transaksis
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
        $transaksi = $user->transaksis()->with('sampahs')
            ->where('id', $id)
            ->first();

        if ($transaksi == null) {
            return response()->json([
                'status' => 'success',
                'message' => 'Detail transaksi tidak ditemukan',
                'data' => (object) [],
            ], 200);
        }

        $data = [
            'id' => $transaksi->id,
            'tanggal_transaksi' => $transaksi->created_at->translatedFormat('l, d F Y'),
            'jam_transaksi' => $transaksi->created_at->translatedFormat('H:i'),
            'nama_mesin' => $transaksi->mesin->nama_mesin,
            'total_poin' => $transaksi->total_poin,
            'sampah' => $transaksi->sampahs,
        ];

        return response()->json([
            'status' => 'success',
            'message' => 'Detail transaksi berhasil diambil',
            'data' => $data,
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
