<?php

namespace Database\Seeders\Fakes;

use App\Models\City;
use App\Models\Client;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class FakeClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cityIds = City::pluck('id')->toArray();
        $cityIds[] = null;
        $departmentIds = Department::pluck('id')->toArray();

        Client::factory()->count(10)
            ->state(
                new Sequence(
                    function () use ($departmentIds, $cityIds) {
                        return [
                            'department_id' => Arr::random($departmentIds),
                            'city_id' => Arr::random($cityIds),
                        ];
                    },
                )
            )->create();
    }
}
