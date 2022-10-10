<?php

namespace App\Http\Controllers\Api\Tasks;

use App\Http\Resources\Tasks\TaskWithFilesResource;
use App\Http\Resources\Tasks\TaskCollection;
use Illuminate\Auth\Access\AuthorizationException;
use App\Exceptions\UsedInOtherTableException;
use App\Http\Requests\Tasks\StoreRequest;
use App\Http\Requests\Tasks\UpdateRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Services\Tasks\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Task;
use Throwable;

class TaskController extends Controller
{
    /**
     * TaskController constructor.
     * @param  TaskService  $taskService
     */
    public function __construct(private TaskService $taskService) {}

    /**
     * @return array
     * @throws AuthorizationException
     */
    private function getPermissions(): array
    {
        if (Gate::check('read-tasks')) {
            return [];
        }

        if (Gate::check('read-department-tasks')) {
            return ['department_id' => user()->department_id];
        }

        if (Gate::check('read-own-tasks')) {
            return ['user_id' => id()];
        }

        throw new AuthorizationException('Недостаточно прав для получения данных', 403);
    }

    /**
     * Список задач
     *
     * Получение списка задач с пагинацией.
     * С помощью дополнительных параметров в url можно указать фрагмент для поиска по названию, по статусу,
     * по производителю, по заказу наряда, по воронке, по отделу, период для даты начала, период для даты создания,
     * период для даты завершения.
     * Сортировка возможна по названию, статусу, id исполнителя, дате создания или дате завершения.
     *
     * Права: `read tasks` или `read department tasks` или `read own tasks`
     *
     * @urlParam order string Значения: id, name, status, user_id, create_date, start_date, end_date. Если параметр
     * не указан, то по id desc.
     * @urlParam name string Поиск по фрагменту названия
     * @urlParam status string Поиск по статусу
     * @urlParam user_id integer Поиск по id исполнителя
     * @urlParam order_id integer Поиск по id заказ наряда
     * @urlParam pipeline_id integer Поиск по id воронки
     * @urlParam department_id integer Поиск по id отдела
     *
     * @group Задачи
     *
     * @param  Request  $request
     * @return TaskCollection
     * @throws AuthorizationException
     */
    public function index(Request $request): TaskCollection
    {
        $tasks = $this->taskService->getPaginatedTasks($request->all(), $this->getPermissions());

        return new TaskCollection($tasks);
    }

    /**
     * Получение задачи
     *
     * Права: `read tasks` или `read department tasks` или `read own tasks`
     *
     * @group Задачи
     *
     * @urlParam task integer required
     *
     * @param  Task  $task
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function show(Task $task): JsonResponse
    {
        $this->authorize('read-own-tasks', $task);

        return response_json(['task' => TaskWithFilesResource::make($task)]);
    }

    /**
     * Добавление задачи
     *
     * Права: `create tasks`
     *
     * @group Задачи
     *
     * @bodyParam temp_file_ids array[integer] Id временных файлов, загруженных отдельно до добавления задачи. Эти
     * временные файлы будут добавлены к задаче
     *
     * @param  StoreRequest  $request
     * @return JsonResponse
     * @throws AuthorizationException
     * @throws Throwable
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $this->authorize('create-tasks');

        $task = $this->taskService->store(id(), $request->validated());

        return response_json(['task' => TaskWithFilesResource::make($task)]);
    }

    /**
     * Обновление задачи
     *
     * Права: `update tasks` или `update department tasks` или `update own tasks`
     *
     * @group Задачи
     *
     * @urlParam task integer required
     * @bodyParam temp_file_ids array[integer] Id временных файлов, загруженных отдельно до обновления задачи. Эти
     * временные файлы будут добавлены к задаче
     * @bodyParam delete_file_ids array[integer] Id файлов задачи, которые необходимо удалить
     *
     * @param  UpdateRequest  $request
     * @param  Task  $task
     * @return JsonResponse
     * @throws AuthorizationException
     * @throws Throwable
     */
    public function update(UpdateRequest $request, Task $task): JsonResponse
    {
        $this->authorize('update-own-tasks', $task);

        $task = $this->taskService->update(id(), $task, $request->validated());

        return response_json(['task' => TaskWithFilesResource::make($task)]);
    }

    /**
     * Удаление задачи
     *
     * Права: `delete tasks` или `delete department tasks` или `delete own tasks`
     *
     * @group Задачи
     *
     * @urlParam task integer required
     *
     * @param  Task  $task
     * @return JsonResponse
     * @throws AuthorizationException
     * @throws UsedInOtherTableException
     */
    public function destroy(Task $task): JsonResponse
    {
        $this->authorize('delete-own-tasks', $task);

        $this->taskService->delete($task);

        return response_success();
    }
}
