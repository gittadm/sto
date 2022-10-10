<?php

namespace Database\Seeders\Fakes;

use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use App\Models\MapQuestion;
use Illuminate\Support\Arr;
use App\Models\MapAnswer;

class FakeMapQuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MapQuestion::factory()->count(25)->create();
        $mapQuestionIds = MapQuestion::pluck('id')->toArray();

        MapAnswer::factory()->count(100)
            ->state(
                new Sequence(
                    function () use ($mapQuestionIds) {
                        return [
                            'map_question_id' => Arr::random($mapQuestionIds),
                        ];
                    },
                )
            )->create();
    }
}
