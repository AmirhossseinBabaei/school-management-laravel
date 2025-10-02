<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LessonsSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('fa_IR');

        $baseIds = DB::table('study_bases')->pluck('id')->all();
        if (empty($baseIds)) {
            return;
        }

        $fieldIds = DB::table('study_fields')->pluck('id')->all();

        $lessonNames = ['ریاضی', 'علوم', 'ادبیات', 'زبان', 'فیزیک', 'شیمی', 'تاریخ', 'دینی'];
        $rows = [];
        for ($i = 0; $i < 30; $i++) {
            $rows[] = [
                'study_base_id' => $faker->randomElement($baseIds),
                'study_field_id' => $faker->optional()->randomElement($fieldIds),
                'name' => $faker->randomElement($lessonNames) . ' ' . $faker->randomDigitNotNull(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('lessons')->insert($rows);
    }
}


