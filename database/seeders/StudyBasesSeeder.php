<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudyBasesSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('fa_IR');

        $rows = [];
        for ($i = 1; $i <= 30; $i++) {
            $rows[] = [
                'name' => 'پایه ' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('study_bases')->insert($rows);
    }
}


