<?php

namespace Database\Seeders\Fakes;

use App\Models\FinanceGroup;
use Illuminate\Database\Seeder;

class FakeFinanceGroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FinanceGroup::factory()->count(10)->create();
    }
}
