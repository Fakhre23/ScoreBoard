<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureUserIsActive;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRoles;
use App\Http\Controllers\UniveristyController;

use App\Models\University;


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


Route::middleware('auth')->group(function () { // just for more securty its not nesscery 
    Route::get('usersList', [UserController::class, 'listUsers'])->name('users.list');
    Route::delete('usersList/{id}', [UserController::class, 'delete'])->name('users.delete');
    Route::patch('usersList/{id}/status', [UserController::class, 'statusUpdate'])->name('users.statusUpdate');
    Route::patch('usersList/{id}/university', [UserController::class, 'changeUniversity'])->name('users.changeUniversity');
    Route::patch('usersList/{id}/role', [UserController::class, 'changeRole'])->name('users.changeRole');
    Route::get('usersList/{id}/create', [UserController::class, 'create'])->name('users.create');
    Route::post('usersList/store', [UserController::class, 'store'])->name('users.store');


    // *** Universities Routes Section *** //

    Route::get('universitiesList', [UniveristyController::class, 'universitiesList'])->name('universities.list');
});

Route::get('listRoles', [UserRoles::class, 'index'])->name('roles.list');


/* ========= PROFILE ROUTES ========= */
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
