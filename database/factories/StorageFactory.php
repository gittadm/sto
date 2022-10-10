<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StorageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => ucfirst($this->faker->word) .'-'. $this->faker->unique()->numberBetween(1, 10000),
            'city_id' => 1
        ];
    }
}
