<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSchoolsSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        $userIds = DB::table('users')->pluck('id')->all();
        $schoolIds = DB::table('schools')->pluck('id')->all();
        if (empty($userIds) || empty($schoolIds)) {
            return;
        }

        $rows = [];
        for ($i = 0; $i < 30; $i++) {
            $rows[] = [
                'user_id' => $faker->randomElement($userIds),
                'school_id' => $faker->randomElement($schoolIds),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('user_schools')->insert($rows);
    }
}


