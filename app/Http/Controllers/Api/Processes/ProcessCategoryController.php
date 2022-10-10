<?php

namespace App\Http\Controllers\Api\Processes;

use App\Exceptions\UsedInOtherTableException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProcessCategories\StoreRequest;
use App\Http\Requests\ProcessCategories\UpdateRequest;
use App\Http\Resources\Processes\ProcessCategoryResource;
use App\Models\ProcessCategory;
use App\Services\Processes\ProcessCategoryService;
use Illuminate\Http\JsonResponse;
use App\Models\RoleConst;

class ProcessCategoryController extends Controller
{
    /**
     * ProcessCategoryController constructor.
     * @param  ProcessCategoryService  $processCategoryService
     */
    public function __construct(private ProcessCategoryService $processCategoryService)
    {
        $this->middleware(['permission:' . RoleConst::PERMISSION_PROCESSES_CRUD]);
    }

    /**
     * Список категорий
     *
     * Получение списка категорий, упорядоченных по названию
     *
     * Права: `crud processes`
     *
     * @group Процессы
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $processCategories = $this->processCategoryService->getAll();

        return response_json(['process_categories' => ProcessCategoryResource::collection($processCategories)]);
    }

    /**
     * Получение категории
     *
     * Права: `crud processes`
     *
     * @group Процессы
     *
     * @urlParam process_category integer required
     *
     * @param  ProcessCategory  $processCategory
     * @return JsonResponse
     */
    public function show(ProcessCategory $processCategory): JsonResponse
    {
        return response_json(['process_category' => ProcessCategoryResource::make($processCategory)]);
    }

    /**
     * Добавление категории
     *
     * Права: `crud processes`
     *
     * @bodyParam name string required
     *
     * @group Процессы
     *
     * @param  StoreRequest  $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $processCategory = $this->processCategoryService->store($request->validated());

        return response_json(['process_category' => ProcessCategoryResource::make($processCategory)]);
    }

    /**
     * Обновление категории
     *
     * Права: `crud processes`
     *
     * @group Процессы
     *
     * @urlParam process_category integer required
     *
     * @param  UpdateRequest  $request
     * @param  int  $processCategoryId
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, int $processCategoryId): JsonResponse
    {
        $processCategory = $this->processCategoryService->update($processCategoryId, $request->validated());

        return response_json(['process_category' => ProcessCategoryResource::make($processCategory)]);
    }

    /**
     * Удаление категории
     *
     * Права: `crud processes`
     *
     * Удаление только если нет связанных таблиц
     *
     * @group Процессы
     *
     * @urlParam process_category integer required
     *
     * @param  int  $processCategoryId
     * @return JsonResponse
     * @throws UsedInOtherTableException
     */
    public function destroy(int $processCategoryId): JsonResponse
    {
        $this->processCategoryService->delete($processCategoryId);

        return response_success();
    }
}
