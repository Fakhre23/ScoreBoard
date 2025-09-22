<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\University;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class UserController extends Controller
{
    //apply user  policies (its like roleBuck for your controller)
    use AuthorizesRequests;

    //list all users
    public function listUsers(Request $request)
    {
        $currentUser = $request->user();

        // Check permission before continuing
        //User::class is just a PHP constant that gives you the class name string → "App\Models\User".
        $this->authorize('viewAny', User::class);

        if ($currentUser->user_role === 1) {
            // Admin → see all
            $users = User::all();
        } else {
            // Ambassador → only their university
            $users = User::where('university_id', $currentUser->university_id)->get();
        }

        $roles = Role::all();
        $universities = University::all();

        return view('users.usersList', compact('users', 'roles', 'universities'));
    }


    //delete user

    public function delete(Request $request, $id)
    {
        $userToDelete = User::findOrFail($id);
        $this->authorize('delete', $userToDelete);  //Check if the currently logged-in user is allowed to delete this $userToDelete model.
        $userToDelete->delete();
        return redirect()->back()->with('success', 'User is Deleted');
    }

    //cahange user status
    public function statusUpdate(Request $request, $id)
    {
        $userToUpdate = User::findOrFail($id);
        $userToUpdate->is_active = $request->input('is_active');
        $userToUpdate->save();
        return redirect()->back()->with('success', 'User status is updated');
    }

    //change user role
    public function changeRole(Request $request, $id)
    {
        $userToUpdate = User::findOrFail($id);

        $this->authorize('roleUpdate', $userToUpdate);
        $request->validate([
            'userRole' => 'required|exists:standard_user_role,id',
        ]);

        $userToUpdate->user_role = $request->input('userRole');
        $userToUpdate->save();
        return redirect()->back()->with('success', 'User role is updated');
    }


    //change user university

    public function changeUniversity(Request $request, $id)
    {
        $userToUpdate = User::findOrFail($id);

        $this->authorize('update', $userToUpdate);
        $request->validate([
            'university_id' => 'required|exists:universities,id',
        ]);

        $userToUpdate->university_id = $request->input('university_id');
        $userToUpdate->save();
        return redirect()->back()->with('success', 'User university is updated');
    }


    //create and store new users

    public function create(Request $request)
    {
        $this->authorize('create', User::class);

        $roles = Role::all();
        $universities =  University::where('Status', 1)->get();

        return view('users.createUsers', compact('roles', 'universities'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', User::class);

        $request->validate([
            'name' => 'required|string|max:255|unique:users,name',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:15',
            'university_id' => 'required|exists:universities,id',
            'role_id' => 'required|exists:standard_user_role,id',
        ]);

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'phone' => $request->input('phone'),
            'university_id' => $request->input('university_id'),
            'user_role' => $request->input('role_id'),
            'is_active' => "1",
        ]);
        return redirect()->route('adminDashboard')->with('success', 'New user created successfully.');
    }
}
