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

    //list events (all events for admin * ber uni for ambassador ) 

    public function listEvents(Request $request)
    {
        $currentUser = $request->user();
        $this->authorize('viewAny', Event::class);

        if ($currentUser->user_role === 1) {
            $events = Event::all();
        } else {
            $events = Event::where('university_id', $currentUser->university_id)->get();
        }
        return view('events.eventsList', compact('events'));
    }


    // **** delete event ****

    public function delete(Request $request, $id)
    {
        $eventToDelete = Event::findOrFail($id);
        //Check if the currently  is allowed to delete 
        $this->authorize('delete', $eventToDelete);
        $eventToDelete->delete();
        return redirect()->back()->with('success', 'Event is Deleted');
    }



    //***** create new event ******

    public function create(Request $request)
    {
        $this->authorize('create', Event::class);
        $users = User::all();
        $roles = Role::all();
        $universities =  University::where('Status', 1)->get();

        return view('events.creatEvent', compact('roles', 'universities', 'users'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Event::class);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after_or_equal:start_datetime',
            'max_participants' => 'required|integer|min:1',
            'status' => 'required|in:Draft,PendingApproval,Approved,Rejected,Completed',
            'scope' => 'required|in:Public,University',
            'university_id' => 'nullable|required_if:scope,University|exists:universities,id',
        ]);

        $event = Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'start_datetime' => $request->start_datetime,
            'end_datetime' => $request->end_datetime,
            'max_participants' => $request->max_participants,
            'created_by' => $request->user()->id,
            'status' => $request->status,
            'scope' => $request->scope,
            'approved_by' => auth()->id(),
            'approval_date' => now(),
            'university_id' => $request->scope === 'University' ? $request->university_id : null,
        ]);
        return redirect()->route('adminDashboard')->with('success', 'Event created successfully.');
    }


    //**** edit / update event ****

    public function edit(Request $request, $id)
    {
        $eventToEdit = Event::findOrFail($id);
        $this->authorize('update', $eventToEdit);
        $universities = University::where('Status', 1)->get();

        return view('events.editEvent', compact('eventToEdit', 'universities'));
    }

    public function updateEvent(Request $request, $id)
    {
        $eventToEdit = Event::findOrFail($id);
        $this->authorize('update', $eventToEdit);
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after_or_equal:start_datetime',
            'max_participants' => 'required|integer|min:1',
            'status' => 'required|in:Draft,PendingApproval,Approved,Rejected,Completed',
            'scope' => 'required|in:Public,University',
            'university_id' => 'nullable|required_if:scope,University|exists:universities,id',
        ]);

        $eventToEdit->title = $request->input('title');
        $eventToEdit->description = $request->input('description'); //not found
        $eventToEdit->location = $request->input('location');
        $eventToEdit->start_datetime = $request->input('start_datetime');
        $eventToEdit->end_datetime = $request->input('end_datetime');
        $eventToEdit->max_participants = $request->input('max_participants');
        $eventToEdit->status = $request->input('status');
        $eventToEdit->scope = $request->input('scope');
        $eventToEdit->university_id = $request->input('scope') === 'University' ? $request->input('university_id') : null;
        $eventToEdit->updated_at = now();
        $eventToEdit->save();

        return redirect()->route('adminDashboard')->with('success', 'Event updated successfully.');
    }
}
