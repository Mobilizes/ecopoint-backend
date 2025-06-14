<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function penukaran()
    {
        $user = Auth::user();

        $penukarans = $user->penukarans()->with(['user', 'hadiah'])->get()->map(
            function ($p) {
                return [
                    'id' => $p->id,
                    'user' => $p->user,
                    'hadiah' => $p->hadiah,
                    'created_at' => $p->created_at,
                ];
            }
        );

        $sum = $penukarans->sum(function ($p) {
            return $p['hadiah']['poin'] ?? 0;
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mendapatkan data penukaran hadiah',
            'data' => [
                'penukaran' => $penukarans,
                'poin' => $sum,
            ],
        ]);
    }

    public function poin()
    {
        $user = Auth::user();

        $sampahs = $user->sampahs()->get();
        $sum = $sampahs->sum('poin');

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mendapatkan data poin',
            'data' => [
                'sampah' => $sampahs,
                'poin' => $sum,
            ],
        ]);
    }
}
