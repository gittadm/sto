<?php

namespace App\Http\Controllers\Api\Clients;

use App\Exceptions\UsedInOtherTableException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cities\StoreRequest;
use App\Http\Requests\Cities\UpdateRequest;
use App\Http\Resources\Cities\CityResource;
use App\Models\City;
use App\Models\RoleConst;
use App\Services\Cities\CityService;
use Illuminate\Http\JsonResponse;

class CityController extends Controller
{
    /**
     * CityController constructor.
     * @param  CityService  $cityService
     */
    public function __construct(private CityService $cityService)
    {
        $this->middleware(['permission:' . RoleConst::PERMISSION_CITIES_CRUD]);
    }

    /**
     * Список городов
     *
     * Упорядочены по названию
     *
     * Права: `crud cities`
     *
     * @group Города
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $cities = $this->cityService->getAll();

        return response_json(['cities' => CityResource::collection($cities)]);
    }

    /**
     * Получение города
     *
     * Права: `crud cities`
     *
     * @group Города
     *
     * @param  City  $city
     * @return JsonResponse
     */
    public function show(City $city): JsonResponse
    {
        return response_json(['role' => CityResource::make($city)]);
    }

    /**
     * Добавление города
     *
     * Название города должно быть уникально
     *
     * Права: `crud cities`
     *
     * @group Города
     *
     * @param  StoreRequest  $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $city = $this->cityService->store($request->validated());

        return response_json(['city' => CityResource::make($city)]);
    }

    /**
     * Обновление города
     *
     * Права: `crud cities`
     *
     * @group Города
     *
     * @param  UpdateRequest  $request
     * @param  int  $cityId
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, int $cityId): JsonResponse
    {
        $city = $this->cityService->update($cityId, $request->validated());

        return response_json(['city' => CityResource::make($city)]);
    }

    /**
     * Удаление города
     *
     * Права: `crud cities`
     *
     * Удаление только если нет клиента с таким городом
     *
     * @group Города
     *
     * @param  int  $cityId
     * @return JsonResponse
     * @throws UsedInOtherTableException
     */
    public function destroy(int $cityId): JsonResponse
    {
        $this->cityService->delete($cityId);

        return response_success();
    }
}
