<?php

namespace App\Http\Controllers\Api\Tasks;

use App\Exceptions\CustomValidationException;
use App\Http\Requests\Tasks\UpdatePipelineStageRequest;
use Illuminate\Auth\Access\AuthorizationException;
use App\Services\Tasks\TaskPipelineService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\Pipeline;
use App\Models\Task;

class TaskPipelineController extends Controller
{
    /**
     * TaskPipelineController constructor.
     * @param  TaskPipelineService  $taskPipelineService
     */
    public function __construct(private TaskPipelineService $taskPipelineService) {}

    /**
     * Обновление этапа воронки задачи
     *
     * Права: `update tasks` или `update department tasks` или `update own tasks`
     *
     * @group Задачи
     *
     * @urlParam task integer required
     * @urlParam pipeline integer required
     * @bodyParam stage_id integer required
     *
     * @param  UpdatePipelineStageRequest  $request
     * @param  Task  $task
     * @param  Pipeline  $pipeline
     * @return JsonResponse
     * @throws AuthorizationException
     * @throws CustomValidationException
     */
    public function updateStage(UpdatePipelineStageRequest $request, Task $task, Pipeline $pipeline): JsonResponse
    {
        $this->authorize('update-own-tasks', $task);

        $this->taskPipelineService->updateStage($task, $pipeline, $request->validated());

        return response_success();
    }
}
