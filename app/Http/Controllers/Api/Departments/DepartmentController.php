<?php

namespace App\Http\Controllers\Api\Departments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Departments\StoreRequest;
use App\Http\Requests\Departments\UpdateRequest;
use App\Http\Resources\Departments\DepartmentResource;
use App\Models\Department;
use App\Models\RoleConst;
use App\Services\Departments\DepartmentService;
use Illuminate\Http\JsonResponse;

class DepartmentController extends Controller
{
    /**
     * DepartmentController constructor.
     * @param  DepartmentService  $departmentService
     */
    public function __construct(private DepartmentService $departmentService)
    {
        $this->middleware(['permission:' . RoleConst::PERMISSION_DEPARTMENTS_CRUD]);
    }

    /**
     * Список отделов
     *
     * Права: `crud departments`
     *
     * Упорядочены по названию (name)
     *
     * @group Отделы
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $departments = $this->departmentService->getAll();

        return response_json(['departments' => DepartmentResource::collection($departments)]);
    }

    /**
     * Получение отдела
     *
     * Права: `crud departments`
     *
     * @group Отделы
     *
     * @param  Department  $department
     * @return JsonResponse
     */
    public function show(Department $department): JsonResponse
    {
        return response_json(['department' => DepartmentResource::make($department)]);
    }

    /**
     * Добавление отдела
     *
     * Права: `crud departments`
     *
     * @group Отделы
     *
     * @param  StoreRequest  $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $department = $this->departmentService->store($request->validated());

        return response_json(['department' => DepartmentResource::make($department)]);
    }

    /**
     * Обновление отдела
     *
     * Права: `crud departments`
     *
     * @group Отделы
     *
     * @param  UpdateRequest  $request
     * @param  int  $departmentId
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, int $departmentId): JsonResponse
    {
        $department = $this->departmentService->update($departmentId, $request->validated());

        return response_json(['department' => DepartmentResource::make($department)]);
    }

    /**
     * Удаление отдела
     *
     * Права: `crud departments`
     *
     * Soft delete
     *
     * @group Отделы
     *
     * @param  int  $departmentId
     * @return JsonResponse
     */
    public function destroy(int $departmentId): JsonResponse
    {
        $this->departmentService->delete($departmentId);

        return response_success();
    }
}
