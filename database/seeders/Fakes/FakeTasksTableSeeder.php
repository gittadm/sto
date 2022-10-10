<?php

namespace Database\Seeders\Fakes;

use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use App\Models\Department;
use App\Models\Order;
use App\Models\Task;
use App\Models\User;

class FakeTasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userIds = User::limit(10)->pluck('id')->toArray();
        $departmentIds = Department::pluck('id')->toArray();
        $orderIds = Order::pluck('id')->toArray();

        Task::factory()->count(40)
            ->state(
                new Sequence(
                    function ($sequence) use ($userIds, $departmentIds, $orderIds) {
                        return [
                            'author_id' => Arr::random($userIds),
                            'user_id' => Arr::random($userIds),
                            'department_id' => Arr::random($departmentIds),
                            'order_id' => Arr::random($orderIds),
                            'position' => $sequence->index + 1
                        ];
                    },
                )
            )->create();
    }
}
