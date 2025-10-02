<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttendancesSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        $schoolIds = DB::table('schools')->pluck('id')->all();
        $studentIds = DB::table('students')->pluck('id')->all();
        $classIds = DB::table('classes')->pluck('id')->all();
        $lessonIds = DB::table('lessons')->pluck('id')->all();
        $userIds = DB::table('users')->pluck('id')->all();
        if (empty($schoolIds) || empty($studentIds) || empty($classIds) || empty($lessonIds) || empty($userIds)) {
            return;
        }

        $rows = [];
        for ($i = 0; $i < 30; $i++) {
            $rows[] = [
                'school_id' => $faker->randomElement($schoolIds),
                'student_id' => $faker->randomElement($studentIds),
                'class_id' => $faker->randomElement($classIds),
                'lesson_id' => $faker->randomElement($lessonIds),
                'status' => $faker->randomElement(['present', 'absent', 'late']),
                'attendance_by_user_id' => $faker->randomElement($userIds),
                'attended_at' => $faker->optional()->dateTimeBetween('-6 months', 'now'),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('attendances')->insert($rows);
    }
}


