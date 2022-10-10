<?php

namespace Database\Seeders\Fakes;

use App\Models\Pipeline;
use Illuminate\Database\Seeder;

class FakePipelinesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pipeline::factory()->count(10)->create();
    }
}
