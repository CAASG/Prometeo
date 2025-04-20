<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ProjectCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('project_categories')->insert([
            ['name' => 'Course', 'description' => 'Project developed as part of a course', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Finished', 'description' => 'Completed project', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Proposal', 'description' => 'Project proposal', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
