<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'client_id' => 1,
            'car_id' => 1,
            'appeal_reason_id' => 1,
            'department_id' => 1
        ];
    }
}
