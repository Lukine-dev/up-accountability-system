<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Staff;
use App\Models\Application;
use App\Models\Equipment;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create 20 Staff records
        Staff::factory(20)->create()->each(function ($staff) {
            // For each staff, create 1–2 applications
            $applications = \App\Models\Application::factory(rand(1, 2))->create([
                'staff_id' => $staff->id,
            ]);

            foreach ($applications as $application) {
                // For each application, create 1–3 equipment records
                \App\Models\Equipment::factory(rand(1, 3))->create([
                    'application_id' => $application->id,
                ]);
            }
        });
    }
}