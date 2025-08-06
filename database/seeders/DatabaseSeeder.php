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
   
        // Uncomment the following lines to seed the database with sample data
        // Staff::factory(100)->create()->each(function ($staff) {
        
        //     $applications = \App\Models\Application::factory(rand(1, 2))->create([
        //         'staff_id' => $staff->id,
        //     ]);

        //     foreach ($applications as $application) {
            
        //         \App\Models\Equipment::factory(rand(1, 3))->create([
        //             'application_id' => $application->id,
        //         ]);
        //     }
        // });

        $this->call([
        SuperUserSeeder::class,
        ]);
    }
}