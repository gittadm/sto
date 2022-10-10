<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * @return string
     */
    private function genBornAt(): string
    {
        return $this->faker->dateTimeBetween('-90 years', '-18 years')->format('Y-m-d');
    }

    /**
     * @return string
     */
    private function genLoginAt(): string
    {
        return $this->faker->dateTimeBetween('-20 days', '-1 days')->format('Y-m-d H:i:s');
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->firstName,
            'surname' => $this->faker->lastName,
            'middle_name' => $this->faker->boolean(20) ? null : $this->faker->firstName .'ович',
            'phone' => $this->faker->phoneNumber,
            'office_position' => $this->faker->word,
            'about' => $this->faker->sentence,
            'is_active' => $this->faker->boolean(90),
            'is_about_visible' =>  $this->faker->boolean(),
            'is_born_at_visible' =>  $this->faker->boolean(),
            'born_at' => $this->genBornAt(),
            'login_at' => $this->genLoginAt(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'department_id' => 1,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
