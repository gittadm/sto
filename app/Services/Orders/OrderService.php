<?php

namespace App\Services\Orders;

use Illuminate\Support\Collection;
use App\Models\Order;

class OrderService
{
    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Order::with('user', 'client', 'car', 'department', 'appealReason')
            ->orderBy('id')->get();
    }

    /**
     * @param  array  $data
     * @return Order
     */
    public function store(array $data): Order
    {
        return Order::create($data);
    }

    /**
     * @param  int  $orderId
     * @return Order
     */
    public function getOrderById(int $orderId): Order
    {
        return Order::findOrFail($orderId);
    }

    /**
     * @param  int  $orderId
     * @param  array  $data
     * @return Order
     */
    public function update(int $orderId, array $data): Order
    {
        $order = $this->getOrderById($orderId);
        $order->update($data);

        return $order;
    }

    /**
     * @param  int  $orderId
     */
    public function delete(int $orderId): void
    {
        Order::where('id', $orderId)->delete();
    }
}
