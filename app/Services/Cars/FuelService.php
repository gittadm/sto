<?php

namespace App\Services\Cars;

use App\Exceptions\UsedInOtherTableException;
use App\Models\Car;
use App\Models\Fuel;
use Illuminate\Support\Collection;
use Throwable;

class FuelService
{
    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Fuel::orderBy('name')->get();
    }

    /**
     * @param  array  $data
     * @return Fuel
     */
    public function store(array $data): Fuel
    {
        return Fuel::create($data);
    }

    /**
     * @param  int  $fuelId
     * @return Fuel
     */
    public function getFuelById(int $fuelId): Fuel
    {
        return Fuel::findOrFail($fuelId);
    }

    /**
     * @param  int  $fuelId
     * @param  array  $data
     * @return Fuel
     */
    public function update(int $fuelId, array $data): Fuel
    {
        $fuel = $this->getFuelById($fuelId);
        $fuel->update($data);

        return $fuel;
    }

    /**
     * @param  int  $fuelId
     * @throws UsedInOtherTableException
     */
    public function delete(int $fuelId): void
    {
        if (Car::where('fuel_id', $fuelId)->exists()) {
            throw new UsedInOtherTableException(
                'Вид топлива нельзя удалить, так как существует авто с таким топливом'
            );
        }

        try {
            Fuel::where('id', $fuelId)->delete();
        } catch (Throwable) {
            throw new UsedInOtherTableException(
                'Вид топлива нельзя удалить, так как он уже используется в других таблицах'
            );
        }
    }
}
