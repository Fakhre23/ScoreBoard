<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\ScoreClaim;
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
        $this->authorize('viewAny', User::class);

        if ($currentUser->user_role === 1) {
            // Admin → see all, newest first
            $users = User::orderBy('created_at', 'desc')->get();
        } else {
            // Ambassador → only their university, newest first
            $users = User::where('university_id', $currentUser->university_id)->where('user_role', '>', 1)
                ->orderBy('created_at', 'desc')
                ->get();
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



    //************ users Score history ************ */


    public function userScoreHistory(request $request)
    {
        $currentUser = $request->user();

        if ($currentUser->user_role == 1) {
            // Admin → see all, newest first
            $ScoreHistory = ScoreClaim::with('user.university', 'event')
                ->orderBy('created_at', 'desc')
                ->take(15)
                ->get();
            return view('users.usersScores', compact('currentUser', 'ScoreHistory'));
        } else {
            $ScoreHistory = ScoreClaim::with('user.university', 'event')
                ->where('user_id', $currentUser->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('users.usersScores', compact('currentUser', 'ScoreHistory'));
    }
}
