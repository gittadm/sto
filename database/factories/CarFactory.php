<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CarFactory extends Factory
{
    /**
     * @return string
     */
    private function genVin(): string
    {
        $vin = $this->faker->randomLetter.$this->faker->randomLetter.$this->faker->randomLetter;

        $vin .= $this->faker->numberBetween(1000000, 9999999);
        $vin .= $this->faker->numberBetween(1000000, 9999999);

        return Str::upper($vin);
    }

    /**
     * @return string
     */
    private function genNumber(): string
    {
        $number = $this->faker->randomLetter;
        $number .= $this->faker->numberBetween(100, 999);
        $number .= $this->faker->randomLetter;
        $number .= $this->faker->randomLetter;
        $number .= $this->faker->numberBetween(10, 99);
        $number .= $this->faker->randomElement(['RUS', 'KZ', 'AZ', 'UA', 'BG', 'BY']);

        return Str::upper($number);
    }

    /**
     * @return string
     */
    private function genBody(): string
    {
        return $this->faker->randomElement(
            [
                'Купе', 'Седан', 'Кабриолет', 'Пикап', 'Универсал', 'Лифтбек', 'Внедорожник'
            ]
        );
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'vin' => $this->faker->boolean(90)
                ? $this->genVin() : null,
            'number' => $this->genNumber(),
            'year' => $this->faker->boolean(90)
                ? $this->faker->numberBetween('1980', '2022') : null,
            'body' => $this->faker->boolean(90)
                ? $this->genBody() : null,
            'color' => $this->faker->boolean(90) ? $this->faker->colorName : null,
            'notes' => $this->faker->boolean(90) ? $this->faker->sentence : null,
            'fuel_id' => 1,
            'engine_volume_id' => 1,
            'client_id' => 1,
            'car_model_id' => 1
        ];
    }
}
