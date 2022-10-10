<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
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
            'description' => $this->faker->sentence,
            'status' => $this->faker->randomElement(Task::getStatuses()),
            'start_at' => $this->faker->dateTimeBetween('-10 days', '-5 days')->format('Y-m-d'),
            'end_at' => $this->faker->dateTimeBetween('-4 days', '+5 days')->format('Y-m-d'),
            'deadline_at' => $this->faker->dateTimeBetween('+6 days', '+7 days')->format('Y-m-d'),
            'order_id' => 1,
            'user_id' => 1,
            'department_id' => 1,
            'author_id' => 2,
            'position' => 1,
        ];
    }
}
