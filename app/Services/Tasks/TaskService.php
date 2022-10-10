<?php

namespace App\Services\Tasks;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Exceptions\CustomValidationException;
use App\Exceptions\UsedInOtherTableException;
use App\Models\Checkbox;
use App\Models\TempFile;
use App\Models\Stage;
use App\Models\User;
use App\Models\Task;
use Throwable;
use DB;

class TaskService
{
    /**
     * @param  array  $filter
     * @param  array  $permissions
     * @return LengthAwarePaginator
     */
    public function getPaginatedTasks(array $filter, array $permissions): LengthAwarePaginator
    {
        $tasks = Task::with('user', 'author', 'department', 'order', 'checkboxes',
                            'pipelineTasks.pipeline',  'pipelineTasks.stage');

        if (!empty($permissions['department_id'])) {
            $tasks->where('department_id', $permissions['department_id']);
        }

        if (!empty($permissions['user_id'])) {
            $tasks->where(function ($query) use ($permissions) {
                $query->where('user_id', $permissions['user_id'])
                    ->orWhere('author_id', $permissions['user_id']);
            });
        }

        if (!empty($filter['name'])) {
            $tasks->where('name', 'like', '%'.$filter['name'].'%');
        }

        if (!empty($filter['status'])) {
            $tasks->where('status', $filter['status']);
        }

        if (!empty($filter['pipeline_id'])) {
            $tasks->whereHas('pipelineTasks', function ($query) use ($filter) {
                $query->where('pipeline_id', $filter['pipeline_id']);
            });
        }

        if (!empty($filter['user_id'])) {
            $tasks->where('user_id', $filter['user_id']);
        }

        if (!empty($filter['order_id'])) {
            $tasks->where('order_id', $filter['order_id']);
        }

        if (!empty($filter['department_id'])) {
            $tasks->where('department_id', $filter['department_id']);
        }

        if (!empty($filter['order'])) {
            if ($filter['order'] === 'name') {
                $tasks->orderBy('name');
            } elseif ($filter['order'] === 'status') {
                $tasks->orderBy('status');
            } elseif ($filter['order'] === 'user_id') {
                $tasks->orderBy('user_id');
            } elseif ($filter['order'] === 'create_date') {
                $tasks->orderBy('created_at', 'desc');
            } elseif ($filter['order'] === 'start_date') {
                $tasks->orderBy('start_at');
            } elseif ($filter['order'] === 'end_date') {
                $tasks->orderBy('end_at');
            } else { // id or other
                $tasks->orderBy('id', 'desc');
            }
        } else {
            $tasks->orderBy('id', 'desc');
        }

        return $tasks->paginate(30);
    }

    /**
     * @param  int  $userId
     * @param  Task  $task
     * @param  array|null  $tempFileIds
     */
    private function storeFiles(int $userId, Task $task, ?array $tempFileIds): void
    {
        if (empty($tempFileIds)) {
            return;
        }

        $tempFiles = TempFile::where('user_id', $userId)->whereIn('id', $tempFileIds)->orderBy('id')->get();

        foreach ($tempFiles as $tempFile) {
            try {
                $task->addMedia($tempFile->getFirstMedia('temp')->getPath())
                    ->usingName($tempFile->getFirstMedia('temp')->name)
                    ->toMediaCollection('files', Task::FILES_DISK);
                $tempFile->delete();
            } catch (Throwable $e) {
                info('Не удалось добавить временный файл к задаче', [$e->getTraceAsString()]);
            }
        }
    }

    /**
     * @param  int  $userId
     * @return int
     */
    private function getUserDepartmentId(int $userId): int
    {
        return User::where('id', $userId)->firstOrFail()->department_id;
    }

    /**
     * @param  int  $pipelineId
     * @return int|null
     */
    private function getPipelineFirstStageId(int $pipelineId): ?int
    {
        return Stage::where('pipeline_id', $pipelineId)->first()->id ?? null;
    }

    /**
     * @param  int  $pipelineId
     * @param  int  $stageId
     * @return bool
     */
    private function isExistsPipelineStage(int $pipelineId, int $stageId): bool
    {
        return Stage::where('pipeline_id', $pipelineId)->where('stage_id', $stageId)->exists();
    }

