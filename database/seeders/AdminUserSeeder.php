<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find or create the 'admin' role
        $adminRole = Role::firstOrCreate(
            ['name' => 'admin'],
            ['description' => 'Administrator with full system access', 'is_active' => true]
        );

        // Create the admin user
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@prometeo.test'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(), // Optional: mark email as verified
                // Add other necessary fields for User model if they don't have defaults
                // 'university' => 'Prometeo University',
                // 'university_position' => 'System Administrator',
                // 'contact_phone' => '1234567890',
            ]
        );

        // Attach the admin role to the user if not already attached
        if (!$adminUser->roles()->where('role_id', $adminRole->id)->exists()) {
            $adminUser->roles()->attach($adminRole->id);
        }

        $this->command->info('Admin user created successfully with email admin@prometeo.test and password "password"');
        $this->command->info('Ensure you have also seeded other necessary roles like "participant" and "evaluator" if your application logic depends on them existing.');
    }
}
