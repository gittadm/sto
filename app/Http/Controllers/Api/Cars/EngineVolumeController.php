<?php

namespace App\Http\Controllers\Api\Cars;

use App\Exceptions\UsedInOtherTableException;
use App\Http\Controllers\Controller;
use App\Http\Requests\EngineVolumes\StoreRequest;
use App\Http\Requests\EngineVolumes\UpdateRequest;
use App\Http\Resources\Cars\EngineVolumeResource;
use App\Models\EngineVolume;
use App\Services\Cars\EngineVolumeService;
use Illuminate\Http\JsonResponse;
use App\Models\RoleConst;

class EngineVolumeController extends Controller
{
    /**
     * EngineVolumeController constructor.
     * @param  EngineVolumeService  $engineVolumeService
     */
    public function __construct(private EngineVolumeService $engineVolumeService)
    {
        $this->middleware(['permission:' . RoleConst::PERMISSION_ENGINE_VOLUMES_CRUD]);
    }

    /**
     * Список объемов двигателей
     *
     * Права: `crud engine volumes`
     *
     * @group Автомобили
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $engineVolumes = $this->engineVolumeService->getAll();

        return response_json(['engine_volumes' => EngineVolumeResource::collection($engineVolumes)]);
    }

    /**
     * Получение объема двигателя
     *
     * Права: `crud engine volumes`
     *
     * @group Автомобили
     *
     * @urlParam engine_volume integer required
     *
     * @param  EngineVolume  $engineVolume
     * @return JsonResponse
     */
    public function show(EngineVolume $engineVolume): JsonResponse
    {
        return response_json(['engine_volume' => EngineVolumeResource::make($engineVolume)]);
    }

    /**
     * Добавление объема двигателя
     *
     * Объем должен быть уникальным
     *
     * Права: `crud engine volumes`
     *
     * @group Автомобили
     *
     * @bodyParam value numeric Уникальное число не более чем с одним знаком после точки, от 0 до 10 включительно
     *
     * @param  StoreRequest  $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $engineVolume = $this->engineVolumeService->store($request->validated());

        return response_json(['engine_volume' => EngineVolumeResource::make($engineVolume)]);
    }

    /**
     * Обновление объема двигателя
     *
     * Права: `crud engine volumes`
     *
     * @group Автомобили
     *
     * @urlParam engine_volume integer required
     *
     * @bodyParam value numeric Уникальное число не более чем с одним знаком после точки, от 0 до 10 включительно
     *
     * @param  UpdateRequest  $request
     * @param  int  $engineVolumeId
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, int $engineVolumeId): JsonResponse
    {
        $engineVolume = $this->engineVolumeService->update($engineVolumeId, $request->validated());

        return response_json(['engine_volume' => EngineVolumeResource::make($engineVolume)]);
    }

    /**
     * Удаление объема двигателя
     *
     * Права: `crud engine volumes`
     *
     * Удаление только если нет автомобилей с таким объемом или других связанных таблиц
     *
     * @group Автомобили
     *
     * @urlParam engine_volume integer required
     *
     * @param  int  $engineVolumeId
     * @return JsonResponse
     * @throws UsedInOtherTableException
     */
    public function destroy(int $engineVolumeId): JsonResponse
    {
        $this->engineVolumeService->delete($engineVolumeId);

        return response_success();
    }
}
