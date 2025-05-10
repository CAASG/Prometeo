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
        $this->call([
            RolesTableSeeder::class,
            ProjectCategoriesTableSeeder::class,
            ProjectThemesTableSeeder::class,
            ProjectStatusesTableSeeder::class,
            EvaluationPhasesTableSeeder::class,
            RubricCriteriaTableSeeder::class,
            AdminUserSeeder::class,
        ]);

        // Consider if this generic User::factory() call is still needed
        // now that AdminUserSeeder creates a specific admin and test user.
        // If you want other random users, keep it. Otherwise, you might remove it
        // or make it conditional.
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}