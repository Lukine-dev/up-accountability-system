<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // or use your custom User model path
use Illuminate\Support\Facades\Hash;

class SuperUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if superuser already exists to avoid duplication
        if (!User::where('email', 'admin@example.com')->exists()) {
            User::create([
                'name' => 'Super Admin',
                'email' => 'up-accountability-admin@admin.com',
                'password' => Hash::make('administrator_na_pogi'), // Change this to a secure password
                'email_verified_at' => now(),
            ]);
        }
    }
}