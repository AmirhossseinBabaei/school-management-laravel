<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ScheduleTeachersSeeder extends Seeder
{
    public function run(): void
    {
        if (!Schema::hasTable('schedule_teachers')) {
            return;
        }

        $faker = \Faker\Factory::create();

        $schoolIds = DB::table('schools')->pluck('id')->all();
        $classIds = DB::table('classes')->pluck('id')->all();
        $lessonIds = DB::table('lessons')->pluck('id')->all();

        if (empty($schoolIds) || empty($classIds) || empty($lessonIds)) {
            return;
        }

        // ترجیحاً از معلم‌ها استفاده می‌کنیم
        $teacherIds = DB::table('user_roles')
            ->join('roles', 'user_roles.role_id', '=', 'roles.id')
            ->where('roles.name', 'teacher')
            ->pluck('user_roles.user_id')
            ->unique()
            ->values()
            ->all();

        if (empty($teacherIds)) {
            $teacherIds = DB::table('users')->pluck('id')->all();
        }

        $days = ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Thursday', 'Wednesday', 'Friday'];
        $rows = [];
        for ($i = 0; $i < 30; $i++) {
            $startHour = $faker->numberBetween(8, 14);
            $start = sprintf('%02d:%02d:00', $startHour, $faker->randomElement([0, 15, 30, 45]));
            $finish = date('H:i:s', strtotime($start . ' +90 minutes'));
            $rows[] = [
                'teacher_id' => $faker->randomElement($teacherIds),
                'class_id' => $faker->randomElement($classIds),
                'lesson_id' => $faker->randomElement($lessonIds),
                'school_id' => $faker->randomElement($schoolIds),
                'date_week' => $faker->randomElement($days),
                'start_time' => $start,
                'finish_time' => $finish,
                'mode' => $faker->randomElement(['online', 'offline']),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        try {
            DB::table('schedule_teachers')->insert($rows);
        } catch (\Throwable $e) {
            // در صورت مشکل FK (مثلاً عدم وجود جدول teachers) از خطا عبور می‌کنیم
        }
    }
}


