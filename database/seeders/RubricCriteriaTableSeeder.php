<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RubricCriteriaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed sample rubric criteria for written phase
        DB::table('rubric_criteria')->insert([
            ['evaluation_phase_id' => 1, 'name' => 'Organization', 'description' => 'Structure and organization of the document', 'max_score' => 10.00, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['evaluation_phase_id' => 1, 'name' => 'Content', 'description' => 'Quality and relevance of content', 'max_score' => 15.00, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['evaluation_phase_id' => 1, 'name' => 'Methodology', 'description' => 'Appropriateness of research methodology', 'max_score' => 15.00, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['evaluation_phase_id' => 1, 'name' => 'Results', 'description' => 'Quality of results and analysis', 'max_score' => 15.00, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['evaluation_phase_id' => 1, 'name' => 'References', 'description' => 'Quality and relevance of references', 'max_score' => 5.00, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
        // Seed sample rubric criteria for oral phase
        DB::table('rubric_criteria')->insert([
            ['evaluation_phase_id' => 2, 'name' => 'Presentation Skills', 'description' => 'Clarity and effectiveness of presentation', 'max_score' => 10.00, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['evaluation_phase_id' => 2, 'name' => 'Visual Aids', 'description' => 'Quality and relevance of visual materials', 'max_score' => 10.00, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['evaluation_phase_id' => 2, 'name' => 'Knowledge Demonstration', 'description' => 'Demonstrated understanding of the project', 'max_score' => 15.00, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['evaluation_phase_id' => 2, 'name' => 'Response to Questions', 'description' => 'Quality of responses to evaluator questions', 'max_score' => 15.00, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
