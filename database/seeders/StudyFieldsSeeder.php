<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudyFieldsSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('fa_IR');

        $baseIds = DB::table('study_bases')->pluck('id')->all();
        if (empty($baseIds)) {
            return;
        }

        $names = ['ریاضی', 'تجربی', 'انسانی', 'فنی', 'هنر', 'زبان'];
        $rows = [];
        for ($i = 0; $i < 30; $i++) {
            $rows[] = [
                'study_base_id' => $faker->randomElement($baseIds),
                'name' => $faker->randomElement($names) . ' ' . $faker->randomDigit(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('study_fields')->insert($rows);
    }
}


