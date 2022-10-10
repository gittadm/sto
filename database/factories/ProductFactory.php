<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => ucfirst($this->faker->word),
            'place' => $this->faker->boolean(90) ? $this->faker->randomFloat(1, 1, 100) : null,
            'count' => $this->faker->numberBetween(10, 1000),
            'input_sum' => 100 * $this->faker->numberBetween(1000, 2000),
            'output_sum' => 100 * $this->faker->numberBetween(2000, 2500),
            'description' => $this->faker->sentences(20, true),
            'sku' => $this->faker->boolean(90) ? $this->faker->uuid : null,
            'producer_id' => 1,
        ];
    }
}
