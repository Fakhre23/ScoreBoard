<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('events')->insert([
            [
                'title' => 'University Scope Event with Draft',
                'description' => 'Welcome event for new students',
                'location' => 'Main Auditorium',
                'start_datetime' => '2024-09-01 10:00:00',
                'end_datetime' => '2024-09-01 12:00:00',
                'max_participants' => 200,
                'created_by' => 8,
                'status' => 'Draft',
                'scope' => 'University',
                'university_id' => 1,
                'approved_by' => null,
                'approval_date' => '2024-08-15 09:00:00',
                'rejection_reason' => "test test test",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Public Scope Event with Approved',
                'description' => 'A seminar on advancements in AI technology',
                'location' => 'Room 101',
                'start_datetime' => '2024-10-15 14:00:00',
                'end_datetime' => '2024-10-15 16:00:00',
                'max_participants' => 100,
                'created_by' => 8,
                'status' => 'Approved',
                'scope' => 'Public',
                'university_id' => null,
                'approved_by' => null,
                'approval_date' => null,
                'rejection_reason' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Another Test Event with PendingApproval',
                'description' => 'Annual career fair with top employers',
                'location' => 'Exhibition Hall',
                'start_datetime' => '2024-11-05 09:00:00',
                'end_datetime' => '2024-11-05 17:00:00',
                'max_participants' => 500,
                'created_by' => 3,
                'status' => 'PendingApproval',
                'scope' => 'University',
                'university_id' => 1,
                'approved_by' => null,
                'approval_date' => null,
                'rejection_reason' => "Event waiting for approval.",
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
