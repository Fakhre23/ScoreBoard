<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{

    public function listUsers(Request $request)
    {
        $currentUser = $request->user();

        // Fetch all users from the database
        $users = User::all();
        $roles = Role::all();

        $userUniversity = $currentUser->university_id;

        if ($currentUser->user_role == 1) {

            // Return a view with the users data
            return view('users.usersList', compact('users', 'roles'));
        } else if ($currentUser->user_role > 1) {
            $users = User::where('university_id', $userUniversity)->get();
            return view('users.usersList', compact('users', 'roles'));
        }
    }




    public function destroy(Request $request, $id)
    {
        $currentUser = $request->user();

        if ($currentUser->user_role !== 1) {
            return redirect()->back()->with('error', 'You do not have permission to delete users.');
        } else {

            $name = User::findOrFail($id);
            $name->delete();
            return redirect()->back()->with('success', 'User is Deleted');
        }
    }
}
