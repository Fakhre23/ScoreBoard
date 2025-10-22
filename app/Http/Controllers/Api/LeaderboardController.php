<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\University;

class LeaderboardController extends Controller
{
    public function index()
    {
        $users = User::with('university')->orderBy('total_user_score', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($users, $index) {
                return [
                    'rank' => $index + 1,
                    'name' => $users->name,
                    'university' => $users->university_id ? $users->university->name : 'N/A',
                    'score' => $users->total_user_score,
                    'avatar' => $users->profile_photo ?? null,
                ];
            });

        $universities = University::orderBy('total_score', 'desc')
            ->limit(4)
            ->get()
            ->map(function ($university, $index) {
                return [
                    'rank' => $index + 1,
                    'name' => $university->name,
                    'totalScore' => $university->total_score,
                    'logo' => $university->UNI_photo ?? null,
                ];
            });

        return response()->json([
            'users' => $users,
            'universities' => $universities,
        ]);
    }
}
