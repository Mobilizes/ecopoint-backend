<?php

namespace App\Http\Controllers;

use App\Models\Hadiah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HadiahController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->limit ?? 1;

        $hadiahs = Hadiah::simplePaginate($limit);

        return response()->json([
            'status' => 'success',
            'message' => 'Data hadiah berhasil diambil',
            'data' => $hadiahs
        ]);
    }
}
