<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            ['name' => 'admin', 'description' => 'System administrator', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'evaluator', 'description' => 'Project evaluator', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'participant', 'description' => 'Project participant', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
