<?php

namespace Database\Seeders\Fakes;

use App\Models\Order;
use Illuminate\Database\Seeder;

class FakeOrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::factory()->count(5)->create();
    }
}
