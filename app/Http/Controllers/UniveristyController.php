<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\University;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class UniveristyController extends Controller
{
    use AuthorizesRequests;

    public function universitiesList(Request $request)
    {
        $currentUser = $request->user();
        $this->authorize('viewAny', $currentUser);

        if ($currentUser->user_role === 1) {
            $universities =  University::all();
        } else {
            $universities = University::where('id', $currentUser->university_id)->get();
        }
        return view('universities.universitiesList', compact('universities'));
    }
}
