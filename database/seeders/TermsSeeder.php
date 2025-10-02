<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TermsSeeder extends Seeder
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
            $from = $faker->dateTimeBetween('-2 years', 'now');
            $to = (clone $from)->modify('+4 months');
            $rows[] = [
                'school_id' => $faker->randomElement($schoolIds),
                'name' => 'ترم ' . $faker->numberBetween(1, 3),
                'study_year' => (int) $from->format('Y'),
                'from_date' => $from->format('Y-m-d'),
                'to_date' => $to->format('Y-m-d'),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('terms')->insert($rows);
    }
}


