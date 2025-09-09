<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureUserIsActive;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pendingDashboard', function () {
    return view('dashboard/pendingDashboard');
})->name('pendingDashboard');

/* ========= DASHBOARD ROUTES ========= */
// All dashboards share the same middleware
Route::middleware(['auth', 'verified', EnsureUserIsActive::class])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard/dashboard');
    })->name('dashboard');;

    Route::get('/adminDashboard', function () {
        return view('dashboard/admin/adminDashboard');
    })->name('adminDashboard');

    Route::get('/ambassadorDashboard', function () {
        return view('dashboard/ambassador/ambassadorDashboard');
    })->name('ambassadorDashboard');

    Route::get('/viceDashboard', function () {
        return view('dashboard/viceDashboard');
    })->name('viceDashboard');

    Route::get('/studentDashboard', function () {
        return view('dashboard/studentDashboard');
    })->name('studentDashboard');
});

/* ========= USER MANAGEMENT ========= */

Route::get('usersList', [UserController::class, 'listUsers'])->name('users.list');
Route::delete('usersList/{id}', [UserController::class, 'destroy'])->name('users.delete');


/* ========= PROFILE ROUTES ========= */
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
