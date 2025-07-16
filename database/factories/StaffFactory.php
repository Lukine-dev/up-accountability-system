<?php

namespace Database\Factories;

use App\Models\Staff;
use Illuminate\Database\Eloquent\Factories\Factory;

class StaffFactory extends Factory
{
    protected $model = Staff::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'system_office' => $this->faker->company,
            'designation' => $this->faker->jobTitle,
            'department' => $this->faker->word,
            'password' => bcrypt('password'), // Or use Hash::make()
            'status' => $this->faker->randomElement(['active', 'resigned']),
        ];
    }
}
