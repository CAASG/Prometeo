<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure 'participant' role exists
        $participantRole = Role::firstOrCreate(
            ['name' => 'participant'],
            ['description' => 'User who can submit and manage their projects', 'is_active' => true]
        );

        // Create a participant user
        $participantUser = User::firstOrCreate(
            ['email' => 'participant@prometeo.test'],
            [
                'name' => 'Participant User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'university' => 'Test University',
                'university_position' => 'Student',
                'contact_phone' => '1234567890',
            ]
        );

        // Attach the participant role to the user if not already attached
        if (!$participantUser->roles()->where('role_id', $participantRole->id)->exists()) {
            $participantUser->roles()->attach($participantRole->id);
        }
        $this->command->info('Participant user created/verified: participant@prometeo.test (password: password)');

        // Ensure 'evaluator' role exists
        $evaluatorRole = Role::firstOrCreate(
            ['name' => 'evaluator'],
            ['description' => 'User who can review and evaluate projects', 'is_active' => true]
        );

        // Create an evaluator user
        $evaluatorUser = User::firstOrCreate(
            ['email' => 'evaluator@prometeo.test'],
            [
                'name' => 'Evaluator User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'university' => 'Review Board University',
                'university_position' => 'Professor',
                'contact_phone' => '0987654321',
            ]
        );

        // Attach the evaluator role to the user if not already attached
        if (!$evaluatorUser->roles()->where('role_id', $evaluatorRole->id)->exists()) {
            $evaluatorUser->roles()->attach($evaluatorRole->id);
        }
        $this->command->info('Evaluator user created/verified: evaluator@prometeo.test (password: password)');
    }
} 