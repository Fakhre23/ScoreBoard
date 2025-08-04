<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\UserHistory;

class StoreUserHistory
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Registered $event): void  // This is triggered when the Registered event occurs.


    {
        UserHistory::create([
            'user_id' => $event->user->id,
            'role_id' => $event->user->user_role,
            'start_date' => now(),
            // 'end_date' => To Do 
            // 'approved_by' => To Do
            // 'approval_status' => To Do 
            'created_at' => now(),

        ]);
    }
}
