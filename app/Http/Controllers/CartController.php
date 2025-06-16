<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function show(Request $request)
    {
        $user = Auth::user();
        $cart = $user->cart()->firstOrCreate();

        $hadiahs = $request->filled('limit')
            ? $cart->hadiahs()->paginate($request->limit)
            : $cart->hadiahs()->get();

        $meta = $request->filled('limit') ? [
            'page' => $hadiahs->currentPage(),
            'per_page' => $hadiahs->perPage(),
            'max_page' => $hadiahs->lastPage(),
            'count' => $hadiahs->total(),
        ] : null;

        if ($hadiahs->isEmpty()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Keranjang kosong',
                'data' => (object) []
            ]);
        }

        if ($request->filled('limit')) {
            $hadiahs = $hadiahs->items();
        }

        $response = [
            'status' => 'success',
            'message' => 'Daftar hadiah dalam keranjang',
            'data' => [
                'hadiahs' => $hadiahs,
                'total_poin' => $cart->totalPoin(),
            ]
        ];

        if ($meta != null) {
            $response['meta'] = $meta;
        }

        return response()->json($response);
    }

    public function store(Request $request)
    {
        $request->validate([
            'hadiah_id' => 'required|uuid|exists:hadiahs,id'
        ]);

        $user = Auth::user();
        $cart = $user->cart()->firstOrCreate();

        $pivot = $cart->hadiahs()->where('hadiah_id', $request->hadiah_id)->first();
        if ($pivot) {
            $cart->hadiahs()->updateExistingPivot($request->hadiah_id, [
                'kuantitas' => $pivot->pivot->kuantitas + 1
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Hadiah berhasil ditambahkan di keranjang',
                'data' => (object) [],
            ]);
        }

        $cart->hadiahs()->attach($request->hadiah_id);

        return response()->json([
            'status' => 'success',
            'message' => 'Hadiah berhasil ditambahkan ke keranjang',
            'data' => (object) [],
        ]);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'hadiah_id' => 'required|uuid|exists:hadiahs,id'
        ]);

        $user = Auth::user();
        $cart = $user->cart()->firstOrCreate();

        $pivot = $cart->hadiahs()->where('hadiah_id', $request->hadiah_id)->first();
        if (!$pivot) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Hadiah tidak berada dalam keranjang!',
                'data' => (object) [],
            ], 400);
        }

        if ($pivot->pivot->kuantitas == 1) {
            $cart->hadiahs()->detach($request->hadiahs_id);

            return response()->json([
                'status' => 'success',
                'message' => 'Hadiah berhasil dihapus dari keranjang',
                'data' => (object) [],
            ]);
        }

        $cart->hadiahs()->updateExistingPivot($request->hadiah_id, [
            'kuantitas' => $pivot->pivot->kuantitas - 1
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Hadiah berhasil dikurangi di keranjang',
            'data' => (object) [],
        ]);
    }

    public function checkout()
    {
        $user = Auth::user();
        $cart = $user->cart()->firstOrFail();
    }
}
