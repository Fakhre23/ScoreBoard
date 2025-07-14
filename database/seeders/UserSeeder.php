<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Fakhre Ambassador Test',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'), // secure password
                'university_id' => 1,
                'phone' => '0790000000',
                'profile_photo' => null,
                'total_user_score' => 0,
                'is_active' => true,
                'user_role' => 2, // Ambassador
            ],
            [
                'name' => 'Student User',
                'email' => 'student@example.com',
                'password' => Hash::make('password'),
                'university_id' => 2,
                'phone' => '0780000000',
                'profile_photo' => null,
                'total_user_score' => 0,
                'is_active' => true,
                'user_role' => 5, // Student
            ]
        ]);
    }
}
