<?php

namespace App\Http\Controllers\Api\Users;

use Illuminate\Auth\Access\AuthorizationException;
use App\Http\Requests\Users\UpdateRequest;
use App\Http\Requests\Users\StoreRequest;
use App\Http\Resources\Users\UserResource;
use App\Http\Controllers\Controller;
use App\Services\Users\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Throwable;

class UserController extends Controller
{
    /**
     * UserController constructor.
     * @param  UserService  $userService
     */
    public function __construct(private UserService $userService) {}

    /**
     * Список сотрудников
     *
     * Получение списка сотрудников вместе с ролями и отделом.
     * С помощью дополнительных параметров в url можно указать отдел, активность аккаунта,
     * поле для сортировки и фрагмент для поиска по ФИО.
     *
     * Пример: api/users?active=1&order=surname
     *
     * Права: `read users`
     *
     * @group Сотрудники
     *
     * @urlParam active integer Значения: 0, 1 - заблокированные или активные аккаунты. Если параметр не указан,
     * то все аккаунты.
     * @urlParam order string Значения: id, surname, department. Если параметр не указан, то по id desc.
     * @urlParam department_id integer Получение сотрудников только с указанного отдела
     * @urlParam name string Фрагмент для поиска по ФИО
     *
     * @param  Request  $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function index(Request $request): JsonResponse
    {
        $this->authorize('users-read');

        $users = $this->userService->getAllWithRoles($request->all());

        return response_json(['users' => UserResource::collection($users)]);
    }

    /**
     * Получение сотрудника
     *
     * Права: `read users`
     *
     * @group Сотрудники
     *
     * @param  User  $user
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function show(User $user): JsonResponse
    {
        $this->authorize('users-read');

        return response_json(['user' => UserResource::make($user)]);
    }

    /**
     * Добавление сотрудника
     *
     * Права: `crud users`
     *
     * @group Сотрудники
     *
     * @bodyParam born_at string Дата рождения в формате Y-m-d
     * @bodyParam email string required
     * @bodyParam office_position string Должность
     * @bodyParam password string required Пароль должен содержать не менее 8 символов
     *
     * @responseFile status=200 scenario="success" docs/users.store.json
     *
     * @param  StoreRequest  $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $this->authorize('users-crud');

        $user = $this->userService->store($request->validated());

        return response_json(['user' => UserResource::make($user)]);
    }

    /**
     * Обновление сотрудника
     *
     * Права: `crud users`
     *
     * @group Сотрудники
     *
     * @bodyParam born_at string Дата рождения в формате Y-m-d
     * @bodyParam email string required
     * @bodyParam office_position string Должность
     *
     * @responseFile status=422 scenario="invalid input data" docs/users.update.json
     * @responseFile status=200 scenario="success" docs/users.store.json
     *
     * @param  UpdateRequest  $request
     * @param  User  $user
     * @return JsonResponse
     * @throws Throwable
     */
    public function update(UpdateRequest $request, User $user): JsonResponse
    {
        $this->authorize('users-crud');

        $user = $this->userService->update($user, $request->validated());

        return response_json(['user' => UserResource::make($user)]);
    }

    /**
     * Удаление сотрудника
     *
     * Права: `crud users`
     *
     * @group Сотрудники
     *
     * @param  User  $user
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(User $user): JsonResponse
    {
        $this->authorize('users-crud');

        $this->userService->destroy($user);

        return response_success();
    }
}
