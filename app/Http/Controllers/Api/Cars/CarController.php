<?php

namespace App\Http\Controllers\Api\Cars;

use App\Exceptions\UsedInOtherTableException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cars\StoreRequest;
use App\Http\Requests\Cars\UpdateRequest;
use App\Http\Resources\Cars\CarResource;
use App\Services\Cars\CarService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\RoleConst;
use App\Models\Car;

class CarController extends Controller
{
    /**
     * CarController constructor.
     * @param  CarService  $carService
     */
    public function __construct(private CarService $carService)
    {
        $this->middleware(['permission:' . RoleConst::PERMISSION_CARS_CRUD]);
    }

    /**
     * Список автомобилей
     *
     * Получение списка автомобилей с текущими клиентами.
     * С помощью дополнительных параметров в url можно указать клиента, модель.
     *
     * Права: `crud cars`
     *
     * @group Автомобили
     *
     * @urlParam client_id integer Получение автомобилей только указанного клиента
     * @urlParam car_model_id integer Получение автомобилей только указанной модели
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $cars = $this->carService->getAllWithClient($request->all());

        return response_json(['cars' => CarResource::collection($cars)]);
    }

    /**
     * Получение автомобиля
     *
     * Права: `crud cars`
     *
     * @group Автомобили
     *
     * @param  Car  $car
     * @return JsonResponse
     */
    public function show(Car $car): JsonResponse
    {
        return response_json(['car' => CarResource::make($car)]);
    }

    /**
     * Добавление автомобиля
     *
     * Права: `crud cars`
     *
     * @group Автомобили
     *
     * @param  StoreRequest  $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $car = $this->carService->store($request->validated());

        return response_json(['car' => CarResource::make($car)]);
    }

    /**
     * Обновление автомобиля
     *
     * Права: `crud cars`
     *
     * @group Автомобили
     *
     * @param  UpdateRequest  $request
     * @param  int  $carId
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, int $carId): JsonResponse
    {
        $car = $this->carService->update($carId, $request->validated());

        return response_json(['car' => CarResource::make($car)]);
    }

    /**
     * Удаление автомобиля
     *
     * Права: `crud cars`
     *
     * @group Автомобили
     *
     * @param  int  $carId
     * @return JsonResponse
     * @throws UsedInOtherTableException
     */
    public function destroy(int $carId): JsonResponse
    {
        $this->carService->delete($carId);

        return response_success();
    }
}
