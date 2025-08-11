<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    public function listUsers()
    {
        // Fetch all users from the database
        $users = User::all();
        $roles = Role::all();

        // Return a view with the users data
        return view('users.listUsers', compact('users', 'roles'));
    }
}
