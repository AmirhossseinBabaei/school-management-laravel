<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SchoolsSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('fa_IR');

        $schools = [];
        for ($i = 0; $i < 30; $i++) {
            $schools[] = [
                'name' => $faker->company(),
                'description' => $faker->paragraph(2),
                'phone' => $faker->numerify('021########'),
                'address' => $faker->address(),
                'email' => $faker->optional()->companyEmail(),
                'latitude' => $faker->optional()->latitude(25, 40),
                'longitude' => $faker->optional()->longitude(44, 63),
                'uuid' => (string) Str::uuid(),
                'status' => $faker->randomElement(['request', 'active', 'inactive']),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('schools')->insert($schools);
    }
}


