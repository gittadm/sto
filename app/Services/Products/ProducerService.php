<?php

namespace App\Services\Products;

use App\Exceptions\UsedInOtherTableException;
use App\Models\Producer;
use Illuminate\Support\Collection;
use Throwable;

class ProducerService
{
    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Producer::orderBy('name')->get();
    }

    /**
     * @param  array  $data
     * @return Producer
     */
    public function store(array $data): Producer
    {
        return Producer::create($data);
    }

    /**
     * @param  int  $producerId
     * @return Producer
     */
    public function getProducerById(int $producerId): Producer
    {
        return Producer::findOrFail($producerId);
    }

    /**
     * @param  int  $producerId
     * @param  array  $data
     * @return Producer
     */
    public function update(int $producerId, array $data): Producer
    {
        $producer = $this->getProducerById($producerId);
        $producer->update($data);

        return $producer;
    }

    /**
     * @param  int  $producerId
     * @throws UsedInOtherTableException
     */
    public function delete(int $producerId): void
    {
        try {
            Producer::where('id', $producerId)->delete();
        } catch (Throwable) {
            throw new UsedInOtherTableException(
                'Производителя нельзя удалить, так как он уже используется в других таблицах'
            );
        }
    }
}
