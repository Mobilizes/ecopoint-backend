<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\User;

class LeaderboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $limit = 10;

        $topUsers = User::orderByDesc('poin')->take($limit)->get();

        if ($user == null || $topUsers->contains('id', $user->id)) {
            return response()->json([
                'status' => 'success',
                'message' => 'Top 10 leaderboard',
                'data' => $topUsers,
            ]);
        }

        $userRank = User::where('poin', '>', $user->poin)->count() + 1;

        $start = max(0, $userRank - 5);

        $nearbyUsers = User::orderByDesc('poin')
            ->skip($start)
            ->take($limit)
            ->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Leaderboard centered around user',
            'data' => $nearbyUsers,
        ]);
    }
}
