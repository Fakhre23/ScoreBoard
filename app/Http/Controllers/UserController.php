<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\University;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class UserController extends Controller
{
    use AuthorizesRequests;

    public function listUsers(Request $request)
    {
        $currentUser = $request->user();

        // Fetch all users and thier data from the database
        $users = User::all();
        $roles = Role::all();
        $universities = University::all();
        // store current user university id 
        $userUniversity = $currentUser->university_id;

        //show all users for admin , and for all roles just show the same uni 
        if ($currentUser->user_role == 1) {

            // Return a view with the all users data
            return view('users.usersList', compact('users', 'roles', 'universities'));
        } else if ($currentUser->user_role > 1) {
            // show the data just if they are the same uni ...
            $users = User::where('university_id', $userUniversity)->get();
            return view('users.usersList', compact('users', 'roles', 'universities'));
        }
    }




    public function delete(Request $request, $id)
    {
        $userToDelete = User::findOrFail($id);
        $this->authorize('delete', $userToDelete);  //Check if the currently logged-in user is allowed to delete this $userToDelete model.
        $userToDelete->delete();
        return redirect()->back()->with('success', 'User is Deleted');
    }
}
