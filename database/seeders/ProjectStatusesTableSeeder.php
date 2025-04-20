<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ProjectStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('project_statuses')->insert([
            ['name' => 'Submitted', 'description' => 'Project has been submitted', 'sequence_order' => 1, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Under Review', 'description' => 'Project is being reviewed', 'sequence_order' => 2, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Needs Correction', 'description' => 'Project needs corrections', 'sequence_order' => 3, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Approved', 'description' => 'Project has been approved', 'sequence_order' => 4, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Rejected', 'description' => 'Project has been rejected', 'sequence_order' => 5, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'First Evaluation Completed', 'description' => 'Written evaluation has been completed', 'sequence_order' => 6, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Awaiting Final Presentation', 'description' => 'Project is awaiting oral presentation', 'sequence_order' => 7, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Final Evaluation Completed', 'description' => 'All evaluations have been completed', 'sequence_order' => 8, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
