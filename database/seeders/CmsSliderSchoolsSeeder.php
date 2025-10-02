<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CmsSliderSchoolsSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('fa_IR');

        $rows = [];
        for ($i = 0; $i < 30; $i++) {
            $rows[] = [
                'title' => $faker->sentence(3),
                'description' => $faker->sentence(8),
                'image_src' => '/public/images/slider/' . $faker->uuid . '.jpg',
                'image_type' => 'image/jpeg',
                'image_size' => (string) $faker->numberBetween(100000, 900000),
                'link' => $faker->url(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('cms_slider_schools')->insert($rows);
    }
}


