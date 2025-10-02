<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        $users = [];
        for ($i = 0; $i < 30; $i++) {
            $users[] = [
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'avatar_src' => null,
                'avatar_type' => null,
                'otp_code' => null,
                'otp_expire_at' => null,
                'phone' => $faker->unique()->numerify('09#########'),
                'email' => $faker->unique()->safeEmail(),
                'password_hash' => Hash::make('password'),
                'status' => $faker->randomElement(['request', 'active', 'inactive']),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('users')->insert($users);
    }
}


