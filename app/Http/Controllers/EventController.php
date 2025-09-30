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

        // Get the current user
        $user = $request->user();

        // Validation rules
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after_or_equal:start_datetime',
            'max_participants' => 'required|integer|min:1',
        ];

        // If Admin → allow status & scope validation
        if ($user->user_role === 1) {
            $rules['status'] = 'nullable|in:Draft,PendingApproval,Approved,Rejected,Completed';
            $rules['scope'] = 'nullable|in:University,Public';
            $rules['university_id'] = 'nullable|required_if:scope,University|exists:universities,id';
        }

        // Validate input
        $request->validate($rules);

        // Decide values based on role
        if ($user->user_role === 2) {
            $status = 'Draft';
            $scope = 'University';
            $universityId = $user->university_id; // ambassador’s university
        } else {
            $status = $request->status ?? 'Draft';
            $scope = $request->scope ?? 'Public';
            $universityId = $scope === 'University' ? $request->university_id : null;
        }

        // Create event
        Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'start_datetime' => $request->start_datetime,
            'end_datetime' => $request->end_datetime,
            'max_participants' => $request->max_participants,
            'created_by' => $user->id,
            'status' => $status,
            'scope' => $scope,
            'approved_by' => $user->user_role === 1 ? $user->id : null, // Only admin approves directly
            'approval_date' => $user->user_role === 1 ? now() : null,
            'university_id' => $universityId,
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
        $eventToEdit->approved_by = $request->input('status') === 'Approved' ? $request->user()->id  : $eventToEdit->approved_by;
        $eventToEdit->approval_date = $request->input('status') === 'Approved' ? now() : $eventToEdit->approval_date;
        $eventToEdit->save();

        return redirect()->route('adminDashboard')->with('success', 'Event updated successfully.');
    }

    //**** not active events ****
    public function notActiveList(Request $request)
    {
        $currentUser = $request->user();
        $this->authorize('viewAny', $currentUser);   //viewAny is not working , idk why , but the create policy is similar to viewAny

        if ($currentUser->user_role === 1) {
            $events = Event::whereIn('status', ['PendingApproval', 'Draft'])->get();
        } else if ($currentUser->user_role === 2) {
            $events = Event::whereIn('status', ['PendingApproval', 'Draft'])->where('university_id', $currentUser->university_id)->get();
        }
        return view('events.queueEvents', compact('events', 'currentUser'));
    }







    // **** Register Users to events **** 
    public function registerUserToEvent(Request $request, $id)
    {
        //
    }







    //**** list the events can user register ****

    public function listUsersEvents(Request $request)
    {
        $currentUser = $request->user();

        $userEvent = Event::where('status', 'Approved')
            ->where(function ($query) use ($currentUser) {
                $query->where('scope', 'Public')
                    ->orWhere('university_id', $currentUser->university_id);
            })
            ->get();

        return view('events.registerEvents', compact('userEvent'));
    }
}
