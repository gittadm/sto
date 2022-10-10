<?php

namespace App\Http\Controllers\Api\Products;

use App\Exceptions\UsedInOtherTableException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Producers\StoreRequest;
use App\Http\Requests\Producers\UpdateRequest;
use App\Http\Resources\Products\ProducerResource;
use App\Models\Producer;
use App\Services\Products\ProducerService;
use Illuminate\Http\JsonResponse;
use App\Models\RoleConst;

class ProducerController extends Controller
{
    /**
     * ProducerController constructor.
     * @param  ProducerService  $producerService
     */
    public function __construct(private ProducerService $producerService)
    {
        $this->middleware(['permission:' . RoleConst::PERMISSION_STORAGES_CRUD]);
    }

    /**
     * Список производителей
     *
     * Права: `crud storages`
     *
     * @group Склады
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $producers = $this->producerService->getAll();

        return response_json(['producers' => ProducerResource::collection($producers)]);
    }

    /**
     * Получение производителя
     *
     * Права: `crud storages`
     *
     * @group Склады
     *
     * @urlParam producer integer required
     *
     * @param  Producer  $producer
     * @return JsonResponse
     */
    public function show(Producer $producer): JsonResponse
    {
        return response_json(['producer' => ProducerResource::make($producer)]);
    }

    /**
     * Добавление производителя
     *
     * Название должно быть уникально
     *
     * Права: `crud storages`
     *
     * @bodyParam name string required Уникальное название
     *
     * @group Склады
     *
     * @param  StoreRequest  $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $producer = $this->producerService->store($request->validated());

        return response_json(['producer' => ProducerResource::make($producer)]);
    }

    /**
     * Обновление производителя
     *
     * Права: `crud storages`
     *
     * @group Склады
     *
     * @urlParam producer integer required
     * @bodyParam name string required Уникальное название
     *
     * @param  UpdateRequest  $request
     * @param  int  $producerId
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, int $producerId): JsonResponse
    {
        $producer = $this->producerService->update($producerId, $request->validated());

        return response_json(['producer' => ProducerResource::make($producer)]);
    }

    /**
     * Удаление производителя
     *
     * Права: `crud storages`
     *
     * Удаление только если нет связанных таблиц
     *
     * @group Склады
     *
     * @urlParam producer integer required
     *
     * @param  int  $producerId
     * @return JsonResponse
     * @throws UsedInOtherTableException
     */
    public function destroy(int $producerId): JsonResponse
    {
        $this->producerService->delete($producerId);

        return response_success();
    }
}
