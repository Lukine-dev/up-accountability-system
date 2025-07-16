<?php

namespace Database\Factories;

use App\Models\Application;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicationFactory extends Factory
{
    protected $model = Application::class;

    public function definition(): array
    {
        return [
            'staff_id' => \App\Models\Staff::factory(),
            'reference_number' => strtoupper($this->faker->unique()->bothify('REF-#####')),
            'application_date' => $this->faker->dateTimeThisYear(),
        ];
    }
}
