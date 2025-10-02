<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CmsCommentsSchoolsSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('fa_IR');

        $userIds = DB::table('users')->pluck('id')->all();
        $contentIds = DB::table('cms_contents_schools')->pluck('id')->all();
        $schoolIds = DB::table('schools')->pluck('id')->all();

        if (empty($userIds) || empty($contentIds)) {
            return;
        }

        $rows = [];
        for ($i = 0; $i < 30; $i++) {
            $status = $faker->randomElement(['draft', 'published', 'rejected']);
            $rows[] = [
                'user_id' => $faker->randomElement($userIds),
                'content_id' => $faker->randomElement($contentIds),
                'published_by_user_id' => $status === 'published' ? $faker->randomElement($userIds) : null,
                'rejected_by_user_id' => $status === 'rejected' ? $faker->randomElement($userIds) : null,
                'school_id' => $faker->optional()->randomElement($schoolIds),
                'body' => $faker->sentence(12),
                'status' => $status,
                'publish_at' => $status === 'published' ? $faker->dateTimeBetween('-1 year', 'now') : null,
                'reject_at' => $status === 'rejected' ? $faker->dateTimeBetween('-1 year', 'now') : null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('cms_comments_schools')->insert($rows);
    }
}


