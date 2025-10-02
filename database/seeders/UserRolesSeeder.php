<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRolesSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        $userIds = DB::table('users')->pluck('id')->all();
        $roleIds = DB::table('roles')->pluck('id')->all();
        if (empty($userIds) || empty($roleIds)) {
            return;
        }

        $rows = [];
        for ($i = 0; $i < 30; $i++) {
            $rows[] = [
                'user_id' => $faker->randomElement($userIds),
                'role_id' => $faker->randomElement($roleIds),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('user_roles')->insert($rows);
    }
}


