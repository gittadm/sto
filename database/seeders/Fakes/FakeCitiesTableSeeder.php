<?php

namespace Database\Seeders\Fakes;

use App\Models\City;
use Illuminate\Database\Seeder;

class FakeCitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        City::factory()->count(100)->create();
    }
}
