<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            RoleSeeder::class,
            AdminUserSeeder::class,
            TestDataSeeder::class, // Added for participant and evaluator users
            UserSeeder::class, // For participant and evaluator users
            ProjectTaxonomySeeder::class, // Categories, Themes, Statuses
            EvaluationSetupSeeder::class, // Evaluation Phases and Rubric Criteria
            ProjectSeeder::class, // Projects, documents, participants, evaluators
        ]);
    }
}