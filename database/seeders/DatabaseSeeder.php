<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesSeeder::class,
            UsersSeeder::class,
            UserRolesSeeder::class,
            SchoolsSeeder::class,
            ClassesSeeder::class,
            StudyBasesSeeder::class,
            StudyFieldsSeeder::class,
            LessonsSeeder::class,
            UserSchoolsSeeder::class,
            StudentsSeeder::class,
            TermsSeeder::class,
            AttendancesSeeder::class,
            TeacherClassesSeeder::class,
            ScheduleTeachersSeeder::class,
            GradesSeeder::class,
            CmsMenubarSchoolsSeeder::class,
            CmsSliderSchoolsSeeder::class,
            CmsContentsSchoolsSeeder::class,
            CmsCommentsSchoolsSeeder::class,
        ]);
    }
}
