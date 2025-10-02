<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'admin', 'status' => 'active'],
            ['name' => 'teacher', 'status' => 'active'],
            ['name' => 'student', 'status' => 'active'],
        ];

        foreach ($roles as &$role) {
            $role['created_at'] = now();
            $role['updated_at'] = now();
        }

        DB::table('roles')->insert($roles);
    }
}


