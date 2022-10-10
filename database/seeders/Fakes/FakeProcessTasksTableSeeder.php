<?php

namespace Database\Seeders\Fakes;

use App\Models\ProcessCategory;
use App\Models\ProcessTask;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use App\Models\User;

class FakeProcessTasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userIds = User::limit(10)->pluck('id')->toArray();

        ProcessTask::factory()->count(40)
            ->state(
                new Sequence(
                    function ($sequence) use ($userIds) {
                        return [
                            'user_id' => Arr::random($userIds),
                            'position' => $sequence->index
                        ];
                    },
                )
            )->create();
    }
}
