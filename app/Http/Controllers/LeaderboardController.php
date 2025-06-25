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

        // Get top 10 users ordered by poin
        $topUsers = User::orderByDesc('poin')->take($limit)->get();

        // Assign real ranks to top 10
        $rankedTopUsers = User::orderByDesc('poin')
            ->take($limit + 100) // Extra buffer to calculate rank if needed
            ->get()
            ->values()
            ->map(function ($u, $index) {
                $u->rank = $index + 1;
                return $u;
            });

        // Get top 10 from ranked list
        $top10 = $rankedTopUsers->take($limit);

        // If no user logged in, return just top 10
        if (!$user) {
            return response()->json([
                'status' => 'success',
                'message' => 'Top 10 leaderboard',
                'data' => $top10,
            ]);
        }

        // Check if current user is in top 10
        $inTop10 = $top10->contains('id', $user->id);

        if ($inTop10) {
            return response()->json([
                'status' => 'success',
                'message' => 'Top 10 leaderboard',
                'data' => $top10,
            ]);
        }

        // Find the user in the full ranked list
        $userWithRank = $rankedTopUsers->firstWhere('id', $user->id);

        // Combine top 10 + current user
        $finalList = $top10->push($userWithRank);

        return response()->json([
            'status' => 'success',
            'message' => 'Top 10 leaderboard with current user',
            'data' => $finalList,
        ]);
    }
}
