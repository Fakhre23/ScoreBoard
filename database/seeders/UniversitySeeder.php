<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class UniversitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::Table('universities')->insert([
            ['name' => 'University of Jordan', 'country' => 'Jordan', 'total_score' => 0, 'UNI_photo' => NULL],
            ['name' => 'Amman Arab Univeristy', 'country' => 'Jordan', 'total_score' => 0, 'UNI_photo' => NULL],

        ]);
    }
}
