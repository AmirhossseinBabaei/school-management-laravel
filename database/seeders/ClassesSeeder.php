<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassesSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('fa_IR');

        $schoolIds = DB::table('schools')->pluck('id')->all();
        if (empty($schoolIds)) {
            return;
        }

        $rows = [];
        for ($i = 0; $i < 30; $i++) {
            $rows[] = [
                'school_id' => $faker->randomElement($schoolIds),
                'name' => 'کلاس ' . $faker->randomNumber(2),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('classes')->insert($rows);
    }
}


