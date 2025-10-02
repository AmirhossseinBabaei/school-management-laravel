<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentsSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        $userIds = DB::table('users')->pluck('id')->all();
        $schoolIds = DB::table('schools')->pluck('id')->all();
        $classIds = DB::table('classes')->pluck('id')->all();
        
        if (empty($userIds) || empty($schoolIds) || empty($classIds)) {
            return;
        }

        $rows = [];
        for ($i = 0; $i < 30; $i++) {
            $rows[] = [
                'school_id' => $faker->randomElement($schoolIds),
                'user_id' => $faker->randomElement($userIds),
                'class_id' => $faker->randomElement($classIds),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('students')->insert($rows);
    }
}


