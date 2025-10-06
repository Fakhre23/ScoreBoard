<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\University;
use App\Models\Event;
use App\Models\EventRoles;
use App\Models\ScoreClaim;
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
            $events = Event::orderBy('created_at', 'desc')->get();
        } else {
            $events = Event::where('university_id', $currentUser->university_id)->orderBy('created_at', 'desc')->get();
        }
        return view('events.eventsList', compact('events'));
    }


    // ******************************** delete event ********************************

    public function delete(Request $request, $id)
    {
        $eventToDelete = Event::findOrFail($id);
        //Check if the currently  is allowed to delete 
        $this->authorize('delete', $eventToDelete);
        $eventToDelete->delete();
        return redirect()->back()->with('success', 'Event is Deleted');
    }



    //********************************* create new event **********************************

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



    //******************************** edit / update event ********************************

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
        $eventToEdit->description = $request->input('description');
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

    //******************************** not active events ********************************
    public function notActiveList(Request $request)
    {
        $currentUser = $request->user();
        $this->authorize('viewAny', $currentUser);   //viewAny is not working , idk why , but the create policy is similar to viewAny

        if ($currentUser->user_role === 1) {
            $events = Event::whereIn('status', ['PendingApproval', 'Draft'])->orderBy('created_at', 'desc')->get();
        } else if ($currentUser->user_role === 2) {
            $events = Event::whereIn('status', ['PendingApproval', 'Draft'])->where('university_id', $currentUser->university_id)->orderBy('created_at', 'desc')->get();
        }
        return view('events.queueEvents', compact('events', 'currentUser'));
    }



    //******************************** list the events can user register ********************************

    public function listUsersEvents(Request $request)
    {
        $currentUser = $request->user();
        $eventsRoles = EventRoles::all();


        $userEvent = Event::where('status', 'Approved')
            ->where(function ($query) use ($currentUser) {
                $query->where('scope', 'Public')
                    ->orWhere('university_id', $currentUser->university_id);
            })
            ->orderBy('created_at', 'desc')
            ->get();
        $scoreClaims = ScoreClaim::all();
        return view('events.eventsUsers', compact('userEvent', 'eventsRoles', 'scoreClaims'));
    }



    // ******************************** Register Users to events ****************************
    public function registerUserToEvent(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $eventsRoles = EventRoles::all();
        $currentUser = $request->user();

        return view('events.registerToEvent', compact('event', 'eventsRoles', 'currentUser'));
    }

    public function storeUserEvent(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $currentUser = $request->user();

        $request->validate([
            'role_id' => 'required|exists:event_roles,id',
        ]);

        $role = EventRoles::find($request->role_id);

        ScoreClaim::create([
            'user_id' => $currentUser->id,
            'event_id' => $event->id,
            'event_role_id' => $request->role_id,
            'attendance_status' => 'NoShow',
            'points_earned' => 0,
            'approved_by' => null,
            'approval_date' => null,
            'feedback' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect()->route('dashboard')->with('success', 'You have successfully registered for the event.');
    }



    //**************************** Admin and ambasdoor event users registered managment  *****************************/

    public function eventUsersManagement(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $this->authorize('viewAny', $event);
        $currentUser = $request->user();

        if ($currentUser == '1') {
            $users = User::all();
            $eventsRoles = EventRoles::all();
            $scoreClaims = ScoreClaim::where('event_id', $event->id)->get();
        } else {
            $users = User::where('university_id', $currentUser->university_id);
            $eventsRoles = EventRoles::all();
            $scoreClaims = ScoreClaim::where('event_id', $event->id)->get();
        }

        return view('events.eventManagment', compact('event', 'scoreClaims', 'users', 'eventsRoles'));
    }


    public function updateRegisteredEventStatus(Request $request, $id)
    {
        $statusToUpdate = ScoreClaim::findOrFail($id);

        $request->validate([
            'attendance_status' => 'required|in:Registered,Attended,NoShow',
            'points_earned' => 'nullable|integer|min:0'
        ]);

        // Get the user and role before updating
        $targetUser = User::findOrFail($statusToUpdate->user_id);
        $role = EventRoles::findOrFail($statusToUpdate->event_role_id);
        $currentUser = $request->user();

        // Store old status to check if we need to add/remove points
        $oldStatus = $statusToUpdate->attendance_status;
        $newStatus = $request->input('attendance_status');

        // Update the attendance status
        $statusToUpdate->attendance_status = $newStatus;

        // Update points if provided
        if ($request->has('points_earned')) {
            $statusToUpdate->points_earned = $request->input('points_earned');
        }

        $statusToUpdate->save();

        // Define points based on role
        $points = match ($role->name) {
            'Organizer' => 5,
            'Booth' => 10,
            'ContentCreation' => 7,
            'MediaCoverage' => 3,
            'Volunteer' => 2,
            'Participant' => 1,
            default => 0,
        };



        if ($oldStatus !== 'Attended' && $newStatus === 'Attended') {

            // User changed from not attended to attended - ADD points
            User::where('id', $targetUser->id)->increment('total_user_score', $points);
            University::where('id', $targetUser->university_id)->increment('total_score', $points);
            ScoreClaim::where('id', $statusToUpdate->id)->update(['points_earned' => $points]);

            return redirect()->back()->with('success', "Status updated to Attended. {$points} points added!");
        } elseif ($oldStatus === 'Attended' && $newStatus !== 'Attended') {

            // User changed from attended to not attended - REMOVE points
            User::where('id', $targetUser->id)->decrement('total_user_score', $points);
            University::where('id', $targetUser->university_id)->decrement('total_score', $points);

            return redirect()->back()->with('success', "Status updated. {$points} points removed.");
        } else {

            // Status changed but no point modification needed
            return redirect()->back()->with('success', 'Status updated successfully.');
        }
    }


    //******************************users Scores and events statistics *****************************/


    public function topScores()
    {
        $topUsers = User::orderBy('total_user_score', 'desc')->take(10)->get();


        $topUniversities = University::orderBy('total_score', 'desc')->take(5)->get();

        return view('welcome', compact('topUsers', 'topUniversities'));
    }
}
