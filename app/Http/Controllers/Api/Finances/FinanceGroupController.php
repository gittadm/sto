<?php

namespace App\Http\Controllers\Api\Finances;

use App\Exceptions\UsedInOtherTableException;
use App\Http\Controllers\Controller;
use App\Http\Requests\FinanceGroups\StoreRequest;
use App\Http\Requests\FinanceGroups\UpdateRequest;
use App\Http\Resources\Finances\FinanceGroupResource;
use App\Models\FinanceGroup;
use App\Services\Finances\FinanceGroupService;
use Illuminate\Http\JsonResponse;
use App\Models\RoleConst;

class FinanceGroupController extends Controller
{
    /**
     * FinanceGroupController constructor.
     * @param  FinanceGroupService  $financeGroupService
     */
    public function __construct(private FinanceGroupService $financeGroupService)
    {
        $this->middleware(['permission:' . RoleConst::PERMISSION_FINANCES_CRUD]);
    }

    /**
     * Список финансовых групп
     *
     * Права: `crud finances`
     *
     * @group Финансы
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $financeGroups = $this->financeGroupService->getAll();

        return response_json(['finance_groups' => FinanceGroupResource::collection($financeGroups)]);
    }

    /**
     * Получение финансовой группы
     *
     * Права: `crud finances`
     *
     * @group Финансы
     *
     * @urlParam finance_group integer required
     *
     * @responseFile status=200 scenario="success" docs/finance-groups.store.json

     * @param  FinanceGroup  $financeGroup
     * @return JsonResponse
     */
    public function show(FinanceGroup $financeGroup): JsonResponse
    {
        return response_json(['finance_group' => FinanceGroupResource::make($financeGroup)]);
    }

    /**
     * Добавление финансовой группы
     *
     * Название должно быть уникально
     *
     * Права: `crud finances`
     *
     * @bodyParam name string required Уникальное название
     *
     * @group Финансы
     *
     * @responseFile status=200 scenario="success" docs/finance-groups.store.json
     *
     * @param  StoreRequest  $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $financeGroup = $this->financeGroupService->store($request->validated());

        return response_json(['finance_group' => FinanceGroupResource::make($financeGroup)]);
    }

    /**
     * Обновление финансовой группы
     *
     * Права: `crud finances`
     *
     * @group Финансы
     *
     * @urlParam finance_group integer required
     * @bodyParam name string required Уникальное название
     *
     * @responseFile status=200 scenario="success" docs/finance-groups.store.json
     *
     * @param  UpdateRequest  $request
     * @param  int  $financeGroupId
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, int $financeGroupId): JsonResponse
    {
        $financeGroup = $this->financeGroupService->update($financeGroupId, $request->validated());

        return response_json(['finance_group' => FinanceGroupResource::make($financeGroup)]);
    }

    /**
     * Удаление финансовой группы
     *
     * Права: `crud finances`
     *
     * Удаление только если нет финансовых операций или других связанных таблиц
     *
     * @group Финансы
     *
     * @urlParam finance_group integer required
     *
     * @param  int  $financeGroupId
     * @return JsonResponse
     * @throws UsedInOtherTableException
     */
    public function destroy(int $financeGroupId): JsonResponse
    {
        $this->financeGroupService->delete($financeGroupId);

        return response_success();
    }
}
