<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CarMarkFactory extends Factory
{
    public $markNames = ['Audi', 'Skoda', 'Alfa Romeo', 'Aston Martin', 'Bentley', 'BMW', 'Москвич'];

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->randomElement($this->markNames) . ' ' .ucfirst($this->faker->unique()->word)
        ];
    }
}
