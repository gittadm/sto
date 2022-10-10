<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    /**
     * @return string
     */
    private function genBornAt(): string
    {
        return $this->faker->dateTimeBetween('-90 years', '-18 years')->format('Y-m-d');
    }

    /**
     * @return array
     */
    private function genPhones(): array
    {
        $phones = [];

        $count = $this->faker->numberBetween(1, 3);

        for ($i = 0; $i < $count; $i++) {
            $phones[] = $this->faker->phoneNumber;
        }

        return $phones;
    }

    /**
     * @return array
     */
    private function genEmails(): array
    {
        $emails = [];

        $count = $this->faker->numberBetween(0, 3);

        for ($i = 0; $i < $count; $i++) {
            $emails[] = $this->faker->email;
        }

        return $emails;
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
            'born_at' => $this->genBornAt(),
            'notes' => $this->faker->sentence,
            'address' => $this->faker->sentence,
            'passport' => $this->faker->sentence,
            'phones' => $this->genPhones(),
            'gender' => $this->faker->boolean(70) ? Client::GENDER_MALE : Client::GENDER_FEMALE,
            'emails' => $this->genEmails(),
            'department_id' => 1,
            'city_id' => 1,
        ];
    }
}
