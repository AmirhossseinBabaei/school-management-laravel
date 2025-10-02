<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class GradesSeeder extends Seeder
{
    public function run(): void
    {
        if (!Schema::hasTable('grades')) {
            return;
        }

        $faker = \Faker\Factory::create();

        $studentIds = DB::table('students')->pluck('id')->all();
        $lessonIds = DB::table('lessons')->pluck('id')->all();
        $classIds = DB::table('classes')->pluck('id')->all();
        $termIds = DB::table('terms')->pluck('id')->all();
        $schoolIds = DB::table('schools')->pluck('id')->all();

        if (empty($studentIds) || empty($lessonIds) || empty($classIds) || empty($termIds) || empty($schoolIds)) {
            return;
        }

        $teacherUserIds = DB::table('user_roles')
            ->join('roles', 'user_roles.role_id', '=', 'roles.id')
            ->where('roles.name', 'teacher')
            ->pluck('user_roles.user_id')
            ->unique()
            ->values()
            ->all();
        if (empty($teacherUserIds)) {
            $teacherUserIds = DB::table('users')->pluck('id')->all();
        }

        $rows = [];
        for ($i = 0; $i < 30; $i++) {
            $rows[] = [
                'student_id' => $faker->randomElement($studentIds),
                'lesson_id' => $faker->randomElement($lessonIds),
                'class_id' => $faker->randomElement($classIds),
                'teacher_id' => $faker->randomElement($teacherUserIds),
                'term_id' => $faker->randomElement($termIds),
                'school_id' => $faker->randomElement($schoolIds),
                'score' => $faker->numberBetween(0, 20),
                'description' => $faker->optional()->sentence(8),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        try {
            DB::table('grades')->insert($rows);
        } catch (\Throwable $e) {
        }
    }
}


