<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CarModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => ucfirst($this->faker->word) . ' ' . $this->faker->unique()->numberBetween(1, 1000),
            'car_mark_id' => 1
        ];
    }
}
