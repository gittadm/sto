<?php

namespace App\Http\Controllers\Api\Finances;

use App\Exceptions\UsedInOtherTableException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Finances\StoreRequest;
use App\Http\Requests\Finances\UpdateRequest;
use App\Http\Resources\Finances\FinanceCollection;
use App\Http\Resources\Finances\FinanceResource;
use App\Services\Finances\FinanceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\RoleConst;
use App\Models\Finance;

class FinanceController extends Controller
{
    public function __construct(private FinanceService $financeService)
    {
        $this->middleware(['permission:' . RoleConst::PERMISSION_FINANCES_CRUD]);
    }

    /**
     * Список финансовых операций
     *
     * Получение списка финансовых операций с финансовыми группами с пагинацией.
     * С помощью дополнительных параметров в url можно указать фрагмент для поиска по названию,
     * паиск по типу операции, сумме, периоду для даты создания, поиск по id отдела.
     * Сортировка возможна по дате создания, типу операции (приход, расход), сумме, названию, id отдела
     *
     * Права: `crud finances`
     *
     * @group Финансы
     *
     * @urlParam order string Значения: id, name, type, sum, date, department. Если параметр не указан, то по id desc.
     * @urlParam name string Поиск по фрагменту названия
     * @urlParam type string Поиск по типу операции (in, out)
     * @urlParam sum string Поиск по сумме
     * @urlParam department_id integer Поиск по id отдела
     * @urlParam start_date string Дата создания от (вкл) Пример: 31.01.2022
     * @urlParam end_date string Дата создания до (вкл) Пример: 31.01.2022
     *
     * @param  Request  $request
     * @return FinanceCollection
     */
    public function index(Request $request): FinanceCollection
    {
        $finances = $this->financeService->getPaginatedFinances($request->all());

        return new FinanceCollection($finances);
    }

    /**
     * Получение финансовой операции
     *
     * Права: `crud finances`
     *
     * @group Финансы
     *
     * @urlParam finance integer required
     *
     * @param  Finance  $finance
     * @return JsonResponse
     */
    public function show(Finance $finance): JsonResponse
    {
        return response_json(['finance' => FinanceResource::make($finance)]);
    }

    /**
     * Добавление финансовой операции
     *
     * Права: `crud finances`
     *
     * @group Финансы
     *
     * @param  StoreRequest  $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $finance = $this->financeService->store($request->validated());

        return response_json(['finance' => FinanceResource::make($finance)]);
    }

    /**
     * Обновление финансовой операции
     *
     * Права: `crud finances`
     *
     * @group Финансы
     *
     * @urlParam finance integer required
     * @bodyParam name string required Уникальное название
     *
     * @param  UpdateRequest  $request
     * @param  int  $financeId
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, int $financeId): JsonResponse
    {
        $finance = $this->financeService->update($financeId, $request->validated());

        return response_json(['finance' => FinanceResource::make($finance)]);
    }

    /**
     * Удаление финансовой операции
     *
     * Права: `crud finances`
     *
     * @group Финансы
     *
     * @urlParam finance integer required
     *
     * @param  int  $financeId
     * @return JsonResponse
     * @throws UsedInOtherTableException
     */
    public function destroy(int $financeId): JsonResponse
    {
        $this->financeService->delete($financeId);

        return response_success();
    }
}
