<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class EventRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('event_roles')->insert([
            ['name' => 'Organizer', 'points_awarded' => 50],
            ['name' => 'Booth', 'points_awarded' => 30],
            ['name' => 'ContentCreation', 'points_awarded' => 40],
            ['name' => 'MediaCoverage', 'points_awarded' => 20],
            ['name' => 'Volunteer', 'points_awarded' => 15],
            ['name' => 'Participant', 'points_awarded' => 10],
        ]);
    }
}
