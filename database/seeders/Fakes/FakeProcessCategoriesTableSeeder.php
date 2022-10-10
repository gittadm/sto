<?php

namespace Database\Seeders\Fakes;

use App\Models\AppealReason;
use App\Models\ProcessCategory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class FakeProcessCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $appealReasonIds = AppealReason::pluck('id')->toArray();

        foreach ($appealReasonIds as $appealReasonId) {
            ProcessCategory::factory()->count(rand(3, 20))
                ->state(
                    new Sequence(
                        function () use ($appealReasonId) {
                            return ['appeal_reason_id' => $appealReasonId];
                        },
                    )
                )->create();
        }
    }
}
