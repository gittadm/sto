<?php

namespace Database\Seeders\Fakes;

use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use App\Models\Comment;
use App\Models\Task;
use App\Models\User;

class FakeCommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $taskIds = Task::pluck('id')->toArray();
        $userIds = User::limit(10)->pluck('id')->toArray();

        Comment::factory()->count(50)
            ->state(
                new Sequence(
                    function () use ($taskIds, $userIds) {
                        return [
                            'user_id' => Arr::random($userIds),
                            'commentable_id' => Arr::random($taskIds),
                            'commentable_type' => 'App\Models\Task',
                        ];
                    },
                )
            )->create();
    }
}
