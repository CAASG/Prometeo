<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ProjectThemesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('project_themes')->insert([
            ['name' => 'Computer Science', 'description' => 'Projects related to computer science and programming', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mechanical Engineering', 'description' => 'Projects related to mechanical engineering', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Electrical Engineering', 'description' => 'Projects related to electrical engineering', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Biotechnology', 'description' => 'Projects related to biotechnology', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Environmental Science', 'description' => 'Projects related to environmental science', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
