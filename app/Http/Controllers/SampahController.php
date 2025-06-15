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

        $transaksis = $user->transaksis()->get();

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
        $sampah = Sampah::find($id)::where('user_id', $user->id)->first();
        if ($sampah == null) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Sampah tidak ditemukan',
                'data' => '',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Sampah ditemukan',
            'data' => $sampah,
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
