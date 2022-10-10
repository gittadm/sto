<?php

namespace App\Http\Controllers\Api\Orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\StoreRequest;
use App\Http\Requests\Orders\UpdateRequest;
use App\Http\Resources\Orders\OrderResource;
use App\Models\Order;
use App\Models\RoleConst;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService)
    {
        $this->middleware(['permission:' . RoleConst::PERMISSION_DEPARTMENTS_CRUD]);
    }

    /**
     * Список заказ-нарядов
     *
     * Права: `crud orders`
     *
     * Упорядочены по названию (name)
     *
     * @group Заказ-наряды
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $orders = $this->orderService->getAll();

        return response_json(['orders' => OrderResource::collection($orders)]);
    }

    /**
     * Получение заказ-наряда
     *
     * Права: `crud orders`
     *
     * @group Заказ-наряды
     *
     * @param  Order  $order
     * @return JsonResponse
     */
    public function show(Order $order): JsonResponse
    {
        return response_json(['order' => OrderResource::make($order)]);
    }

    /**
     * Добавление заказ-наряда
     *
     * Права: `crud orders`
     *
     * @group Заказ-наряды
     *
     * @param  StoreRequest  $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $order = $this->orderService->store($request->validated());

        return response_json(['order' => OrderResource::make($order)]);
    }

    /**
     * Обновление заказ-наряда
     *
     * Права: `crud orders`
     *
     * @group Заказ-наряды
     *
     * @param  UpdateRequest  $request
     * @param  int  $orderId
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, int $orderId): JsonResponse
    {
        $order = $this->orderService->update($orderId, $request->validated());

        return response_json(['order' => OrderResource::make($order)]);
    }

    /**
     * Удаление заказ-наряда
     *
     * Права: `crud orders`
     *
     * @group Заказ-наряды
     *
     * @param  int  $orderId
     * @return JsonResponse
     */
    public function destroy(int $orderId): JsonResponse
    {
        $this->orderService->delete($orderId);

        return response_success();
    }
}
