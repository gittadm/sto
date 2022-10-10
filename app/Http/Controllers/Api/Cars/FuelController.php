<?php

namespace App\Http\Controllers\Api\Cars;

use App\Exceptions\UsedInOtherTableException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Fuels\StoreRequest;
use App\Http\Requests\Fuels\UpdateRequest;
use App\Http\Resources\Cars\FuelResource;
use App\Services\Cars\FuelService;
use Illuminate\Http\JsonResponse;
use App\Models\RoleConst;
use App\Models\Fuel;

class FuelController extends Controller
{
    /**
     * FuelController constructor.
     * @param  FuelService  $fuelService
     */
    public function __construct(private FuelService $fuelService)
    {
        $this->middleware(['permission:' . RoleConst::PERMISSION_FUELS_CRUD]);
    }

    /**
     * Список видов топлива
     *
     * Права: `crud fuels`
     *
     * @group Автомобили
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $fuels = $this->fuelService->getAll();

        return response_json(['fuels' => FuelResource::collection($fuels)]);
    }

    /**
     * Получение вида топлива
     *
     * Права: `crud fuels`
     *
     * @group Автомобили
     *
     * @urlParam fuel integer required
     *
     * @param  Fuel  $fuel
     * @return JsonResponse
     */
    public function show(Fuel $fuel): JsonResponse
    {
        return response_json(['fuel' => FuelResource::make($fuel)]);
    }

    /**
     * Добавление вида топлива
     *
     * Название должно быть уникально
     *
     * Права: `crud fuels`
     *
     * @bodyParam name string required Уникальное название
     *
     * @group Автомобили
     *
     * @param  StoreRequest  $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $fuel = $this->fuelService->store($request->validated());

        return response_json(['fuel' => FuelResource::make($fuel)]);
    }

    /**
     * Обновление вида топлива
     *
     * Права: `crud fuels`
     *
     * @group Автомобили
     *
     * @urlParam fuel integer required
     * @bodyParam name string required Уникальное название
     *
     * @param  UpdateRequest  $request
     * @param  int  $fuelId
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, int $fuelId): JsonResponse
    {
        $fuel = $this->fuelService->update($fuelId, $request->validated());

        return response_json(['fuel' => FuelResource::make($fuel)]);
    }

    /**
     * Удаление вида топлива
     *
     * Права: `crud fuels`
     *
     * Удаление только если нет автомобилей с таким топливом или других связанных таблиц
     *
     * @group Автомобили
     *
     * @urlParam fuel integer required
     *
     * @param  int  $fuelId
     * @return JsonResponse
     * @throws UsedInOtherTableException
     */
    public function destroy(int $fuelId): JsonResponse
    {
        $this->fuelService->delete($fuelId);

        return response_success();
    }
}
