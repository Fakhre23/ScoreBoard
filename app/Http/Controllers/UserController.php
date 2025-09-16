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




    public function delete(Request $request, $id)
    {
        $userToDelete = User::findOrFail($id);
        $this->authorize('delete', $userToDelete);  //Check if the currently logged-in user is allowed to delete this $userToDelete model.
        $userToDelete->delete();
        return redirect()->back()->with('success', 'User is Deleted');
    }


    public function statusUpdate(Request $request, $id)
    {
        $userToUpdate = User::findOrFail($id);
        $userToUpdate->is_active = $request->input('is_active');
        $userToUpdate->save();
        return redirect()->back()->with('success', 'User status is updated');
    }


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
}
