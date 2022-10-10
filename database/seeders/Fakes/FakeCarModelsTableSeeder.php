<?php

namespace Database\Seeders\Fakes;

use Illuminate\Database\Eloquent\Factories\Sequence;
use App\Models\CarMark;
use App\Models\CarModel;
use Illuminate\Database\Seeder;

class FakeCarModelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $carMarkIds = CarMark::pluck('id')->toArray();
        array_pop($carMarkIds);

        foreach ($carMarkIds as $carMarkId) {
            CarModel::factory()->count(rand(3, 20))
                ->state(
                    new Sequence(
                        function () use ($carMarkId) {
                            return ['car_mark_id' => $carMarkId];
                        },
                    )
                )->create();
        }
    }
}
