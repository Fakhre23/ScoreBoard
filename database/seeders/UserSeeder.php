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
                'name' => 'Ambassador Test',
                'email' => 'Ambassador@example.com',
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
            ],
            [
                'name' => 'Not active User',
                'email' => 'notActive@example.com',
                'password' => Hash::make('password'),
                'university_id' => 2,
                'phone' => '0780000000',
                'profile_photo' => null,
                'total_user_score' => 0,
                'is_active' => false,
                'user_role' => 4, // Student
            ],
            [
                'name' => 'Representative User',
                'email' => 'representative@example.com',
                'password' => Hash::make('password'),
                'university_id' => 2,
                'phone' => '0780000000',
                'profile_photo' => null,
                'total_user_score' => 0,
                'is_active' => true,
                'user_role' => 4,

            ],
            [
                'name' => 'Vice User',
                'email' => 'vice@example.com',
                'password' => Hash::make('password'),
                'university_id' => 2,
                'phone' => '0780000000',
                'profile_photo' => null,
                'total_user_score' => 0,
                'is_active' => true,
                'user_role' => 3,
            ],
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'university_id' => 2,
                'phone' => '0780000000',
                'profile_photo' => null,
                'total_user_score' => 0,
                'is_active' => true,
                'user_role' => 1,
            ]


        ]);
    }
}