    /**
     * @param  array  $data
     * @return array
     * @throws CustomValidationException
     */
    private function preparePipelines(array $data): array
    {
        $pipelines = [];

        if (!empty($data['pipelines'])) {
            foreach ($data['pipelines'] as $pipelineData) {
                if (empty($pipelineData['stage_id'])) {
                    $pipelines[$pipelineData['pipeline_id']] =
                        ['stage_id' => $this->getPipelineFirstStageId($pipelineData['pipeline_id'])];
                    if (empty($pipelines[$pipelineData['pipeline_id']])) {
                        throw new CustomValidationException('Недопустимые значения для воронки задачи');
                    }
                } else {
                    if (!$this->isExistsPipelineStage($pipelineData['pipeline_id'], $pipelineData['stage_id'])) {
                        throw new CustomValidationException('Недопустимые значения для воронки задачи');
                    }
                    $pipelines[$pipelineData['pipeline_id']] = ['stage_id' => $pipelineData['stage_id']];
                }
            }
        }

        return $pipelines;
    }

    /**
     * @param  int  $userId
     * @param  array  $data
     * @return Task
     * @throws Throwable
     */
    public function store(int $userId, array $data): Task
    {
        $data['author_id'] = $userId;
        $data['department_id'] = $this->getUserDepartmentId($userId);
        $data['status'] = empty($data['status']) ? Task::STATUS_WAIT : $data['status'];

        $pipelines = $this->preparePipelines($data);

        return DB::transaction(function () use ($data, $userId, $pipelines) {
            $task = Task::create($data);

            $checkboxNames = [];
            foreach ($data['checkboxes'] as $checkboxName) {
                $checkboxNames[] = [
                    'description' => $checkboxName,
                    'task_id' => $task->id
                ];
            }

            Checkbox::insert($checkboxNames);

            if (!empty($pipelines)) {
                $task->pipelines()->attach($pipelines);
            }

            $this->storeFiles($userId, $task, $data['temp_file_ids'] ?? []);

            return $task;
        });
    }

    /**
     * @param  Task  $task
     * @param  array|null  $ids
     */
    private function deleteTaskFiles(Task $task, ?array $ids): void
    {
        if (!empty($ids)) {
            foreach ($task->files as $file) {
                if (in_array($file->id, $ids)) {
                    $file->delete();
                }
            }
        }
    }

    /**
     * @param  int  $userId
     * @param  Task  $task
     * @param  array  $data
     * @return Task
     * @throws Throwable
     */
    public function update(int $userId, Task $task, array $data): Task
    {
        $checkboxes = [];
        $newIds = [];
        foreach ($data['checkboxes'] as $checkbox) {
            $checkboxes[] = [
                'id' => $checkbox['id'] ?? null,
                'description' => $checkbox['description'] ?? '',
                'is_checked' => $checkbox['is_checked'] ?? 0,
                'task_id' => $task->id
            ];

            if (!empty($checkbox['id'])) {
                $newIds[] = $checkbox['id'];
            }
        }
        unset($data['checkboxes']);

        $ids = $task->checkboxes->pluck('id')->toArray();
        $deleteIds = [];
        foreach ($ids as $id) {
            if (!in_array($id, $newIds, true)) {
                $deleteIds[] = $id;
            }
        }

        if ($task->user_id !== (int)$data['user_id']) {
            $data['department_id'] = $this->getUserDepartmentId($userId);
        }

        $pipelines = $this->preparePipelines($data);

        return DB::transaction(function () use ($userId, $task, $data, $checkboxes, $deleteIds, $pipelines) {
            $task->update($data);
            $task->checkboxes()->whereIn('id', $deleteIds)->delete();
            $task->checkboxes()->upsert($checkboxes, ['id'], ['description', 'is_checked', 'task_id']);

            if (!empty($pipelines)) {
                $task->pipelines()->sync($pipelines);
            }

            $this->deleteTaskFiles($task, $data['delete_file_ids'] ?? []);
            $this->storeFiles($userId, $task, $data['temp_file_ids'] ?? []);

            $task->refresh();

            return $task;
        });
    }

    /**
     * @param  Task  $task
     * @throws UsedInOtherTableException
     */
    public function delete(Task $task): void
    {
        try {
            $task->delete();
        } catch (Throwable) {
            throw new UsedInOtherTableException(
                'Задачу нельзя удалить, так как она уже используется в других таблицах'
            );
        }
    }
}
