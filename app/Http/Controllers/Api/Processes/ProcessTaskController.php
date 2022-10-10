<?php

namespace App\Http\Controllers\Api\Processes;

use App\Http\Resources\Processes\ProcessTaskCollection;
use App\Http\Resources\Processes\ProcessTaskResource;
use App\Http\Requests\ProcessTasks\UpdateRequest;
use App\Http\Requests\ProcessTasks\StoreRequest;
use App\Services\Processes\ProcessTaskService;
use App\Exceptions\UsedInOtherTableException;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\ProcessTask;
use App\Models\RoleConst;
use Throwable;

class ProcessTaskController extends Controller
{
    /**
     * ProcessTaskController constructor.
     * @param  ProcessTaskService  $processTaskService
     */
    public function __construct(private ProcessTaskService $processTaskService)
    {
        $this->middleware(['permission:' . RoleConst::PERMISSION_PROCESSES_CRUD]);
    }

    /**
     * Список задач
     *
     * Права: `crud processes`
     *
     * @group Процессы
     *
     * @param  Request  $request
     * @return ProcessTaskCollection
     */
    public function index(Request $request): ProcessTaskCollection
    {
        $processTasks = $this->processTaskService->getPaginatedTasks($request->all());

        return new ProcessTaskCollection($processTasks);
    }

    /**
     * Получение задачи
     *
     * Права: `crud processes`
     *
     * @group Процессы
     *
     * @urlParam process_task integer required
     *
     * @param  ProcessTask  $processTask
     * @return JsonResponse
     */
    public function show(ProcessTask $processTask): JsonResponse
    {
        return response_json(['process_task' => ProcessTaskResource::make($processTask)]);
    }

    /**
     * Добавление задачи
     *
     * Права: `crud processes`
     *
     * @bodyParam name string required
     *
     * @group Процессы
     *
     * @param  StoreRequest  $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $processTask = $this->processTaskService->store(id(), $request->validated());

        return response_json(['process_task' => ProcessTaskResource::make($processTask)]);
    }

    /**
     * Обновление задачи
     *
     * Права: `crud processes`
     *
     * @group Процессы
     *
     * @urlParam process_task integer required
     *
     * @param  UpdateRequest  $request
     * @param  ProcessTask  $processTask
     * @return JsonResponse
     * @throws Throwable
     */
    public function update(UpdateRequest $request, ProcessTask $processTask): JsonResponse
    {
        $processTask = $this->processTaskService->update(id(), $processTask, $request->validated());

        return response_json(['process_task' => ProcessTaskResource::make($processTask)]);
    }

    /**
     * Удаление задачи
     *
     * Права: `crud processes`
     *
     * Удаление только если нет связанных таблиц
     *
     * @group Процессы
     *
     * @urlParam process_task integer required
     *
     * @param  int  $processTaskId
     * @return JsonResponse
     * @throws UsedInOtherTableException
     */
    public function destroy(int $processTaskId): JsonResponse
    {
        $this->processTaskService->delete($processTaskId);

        return response_success();
    }
}
