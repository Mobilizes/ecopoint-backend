<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function poin()
    {
        $user = Auth::user();

        $penukarans = $user->penukarans()->with(['user', 'hadiah'])->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mendapatkan data penukaran hadiah',
            'data' => $penukarans,
        ]);
    }

    public function penukaran()
    {
        //
    }
}
