<?php

namespace App\Services;

use App\Models\{Event, User, ScoreClaim, EventRoles, University};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Notifications\EventCreatedNotification;

class EventService
{
    public function createEvent(array $data, User $user): Event
    {
        return DB::transaction(function () use ($data, $user) {
            if ($user->isAmbassador()) {
                $status = 'Draft';
                $scope = 'University';
                $universityId = $user->university_id;
            } else {
                $status = $data['status'] ?? 'Draft';
                $scope = $data['scope'] ?? 'University';
                $universityId = $data['university_id'] ?? null;
            }

            $event = Event::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'location' => $data['location'],
                'start_datetime' => $data['start_datetime'],
                'end_datetime' => $data['end_datetime'],
                'max_participants' => $data['max_participants'],
                'created_by' => $user->id,
                'status' => $status,
                'scope' => $scope,
                'approved_by' => $user->isAdmin() ? $user->id : null,
                'approval_date' => $user->isAdmin() ? now() : null,
                'university_id' => $universityId,
                'content_delivery' => $data['content_delivery'] ?? null,
            ]);

            // Notify users
            if ($event->scope === 'Public') {
                $users = User::all();
            } else {
                $users = User::where('university_id', $event->university_id)->get();
            }

            if ($users->isNotEmpty()) {
                Notification::send($users, new EventCreatedNotification($event));
            }

            return $event;
        });
    }

    public function updateEvent(Event $event, array $data, $user): Event
    {
        return DB::transaction(function () use ($event, $data, $user) {

            if ($user->isAmbassador() && $event->status === 'Approved') {
                throw new \Exception('Ambassadors cannot edit approved events.');
            }

            $status = $user->isAdmin() ? ($data['status'] ?? $event->status) : $event->status;
            $scope = $user->isAdmin() ? ($data['scope'] ?? $event->scope) : $event->scope;

            $event->update([
                ...$data,
                'status' => $status,
                'scope' => $scope,
                'approved_by' => ($user->isAdmin() && isset($data['status']) && in_array($data['status'], ['Approved', 'Rejected'])) ? $user->id : $event->approved_by,
                'approval_date' => ($user->isAdmin() && isset($data['status']) && in_array($data['status'], ['Approved', 'Rejected'])) ? now() : $event->approval_date,
            ]);

            return $event;
        });
    }

    public function deleteEvent(Event $event): void
    {
        $event->delete();
    }

    public function updateEventStatus(Event $event, string $status, $user): Event
    {
        return DB::transaction(function () use ($event, $status, $user) {

            if (!in_array($status, ['Draft', 'PendingApproval', 'Approved', 'Rejected', 'Completed'])) {
                throw new \Exception('Invalid status value.');
            }

            $event->update([
                'status' => $status,
                'approved_by' => ($status === 'Approved') ? $user->id : null,
                'approval_date' => ($status === 'Approved') ? now() : null,
            ]);

            return $event;
        });
    }

    public function listEventsForUser(User $user, ?string $search = null)
    {
        $query = Event::query()->latest(); // orderBy created_at desc

        // Role filtering
        if (! $user->isAdmin()) {
            $query->where('university_id', $user->university_id);
        }

        // Search filtering
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('created_by', 'like', "%{$search}%")
                    ->orWhere('scope', 'like', "%{$search}%");
            });
        }

        return $query->get();
    }

    public function listEventsForQueue(User $user)
    {
        $query = Event::whereIn('status', ['PendingApproval', 'Draft'])->latest();

        if (! $user->isAdmin()) {
            $query->where('university_id', $user->university_id);
        }

        return $query->get();
    }

    public function listApprovedEventsForUsers(User $user)
    {
        return Event::where('status', 'Approved')
            ->where(function ($query) use ($user) {
                $query->where('scope', 'Public')
                    ->orWhere('university_id', $user->university_id);
            })
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getRegistrationData(Event $event, User $user): array
    {
        return [
            'event' => $event,
            'eventRoles' => EventRoles::all(), // better than EventRoles::all()
            'currentUser' => $user,
        ];
    }

    public function registerUserToEvent(Event $event, User $user, int $roleId): void
    {
        DB::transaction(function () use ($event, $user, $roleId) {

            // Prevent duplicate registration
            $alreadyRegistered = ScoreClaim::where('user_id', $user->id)
                ->where('event_id', $event->id)
                ->exists();

            if ($alreadyRegistered) {
                throw new \Exception('User already registered for this event.');
            }

            // Check max participants
            if ($event->actual_participants >= $event->max_participants) {
                throw new \Exception('Event is full.');
            }

            // Create registration
            ScoreClaim::create([
                'user_id' => $user->id,
                'event_id' => $event->id,
                'event_role_id' => $roleId,
                'attendance_status' => 'Registered',
                'points_earned' => 0,
            ]);

            // Increment participants
            $event->increment('actual_participants');
        });
    }

    public function usersEventManagement(Event $event, User $user)
    {
        if ($user->isAdmin()) {
            return ScoreClaim::with('user', 'event', 'eventRole')
                ->where('event_id', $event->id)
                ->get();
        } else {
            return ScoreClaim::with('user', 'event', 'eventRole')
                ->where('event_id', $event->id)
                ->whereHas('user', function ($q) use ($user) {
                    $q->where('university_id', $user->university_id);
                })
                ->get();
        }
    }

    /**
     * Update attendance status and handle score logic */
    public function updateAttendanceStatus(ScoreClaim $scoreClaim, string $newStatus, ?int $pointsEarned = null): array
    {
        // Fetch user and role (same as original)
        $targetUser = User::findOrFail($scoreClaim->user_id);
        $role = EventRoles::findOrFail($scoreClaim->event_role_id);

        // Store old status
        $oldStatus = $scoreClaim->attendance_status;

        // Update model
        $scoreClaim->attendance_status = $newStatus;
        if ($pointsEarned !== null) {
            $scoreClaim->points_earned = $pointsEarned;
        }
        $scoreClaim->save();

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

        $action = null;
        $message = '';

        if ($oldStatus !== 'Attended' && $newStatus === 'Attended') {
            // Add points
            User::where('id', $targetUser->id)->increment('total_user_score', $points);
            University::where('id', $targetUser->university_id)->increment('total_score', $points);
            ScoreClaim::where('id', $scoreClaim->id)->update(['points_earned' => $points]);
            $action = 'added';
            $message = "Status updated to Attended. {$points} points added!";
        } elseif ($oldStatus === 'Attended' && $newStatus !== 'Attended') {
            // Remove points
            User::where('id', $targetUser->id)->decrement('total_user_score', $points);
            University::where('id', $targetUser->university_id)->decrement('total_score', $points);
            $action = 'removed';
            $message = "Status updated. {$points} points removed.";
        } else {
            $action = 'none';
            $message = 'Status updated successfully.';
        }

        return [
            'action' => $action,
            'points' => $points,
            'message' => $message,
        ];
    }

    public function getTopScores()
    {
        $topUsers = User::orderBy('total_user_score', 'desc')->take(10)->get();

        $topUniversities = University::with('users')
            ->orderBy('total_score', 'desc')->take(5)->get();

        return [
            'topUsers' => $topUsers,
            'topUniversities' => $topUniversities,
        ];
    }
}
