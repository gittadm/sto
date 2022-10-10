<?php

namespace App\Http\Controllers\Api\Roles;

use App\Exceptions\CustomValidationException;
use App\Exceptions\UsedInOtherTableException;
use App\Http\Requests\Roles\StoreRequest;
use App\Http\Requests\Roles\UpdateRequest;
use App\Http\Resources\Roles\RoleResource;
use App\Http\Controllers\Controller;
use App\Models\RoleConst;
use App\Services\Roles\RoleService;
use Illuminate\Http\JsonResponse;
use App\Models\Role;
use Throwable;

class RoleController extends Controller
{
    /**
     * RoleController constructor.
     * @param  RoleService  $roleService
     */
    public function __construct(private RoleService $roleService)
    {
        $this->middleware(['permission:' . RoleConst::PERMISSION_ROLES_CRUD]);
    }

    /**
     * Список ролей
     *
     * Права: `crud roles`
     *
     * Роли со списком разрешений. Роли упорядочены по названию (title)
     *
     * @group Роли
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $roles = $this->roleService->getAllWithPermissions();

        return response_json(['roles' => RoleResource::collection($roles)]);
    }

    /**
     * Получение роли
     *
     * Права: `crud roles`
     *
     * @group Роли
     *
     * @param  Role  $role
     * @return JsonResponse
     */
    public function show(Role $role): JsonResponse
    {
        return response_json(['role' => RoleResource::make($role)]);
    }

    /**
     * Добавление роли
     *
     * Права: `crud roles`
     *
     * По title генерируется уникальное name
     *
     * @bodyParam permissions string[] required Массив прав. Может быть пустым. Пример: ['crud roles', 'crud departments']
     *
     * @group Роли
     *
     * @param  StoreRequest  $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $role = $this->roleService->store($request->validated());

        return response_json(['role' => RoleResource::make($role)]);
    }

    /**
     * Обновление роли
     *
     * Права: `crud roles`
     *
     * Роль администратора нельзя обновить
     *
     * @group Роли
     *
     * @bodyParam permissions string[] required Массив прав. Может быть пустым. Пример: ['crud roles', 'crud departments']
     *
     * @param  UpdateRequest  $request
     * @param  Role  $role
     * @return JsonResponse
     * @throws CustomValidationException
     * @throws Throwable
     */
    public function update(UpdateRequest $request, Role $role): JsonResponse
    {
        $role = $this->roleService->update($role, $request->validated());

        return response_json(['role' => RoleResource::make($role)]);
    }


    /**
     * Удаление роли
     *
     * Права: `crud roles`
     *
     * Удаление только если нет пользователя с такой ролью. Роль администратора нельзя удалить
     *
     * @group Роли
     *
     * @param  Role  $role
     * @return JsonResponse
     * @throws CustomValidationException
     * @throws UsedInOtherTableException
     */
    public function destroy(Role $role): JsonResponse
    {
        $this->roleService->destroy($role);

        return response_success();
    }
}
