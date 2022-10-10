<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MapAnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'answer' => $this->faker->sentence,
            'recommendations' => $this->faker->sentences(5, true),
            'map_question_id' => 1
        ];
    }
}
