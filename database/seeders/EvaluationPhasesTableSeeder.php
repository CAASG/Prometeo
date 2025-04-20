<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EvaluationPhasesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('evaluation_phases')->insert([
            ['name' => 'Written Phase', 'description' => 'Evaluation of written component', 'sequence_order' => 1, 'weight' => 60.00, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Oral Phase', 'description' => 'Evaluation of oral presentation', 'sequence_order' => 2, 'weight' => 40.00, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
