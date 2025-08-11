<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureUserIsActive;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard/dashboard');
})->middleware(['auth', 'verified', EnsureUserIsActive::class])->name('dashboard');





Route::get('/pedndingDashboard', function () {
    return view('dashboard/pendingDashboard');
})->name('pendingDashboard');


Route::get('/adminDashboard', function () {
    return view('dashboard/adminDashboard');
})->name('adminDashboard');

Route::get('/ambassadorDashboard', function () {
    return view('dashboard/ambassadorDashboard');
})->name('ambassadorDashboard');

Route::get('/viceDashboard', function () {
    return view('dashboard/viceDashboard');
})->name('viceDashboard');

Route::get('/studentDashboard', function () {
    return view('dashboard/studentDashboard');
})->name('studentDashboard');

Route::get('listUsers', [UserController::class, 'listUsers'])->name('listUsers');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
