<?php

namespace Database\Seeders\Fakes;

use App\Models\Checkbox;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class FakeCheckboxesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $taskIds = Task::pluck('id')->toArray();

        foreach ($taskIds as $taskId) {
            Checkbox::factory()->count(rand(3, 20))
                ->state(
                    new Sequence(
                        function () use ($taskId) {
                            return ['task_id' => $taskId];
                        },
                    )
                )->create();
        }
    }
}
