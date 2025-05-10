<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role; // Import the Role model

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate([
            'name' => 'admin',
        ], [
            'description' => 'Administrator with full system access.',
            'is_active' => true,
        ]);

        Role::firstOrCreate([
            'name' => 'evaluator',
        ], [
            'description' => 'User who can evaluate projects.',
            'is_active' => true,
        ]);

        Role::firstOrCreate([
            'name' => 'participant',
        ], [
            'description' => 'User who can submit and manage their projects (e.g., student, researcher).',
            'is_active' => true,
        ]);
    }
}
