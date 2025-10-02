<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CmsContentsSchoolsSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('fa_IR');

        $schoolIds = DB::table('schools')->pluck('id')->all();
        $userIds = DB::table('users')->pluck('id')->all();

        if (empty($schoolIds)) {
            return;
        }

        $rows = [];
        for ($i = 0; $i < 30; $i++) {
            $status = $faker->randomElement(['draft', 'published', 'rejected']);
            $publishAt = $status === 'published' ? $faker->dateTimeBetween('-1 year', 'now') : null;
            $rejectAt = $status === 'rejected' ? $faker->dateTimeBetween('-1 year', 'now') : null;

            $rows[] = [
                'school_id' => $faker->randomElement($schoolIds),
                'published_by_user_id' => $status === 'published' ? $faker->randomElement($userIds) : null,
                'rejected_by_user_id' => $status === 'rejected' ? $faker->randomElement($userIds) : null,
                'title' => $faker->sentence(4),
                'body' => $faker->paragraph(5),
                'type' => $faker->randomElement(['news', 'post']),
                'status' => $status,
                'publish_at' => $publishAt,
                'reject_at' => $rejectAt,
                'uuid' => (string) Str::uuid(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('cms_contents_schools')->insert($rows);
    }
}


