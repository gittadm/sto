<?php

namespace Database\Seeders\Fakes;

use App\Models\Car;
use App\Models\CarModel;
use App\Models\Client;
use App\Models\EngineVolume;
use App\Models\Fuel;
use Faker\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class FakeCarsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('ru_RU');

        $clientIds = Client::pluck('id')->toArray();
        $fuelIds = Fuel::pluck('id')->toArray();
        $engineVolumeIds = EngineVolume::pluck('id')->toArray();
        $carModelIds = CarModel::pluck('id')->toArray();

        foreach ($clientIds as $clientId) {
            Car::factory()->count($faker->numberBetween(1, 5))
                ->state(
                    new Sequence(
                        function () use ($fuelIds, $engineVolumeIds, $carModelIds, $clientId, &$faker) {
                            return [
                                'fuel_id' => $faker->boolean(90) ?
                                    $faker->randomElement($fuelIds) : null,
                                'engine_volume_id' => $faker->boolean(90) ?
                                    $faker->randomElement($engineVolumeIds) : null,
                                'car_model_id' => $faker->randomElement($carModelIds),
                                'client_id' => $clientId
                            ];
                        },
                    )
                )->create();
        }
    }
}
