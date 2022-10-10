<?php

namespace App\Services\Tasks;

use App\Exceptions\CustomValidationException;
use App\Models\Pipeline;
use App\Models\PipelineTask;
use App\Models\Stage;
use App\Models\Task;

class TaskPipelineService
{
    /**
     * @param  Task  $task
     * @param  Pipeline  $pipeline
     * @param  array  $data
     * @throws CustomValidationException
     */
    public function updateStage(Task $task, Pipeline $pipeline, array $data): void
    {
        if ($pipeline->type !== Pipeline::getModelClass('task')) {
            throw new CustomValidationException('Недопустимая воронка для задачи');
        }

        $stage = Stage::where('pipeline_id', $pipeline->id)
            ->where('id', $data['stage_id'])->firstOrFail();

        $pipelineTask = PipelineTask::where('task_id', $task->id)
            ->where('pipeline_id', $pipeline->id)->firstOrFail();

        $pipelineTask->update(['stage_id' => $stage->id]);
    }
}
