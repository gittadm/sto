<?php

namespace App\Http\Controllers\Api\Tasks;

use App\Http\Requests\Tasks\DoneRequest;
use App\Http\Requests\Tasks\ProcessRequest;
use App\Http\Requests\Tasks\UpdateStatusRequest;
use App\Services\Tasks\TaskStatusService;
use Illuminate\Auth\Access\AuthorizationException;
use App\Http\Resources\Tasks\TaskResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\Task;

class TaskStatusController extends Controller
{
    /**
     * TaskStatusController constructor.
     * @param  TaskStatusService  $taskStatusService
     */
    public function __construct(private TaskStatusService $taskStatusService) {}

    /**
     * Начало работы на задачей
     *
     * Статус изменяетя на process и изменение start_at. Если start_at не указан в запросе,
     * то берется текущая дата
     *
     * Права: `update tasks` или `update department tasks` или `update own tasks`
     *
     * @group Задачи
     *
     * @urlParam task integer required
     *
     * @param  Task  $task
     * @param  ProcessRequest  $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function toProcess(ProcessRequest $request, Task $task): JsonResponse
    {
        $this->authorize('update-own-tasks', $task);

        $this->taskStatusService->updateStatusToProcess($task, $request->validated());

        return response_json(['task' => TaskResource::make($task)]);
    }

    /**
     * Завершить работу над задачей
     *
     * Статус меняется на done и изменение end_at. Если end_at не указан в запросе,
     * то берется текущая дата
     *
     * Права: `update tasks` или `update department tasks` или `update own tasks`
     *
     * @group Задачи
     *
     * @urlParam task integer required
     *
     * @param  DoneRequest  $request
     * @param  Task  $task
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function toDone(DoneRequest $request, Task $task): JsonResponse
    {
        $this->authorize('update-own-tasks', $task);

        $this->taskStatusService->updateStatusToDone($task, $request->validated());

        return response_json(['task' => TaskResource::make($task)]);
    }

    /**
     * Приостановить работу над задачей
     *
     * Статус меняется на pause
     *
     * Права: `update tasks` или `update department tasks` или `update own tasks`
     *
     * @group Задачи
     *
     * @urlParam task integer required
     *
     * @param  Task  $task
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function toPause(Task $task): JsonResponse
    {
        $this->authorize('update-own-tasks', $task);

        $this->taskStatusService->updateStatusToPause($task);

        return response_json(['task' => TaskResource::make($task)]);
    }

    /**
     * Обновление статуса задачи
     *
     * Права: `update tasks` или `update department tasks` или `update own tasks`
     *
     * @group Задачи
     *
     * @urlParam task integer required
     *
     * @param  UpdateStatusRequest  $request
     * @param  Task  $task
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function updateStatus(UpdateStatusRequest $request, Task $task): JsonResponse
    {
        $this->authorize('update-own-tasks', $task);

        $this->taskStatusService->updateStatus($task, $request->validated());

        return response_json(['task' => TaskResource::make($task)]);
    }
}
