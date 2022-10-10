<?php

namespace Database\Seeders\Fakes;

use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use App\Models\Pipeline;
use App\Models\Stage;

class FakeStagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pipelineIds = Pipeline::pluck('id')->toArray();

        foreach ($pipelineIds as $pipelineId) {
            Stage::factory()->count(rand(3, 20))
                ->state(
                    new Sequence(
                        function () use ($pipelineId) {
                            return ['pipeline_id' => $pipelineId];
                        },
                    )
                )->create();
        }
    }
}
