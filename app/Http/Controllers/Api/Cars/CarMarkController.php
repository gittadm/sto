<?php

namespace App\Http\Controllers\Api\Cars;

use App\Exceptions\UsedInOtherTableException;
use App\Http\Controllers\Controller;
use App\Http\Requests\CarMarks\StoreRequest;
use App\Http\Requests\CarMarks\UpdateRequest;
use App\Http\Resources\Cars\CarMarkResource;
use App\Services\Cars\CarMarkService;
use Illuminate\Http\JsonResponse;
use App\Models\RoleConst;
use App\Models\CarMark;

class CarMarkController extends Controller
{
    /**
     * CarMarkController constructor.
     * @param  CarMarkService  $carMarkService
     */
    public function __construct(private CarMarkService $carMarkService)
    {
        $this->middleware(['permission:' . RoleConst::PERMISSION_CAR_MARKS_CRUD]);
    }

    /**
     * Список марок автомобилей
     *
     * Права: `crud car marks`
     *
     * @group Автомобили
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $carMarks = $this->carMarkService->getAll();

        return response_json(['car_marks' => CarMarkResource::collection($carMarks)]);
    }

    /**
     * Получение марки автомобиля
     *
     * Права: `crud car marks`
     *
     * @group Автомобили
     *
     * @urlParam car_mark integer required
     *
     * @param  CarMark  $carMark
     * @return JsonResponse
     */
    public function show(CarMark $carMark): JsonResponse
    {
        return response_json(['car_mark' => CarMarkResource::make($carMark)]);
    }

    /**
     * Добавление марки автомобиля
     *
     * Название марки должно быть уникально
     *
     * Права: `crud car marks`
     *
     * @group Автомобили
     *
     * @param  StoreRequest  $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $carMark = $this->carMarkService->store($request->validated());

        return response_json(['car_mark' => CarMarkResource::make($carMark)]);
    }

    /**
     * Обновление марки автомобиля
     *
     * Права: `crud car marks`
     *
     * @group Автомобили
     *
     * @urlParam car_mark integer required
     *
     * @param  UpdateRequest  $request
     * @param  int  $carMarkId
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, int $carMarkId): JsonResponse
    {
        $carMark = $this->carMarkService->update($carMarkId, $request->validated());

        return response_json(['car_mark' => CarMarkResource::make($carMark)]);
    }

    /**
     * Удаление марки автомобиля
     *
     * Права: `crud car marks`
     *
     * Удаление только если нет моделей автомобилей с такой маркой или других связанных таблиц
     *
     * @group Автомобили
     *
     * @urlParam car_mark integer required
     *
     * @param  int  $carMarkId
     * @return JsonResponse
     * @throws UsedInOtherTableException
     */
    public function destroy(int $carMarkId): JsonResponse
    {
        $this->carMarkService->delete($carMarkId);

        return response_success();
    }
}
