<?php

namespace Database\Seeders\Fakes;

use App\Models\AppealReason;
use Illuminate\Database\Seeder;

class FakeAppealReasonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AppealReason::factory()->count(25)->create();
    }
}
