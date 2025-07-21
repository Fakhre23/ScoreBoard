<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\University;
use App\Models\StandardRole;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $universities = University::where('status', 1)->get();
        $roles = StandardRole::where('id', '>', 1)->get();
        return view('auth.register', compact('universities', 'roles'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
        'name' => ['required', 'string', 'max:100'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:100', 'unique:' . User::class],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'phone' => ['required', 'numeric', 'digits:10', 'unique:users,phone'],
        'university_id' => ['required', 'exists:universities,id'],
        'role_id' => ['required', 'exists:standard_roles,id'],
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'phone' => $request->phone,
        'university_id' => $request->university_id,
        'role_id' => $request->role_id,
    ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }

    public function uniStatus(Request $request) {}
}
