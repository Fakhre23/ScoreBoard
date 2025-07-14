<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class StandardUserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('standard_user_role')->insert([
            ['name' => 'Admin'],
            ['name' => 'student'],
            ['name' => 'Ambassador'],
            ['name' => 'ViceAmbassador'],
            ['name' => 'Representative'],
        ]);
    }
}
