<?php

namespace Database\Seeders\Fakes;

use App\Models\Producer;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class FakeProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $producerIds = Producer::pluck('id')->toArray();

        foreach ($producerIds as $producerId) {
            Product::factory()->count(rand(3, 20))
                ->state(
                    new Sequence(
                        function () use ($producerId) {
                            return ['producer_id' => $producerId];
                        },
                    )
                )->create();
        }
    }
}
