<?php

namespace App\Services\Processes;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Exceptions\UsedInOtherTableException;
use App\Models\ProcessCheckbox;
use App\Models\ProcessTask;
use App\Models\TempFile;
use Throwable;
use DB;

class ProcessTaskService
{
    /**
     * @param  array  $filter
     * @return LengthAwarePaginator
     */
    public function getPaginatedTasks(array $filter): LengthAwarePaginator
    {
        $tasks = ProcessTask::with('user', 'processCheckboxes', 'processCategory');

        if (!empty($filter['name'])) {
            $tasks->where('name', 'like', '%'.$filter['name'].'%');
        }

        if (!empty($filter['user_id'])) {
            $tasks->where('user_id', $filter['user_id']);
        }

        if (!empty($filter['order'])) {
            if ($filter['order'] === 'name') {
                $tasks->orderBy('name');
            } elseif ($filter['order'] === 'user_id') {
                $tasks->orderBy('user_id');
            } elseif ($filter['order'] === 'create_date') {
                $tasks->orderBy('created_at', 'desc');
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
     * @param  ProcessTask  $task
     * @param  array|null  $tempFileIds
     */
    private function storeFiles(int $userId, ProcessTask $task, ?array $tempFileIds): void
    {
        if (empty($tempFileIds)) {
            return;
        }

        $tempFiles = TempFile::where('user_id', $userId)->whereIn('id', $tempFileIds)->orderBy('id')->get();

        foreach ($tempFiles as $tempFile) {
            try {
                $task->addMedia($tempFile->getFirstMedia('temp')->getPath())
                    ->usingName($tempFile->getFirstMedia('temp')->name)
                    ->toMediaCollection('files', ProcessTask::FILES_DISK);
                $tempFile->delete();
            } catch (Throwable $e) {
                info('Не удалось добавить временный файл к задаче', [$e->getTraceAsString()]);
            }
        }
    }

    /**
     * @param  int  $userId
     * @param  array  $data
     * @return ProcessTask
     * @throws Throwable
     */
    public function store(int $userId, array $data): ProcessTask
    {
        return DB::transaction(function () use ($data, $userId) {
            $task = ProcessTask::create($data);

            $checkboxNames = [];
            foreach ($data['checkboxes'] as $checkboxName) {
                $checkboxNames[] = [
                    'description' => $checkboxName,
                    'process_task_id' => $task->id
                ];
            }

            ProcessCheckbox::insert($checkboxNames);

            $this->storeFiles($userId, $task, $data['temp_file_ids'] ?? []);

            return $task;
        });
    }

    /**
     * @param  ProcessTask  $task
     * @param  array|null  $ids
     */
    private function deleteTaskFiles(ProcessTask $task, ?array $ids): void
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
     * @param  ProcessTask  $task
     * @param  array  $data
     * @return ProcessTask
     * @throws Throwable
     */
    public function update(int $userId, ProcessTask $task, array $data): ProcessTask
    {
        $checkboxes = [];
        $newIds = [];
        foreach ($data['checkboxes'] as $checkbox) {
            $checkboxes[] = [
                'id' => $checkbox['id'] ?? null,
                'description' => $checkbox['description'] ?? '',
                'is_checked' => $checkbox['is_checked'] ?? 0,
                'process_task_id' => $task->id
            ];

            if (!empty($checkbox['id'])) {
                $newIds[] = $checkbox['id'];
            }
        }
        unset($data['checkboxes']);

        $ids = $task->processCheckboxes->pluck('id')->toArray();
        $deleteIds = [];
        foreach ($ids as $id) {
            if (!in_array($id, $newIds, true)) {
                $deleteIds[] = $id;
            }
        }

        return DB::transaction(function () use ($userId, $task, $data, $checkboxes, $deleteIds) {
            $task->update($data);
            $task->processCheckboxes()->whereIn('id', $deleteIds)->delete();
            $task->processCheckboxes()->upsert($checkboxes, ['id'], ['description', 'is_checked', 'task_id']);

            $this->deleteTaskFiles($task, $data['delete_file_ids'] ?? []);
            $this->storeFiles($userId, $task, $data['temp_file_ids'] ?? []);

            $task->refresh();

            return $task;
        });
    }

    /**
     * @param  int  $id
     * @throws UsedInOtherTableException
     */
    public function delete(int $id): void
    {
        try {
            ProcessTask::where('id', $id)->delete();
        } catch (Throwable) {
            throw new UsedInOtherTableException(
                'Задачу нельзя удалить, так как она уже используется в других таблицах'
            );
        }
    }
}
