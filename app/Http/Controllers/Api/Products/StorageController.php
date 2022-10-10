<?php

namespace App\Http\Controllers\Api\Products;

use App\Exceptions\UsedInOtherTableException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Storages\StoreRequest;
use App\Http\Requests\Storages\UpdateRequest;
use App\Http\Resources\Products\StorageResource;
use App\Models\Storage;
use App\Services\Products\StorageService;
use Illuminate\Http\JsonResponse;
use App\Models\RoleConst;

class StorageController extends Controller
{
    /**
     * StorageController constructor.
     * @param  StorageService  $storageService
     */
    public function __construct(private StorageService $storageService)
    {
        $this->middleware(['permission:' . RoleConst::PERMISSION_STORAGES_CRUD]);
    }

    /**
     * Список складов
     *
     * Права: `crud storages`
     *
     * @group Склады
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $storages = $this->storageService->getAll();

        return response_json(['storages' => StorageResource::collection($storages)]);
    }

    /**
     * Получение склада
     *
     * Права: `crud storages`
     *
     * @group Склады
     *
     * @urlParam storage integer required
     *
     * @param  Storage  $storage
     * @return JsonResponse
     */
    public function show(Storage $storage): JsonResponse
    {
        return response_json(['storage' => StorageResource::make($storage)]);
    }

    /**
     * Добавление склада
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
        $storage = $this->storageService->store($request->validated());

        return response_json(['storage' => StorageResource::make($storage)]);
    }

    /**
     * Обновление склада
     *
     * Права: `crud storages`
     *
     * @group Склады
     *
     * @urlParam storage integer required
     * @bodyParam name string required Уникальное название
     *
     * @param  UpdateRequest  $request
     * @param  int  $storageId
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, int $storageId): JsonResponse
    {
        $storage = $this->storageService->update($storageId, $request->validated());

        return response_json(['storage' => StorageResource::make($storage)]);
    }

    /**
     * Удаление склада
     *
     * Права: `crud storages`
     *
     * Удаление только если нет связанных таблиц
     *
     * @group Склады
     *
     * @urlParam storage integer required
     *
     * @param  int  $storageId
     * @return JsonResponse
     * @throws UsedInOtherTableException
     */
    public function destroy(int $storageId): JsonResponse
    {
        $this->storageService->delete($storageId);

        return response_success();
    }
}
