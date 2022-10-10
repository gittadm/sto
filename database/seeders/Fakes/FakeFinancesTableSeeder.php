<?php

namespace Database\Seeders\Fakes;

use App\Models\Finance;
use App\Models\FinanceGroup;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class FakeFinancesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $financeGroupIds = FinanceGroup::pluck('id')->toArray();

        foreach ($financeGroupIds as $financeGroupId) {
            Finance::factory()->count(rand(3, 20))
                ->state(
                    new Sequence(
                        function () use ($financeGroupId) {
                            return ['finance_group_id' => $financeGroupId];
                        },
                    )
                )->create();
        }
    }
}
