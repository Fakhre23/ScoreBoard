<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureUserIsActive;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRoles;
use App\Http\Controllers\UniveristyController;
use App\Http\Controllers\EventController;



Route::get('/', function () {
    return view('welcome');
});

// Pending dashboard for users whose accounts are not yet active

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
    //Users CRUD Routes Section
    Route::get('usersList', [UserController::class, 'listUsers'])->name('users.list');
    Route::delete('usersList/{id}', [UserController::class, 'delete'])->name('users.delete');
    Route::patch('usersList/{id}/status', [UserController::class, 'statusUpdate'])->name('users.statusUpdate');
    Route::patch('usersList/{id}/university', [UserController::class, 'changeUniversity'])->name('users.changeUniversity');
    Route::patch('usersList/{id}/role', [UserController::class, 'changeRole'])->name('users.changeRole');
    Route::get('usersList/create', [UserController::class, 'create'])->name('users.create');
    Route::post('usersList/store', [UserController::class, 'store'])->name('users.store');


    // *** Universities CRUD Routes Section *** //

    Route::get('universitiesList', [UniveristyController::class, 'universitiesList'])->name('universities.list');

    Route::delete('universitiesList/{id}', [UniveristyController::class, 'delete'])->name('universities.delete');

    Route::patch('universitiesList/{id}/status', [UniveristyController::class, 'statusUpdate'])->name('universities.statusUpdate');

    Route::patch('universitiesList/{id}/edit', [UniveristyController::class, 'updateUniversity'])->name('universities.edit');

    Route::get('universitiesList/{id}/edit', [UniveristyController::class, 'edit'])->name('universities.editForm');

    Route::get('universitiesList/create', [UniveristyController::class, 'create'])->name('universities.create');

    Route::post('universitiesList/store', [UniveristyController::class, 'store'])->name('universities.store');

    Route::get('universitiesList/not-active', [UniveristyController::class, 'notActiveList'])->name('universities.notActive');


    // *** Events CRUD Routes Section *** //

    Route::get('eventsList', [EventController::class, 'listEvents'])->name('events.list');

    Route::delete('eventsList/{id}', [EventController::class, 'delete'])->name('events.delete');

    Route::get('eventsList/create', [EventController::class, 'create'])->name('events.create');

    Route::post('eventsList/store', [EventController::class, 'store'])->name('events.store');

    Route::get('eventsList/{id}/edit', [EventController::class, 'edit'])->name('events.edit');

    Route::patch('eventsList/{id}/update', [EventController::class, 'updateEvent'])->name('events.update');

    Route::get('eventsQueue', [EventController::class, 'notActiveList'])->name('events.queue');


    // *** users can Register to events *** //
    Route::get('eventsUsers', [EventController::class, 'listUsersEvents'])->name('events.register');

    Route::get('eventsUsers/{id}/register', [EventController::class, 'registerUserToEvent'])->name('events.registerUser');

    Route::post('eventsUsers/{id}/register', [EventController::class, 'storeUserEvent'])->name('events.storeUserEvent');

    // *** Event users management *** //
    Route::get('eventManagement/{id}', [EventController::class, 'eventUsersManagement'])->name('events.eventUsersManagement');

    Route::patch('eventManagement/{id}/updateStatus', [EventController::class, 'updateRegisteredEventStatus'])->name('events.updateRegisteredEventStatus');
});

// Routes for users to register their universities (no auth middleware)
Route::get('registerUniversity/create', [UniveristyController::class, 'createUniFromUser'])->name('universities.fromUser.create');
Route::post('registerUniversity/store', [UniveristyController::class, 'storeUniFromUser'])->name('universities.fromUser.store');


Route::get('listRoles', [UserRoles::class, 'index'])->name('roles.list');


/* ========= PROFILE ROUTES ========= */
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
