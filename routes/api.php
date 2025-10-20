<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LeaderboardController;


Route::get('/leaderboard', [LeaderboardController::class, 'index']);
