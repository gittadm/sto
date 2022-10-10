<?php

namespace App\Services\Tasks;

use App\Models\Task;

class TaskStatusService
{
    /**
     * @param  Task  $task
     * @param  array  $data
     * @return Task
     */
    public function updateStatusToProcess(Task $task, array $data): Task
    {
        if (empty($data['start_at'])) {
            $data['start_at'] = now()->toDateString();
        }

        $data['status'] = Task::STATUS_PROCESS;

        $task->update($data);

        return $task;
    }

    /**
     * @param  Task  $task
     * @param  array  $data
     * @return Task
     */
    public function updateStatusToDone(Task $task, array $data): Task
    {
        if (empty($data['end_at'])) {
            $data['end_at'] = now()->toDateString();
        }

        $data['status'] = Task::STATUS_DONE;

        $task->update($data);

        return $task;
    }

    /**
     * @param  Task  $task
     * @return Task
     */
    public function updateStatusToPause(Task $task): Task
    {
        $task->update(['status' => Task::STATUS_PAUSE]);

        return $task;
    }

    /**
     * @param  Task  $task
     * @param  array  $data
     * @return Task
     */
    public function updateStatus(Task $task, array $data): Task
    {
        $task->update($data);

        return $task;
    }
}
