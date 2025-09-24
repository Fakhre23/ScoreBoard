<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\University;
use App\Models\Event;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;



class EventController extends Controller
{
    use AuthorizesRequests;

    public function listEvents(Request $request)
    {
        $currentUser = $request->user();

        // Check permission before continuing
        $this->authorize('viewAny', Event::class);

        if ($currentUser->user_role === 1) {
            $events = Event::all();
        } else {
            // Ambassador → only their university events
            $events = Event::where('university_id', $currentUser->university_id)->get();
        }

        return view('events.eventsList', compact('events'));
    }
    public function delete(Request $request, $id)
    {
        $eventToDelete = Event::findOrFail($id);
        $this->authorize('delete', $eventToDelete);  //Check if the currently logged-in user is allowed to delete this $eventToDelete model.
        $eventToDelete->delete();
        return redirect()->back()->with('success', 'Event is Deleted');
    }


    public function create(Request $request)
    {
        $users = User::all();
        $roles = Role::all();
        $universities =  University::where('Status', 1)->get();

        return view('events.creatEvent', compact('roles', 'universities', 'users'));
    }

    public function store(Request $request) {
        // 
    }
}
