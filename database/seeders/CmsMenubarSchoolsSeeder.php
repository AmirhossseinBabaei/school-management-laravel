<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CmsMenubarSchoolsSeeder extends Seeder
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
            $rows[] = [
                'school_id' => $faker->randomElement($schoolIds),
                'name' => $faker->word(),
                'icon_src' => '/public/icons/' . $faker->randomElement(['home.svg','info.svg','call.svg']),
                'link' => $faker->optional()->url(),
                'type' => $faker->randomElement(['header', 'footer']),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('cms_menubar_schools')->insert($rows);
    }
}


