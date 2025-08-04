<?php

namespace Database\Factories;

use App\Models\Equipment;
use Illuminate\Database\Eloquent\Factories\Factory;

class EquipmentFactory extends Factory
{
    protected $model = Equipment::class;

    public function definition(): array
    {
        return [
            'application_id' => \App\Models\Application::factory(),
            'name' => $this->faker->word . ' Device',
            'model_brand' => $this->faker->word . ' ' . $this->faker->bothify('Model-###'),
            'serial_number' => strtoupper($this->faker->bothify('SN-#######')),
            'quantity' => $this->faker->numberBetween(1, 10),
        ];
    }
}
