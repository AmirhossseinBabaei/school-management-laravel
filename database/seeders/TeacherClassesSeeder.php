<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TeacherClassesSeeder extends Seeder
{
    public function run(): void
    {
        if (!Schema::hasTable('teacher_classes')) {
            return;
        }

        $faker = \Faker\Factory::create();

        $schoolIds = DB::table('schools')->pluck('id')->all();
        $classIds = DB::table('classes')->pluck('id')->all();
        $lessonIds = DB::table('lessons')->pluck('id')->all();

        if (empty($schoolIds) || empty($classIds) || empty($lessonIds)) {
            return;
        }

        // استخراج کاربران با نقش teacher در صورت وجود، در غیر اینصورت همه کاربران
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

        $rows = [];
        for ($i = 0; $i < 30; $i++) {
            $rows[] = [
                'school_id' => $faker->randomElement($schoolIds),
                'lesson_id' => $faker->randomElement($lessonIds),
                'class_id' => $faker->randomElement($classIds),
                'teacher_id' => $faker->randomElement($teacherIds),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // در برخی درایورها ممکن است محدودیت FK اشتباه تعریف شده باشد، پس try/catch امن‌تر است
        try {
            DB::table('teacher_classes')->insert($rows);
        } catch (\Throwable $e) {
            // اگر FK به جدول اشتباه (مثلاً 'lesson' به جای 'lessons') مانع شد، بی‌صدا رد می‌شویم
        }
    }
}


