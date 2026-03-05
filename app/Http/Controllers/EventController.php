<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{University, Event, EventRoles, ScoreClaim,};
use App\Http\Requests\{StoreEventRequest, UpdateEventRequest, UpdateEventStatusRequest, StoreUserToEventRequest, UpdateAttendanceStatusRequest};
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Services\EventService;

class EventController extends Controller
{
    use AuthorizesRequests;

    // ******************************** Events ********************************
    public function listEvents(Request $request, EventService $service)
    {
        $this->authorize('viewAny', Event::class);

        $events = $service->listEventsForUser(
            $request->user(),
            $request->input('search')
        );

        return view('events.eventsList', compact('events'));
    }

    public function delete(Request $request, Event $event, EventService $service)
    {
        //Check if the currently logged-in user is allowed to delete the event
        $this->authorize('delete', $event);
        $service->deleteEvent($event);
        return redirect()->back()->with('success', 'Event is Deleted');
    }

    // create new event 
    public function create(Request $request)
    {
        $this->authorize('create', Event::class);
        $universities =  University::where('Status', 1)->get();

        return view('events.creatEvent', compact('universities'));
    }

    public function store(StoreEventRequest $request, EventService $service)
    {
        $service->createEvent($request->validated(), $request->user());

        return redirect()->route('events.list')
            ->with('success', 'Event created successfully.');
    }

    // edit / update event 
    public function edit(Request $request, Event $event)
    {
        $this->authorize('update', $event);
        $universities = University::where('Status', 1)->get();
        return view('events.editEvent', compact('event', 'universities'));
    }

    public function updateEvent(UpdateEventRequest $request, Event $event, EventService $service)
    {
        $service->updateEvent($event, $request->validated(), $request->user());
        return redirect()->route('events.list')->with('success', 'Event updated successfully.');
    }

    public function eventStatusUpdate(UpdateEventStatusRequest $request, Event $event, EventService $service)
    {
        $service->updateEventStatus($event, $request->input('status'), $request->user());
        return redirect()->route('events.list')->with('success', 'Event status is updated');
    }

    // not active events 
    public function notActiveEvents(Request $request, EventService $service)
    {
        $currentUser = $request->user();
        $this->authorize('viewAny', $currentUser);   //viewAny is not working , idk why , but the create policy is similar to viewAny
        $events = $service->listEventsForQueue($currentUser);
        return view('events.queueEvents', compact('events', 'currentUser'));
    }

    // list the events can user register 
    public function listUsersEvents(Request $request, EventService $service)
    {
        $currentUser = $request->user();
        $eventsRoles = EventRoles::all();

        $userEvent = $service->listApprovedEventsForUsers($currentUser);
        $scoreClaims = ScoreClaim::all();
        return view('events.eventsUsers', compact('userEvent', 'eventsRoles', 'scoreClaims'));
    }

    //Register Users to events 
    public function registerUserToEvent(Event $event, Request $request,  EventService $service)
    {
        $data = $service->getRegistrationData($event, $request->user());

        return view('events.registerToEvent', $data);
    }

    public function storeUserToEvent(StoreUserToEventRequest $request, Event $event, EventService $service)
    {
        $service->registerUserToEvent(
            $event,
            $request->user(),
            $request->validated()['role_id']
        );

        return redirect()
            ->route('events.register')
            ->with('success', 'You have successfully registered for the event.');
    }



    // Admin and ambasdoor registered event managment /

    public function usersEventManagement(Event $event, Request $request, EventService $service)
    {
        $this->authorize('viewAny', $event);
        $scoreClaims = $service->usersEventManagement($event, $request->user());
        return view('events.eventManagment', compact('scoreClaims', 'event'));
    }


    public function updateRegisteredEventStatus(UpdateAttendanceStatusRequest $request, ScoreClaim $scoreClaim, EventService $service)
    {

        $result = $service->updateAttendanceStatus(
            $scoreClaim,
            $request->input('attendance_status'),
            $request->input('points_earned')
        );

        return redirect()->back()->with('success', $result['message']);
    }



    //users Scores and unverities /


    public function topScores(EventService $service)
    {
        $data = $service->getTopScores();

        return view('welcome', $data);
    }
}
