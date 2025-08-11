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



/*  ///////////// Diffrent route for each role ///////////// */

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



/* //////// CRUD for users ///////// */

Route::get('usersList', [UserController::class, 'listUsers'])->name('users.list');
Route::delete('usersList/{id}', [UserController::class, 'destroy'])->name('users.delete');




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';











// <form method="POST" action="{{ route('ReservedWord.delete', $word->id) }}">
//                         @csrf
//                         @method('DELETE')
//                         <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Delete</button>
//                     </form>