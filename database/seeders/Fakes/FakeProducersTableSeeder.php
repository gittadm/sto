<?php

namespace Database\Seeders\Fakes;

use App\Models\Producer;
use Illuminate\Database\Seeder;

class FakeProducersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Producer::factory()->count(10)->create();
    }
}
