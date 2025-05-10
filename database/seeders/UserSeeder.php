<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure roles exist (RoleSeeder should run before this)
        $evaluatorRole = Role::where('name', 'evaluator')->first();
        $participantRole = Role::where('name', 'participant')->first();

        if (!$evaluatorRole) {
            $this->command->warn('Evaluator role not found. Please run RoleSeeder first.');
            // Optionally, create it here if preferred, but it's better to manage roles in RoleSeeder
            // $evaluatorRole = Role::firstOrCreate(['name' => 'evaluator'], ['description' => 'Evaluator', 'is_active' => true]);
        }

        if (!$participantRole) {
            $this->command->warn('Participant role not found. Please run RoleSeeder first.');
            // $participantRole = Role::firstOrCreate(['name' => 'participant'], ['description' => 'Participant', 'is_active' => true]);
        }

        // Create Evaluator Users
        if ($evaluatorRole) {
            for ($i = 1; $i <= 2; $i++) {
                $evaluator = User::firstOrCreate(
                    ['email' => "evaluator{$i}@prometeo.test"],
                    [
                        'name' => "Evaluator {$i} User",
                        'password' => Hash::make('password'),
                        'email_verified_at' => now(),
                        'university' => 'Test University',
                        'university_position' => 'Professor',
                        'contact_phone' => '098765432' . $i,
                    ]
                );
                if (!$evaluator->roles()->where('role_id', $evaluatorRole->id)->exists()) {
                    $evaluator->roles()->attach($evaluatorRole->id);
                }
            }
            $this->command->info('Seeded 2 evaluator users.');
        } else {
            $this->command->error('Could not seed evaluator users because evaluator role is missing.');
        }

        // Create Participant Users
        if ($participantRole) {
            for ($i = 1; $i <= 3; $i++) {
                $participant = User::firstOrCreate(
                    ['email' => "participant{$i}@prometeo.test"],
                    [
                        'name' => "Participant {$i} User",
                        'password' => Hash::make('password'),
                        'email_verified_at' => now(),
                        'university' => 'Sample Institute',
                        'university_position' => ($i % 2 == 0) ? 'Student' : 'Researcher', // Mix it up a bit
                        'contact_phone' => '123456789' . $i,
                    ]
                );
                if (!$participant->roles()->where('role_id', $participantRole->id)->exists()) {
                    $participant->roles()->attach($participantRole->id);
                }
            }
            $this->command->info('Seeded 3 participant users.');
        } else {
            $this->command->error('Could not seed participant users because participant role is missing.');
        }
    }
}
