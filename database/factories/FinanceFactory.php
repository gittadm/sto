<?php

namespace Database\Factories;

use App\Models\Finance;
use Illuminate\Database\Eloquent\Factories\Factory;

class FinanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => ucfirst($this->faker->unique()->word),
            'operation_type' => $this->faker->randomElement([Finance::OPERATION_INPUT, Finance::OPERATION_OUTPUT]),
            'sum' => 100 * $this->faker->numberBetween(1000, 10000),
            'finance_group_id' => 1
        ];
    }
}
