<?php

namespace App\Services\Cars;

use App\Exceptions\UsedInOtherTableException;
use Illuminate\Support\Collection;
use App\Models\Car;
use Throwable;

class CarService
{
    /**
     * @param  array  $filter
     * @return Collection
     */
    public function getAllWithClient(array $filter): Collection
    {
        $cars = Car::with('client', 'carModel.carMark', 'fuel', 'engineVolume');

        if (!empty($filter['client_id'])) {
            $cars->where('client_id', $filter['client_id']);
        }

        if (!empty($filter['car_model_id'])) {
            $cars->where('car_model_id', $filter['car_model_id']);
        }

        return $cars->orderBy('id')->get();
    }

    /**
     * @param  array  $data
     * @return Car
     */
    public function store(array $data): Car
    {
        return Car::create($data);
    }

    /**
     * @param  int  $carId
     * @return Car
     */
    public function getCarById(int $carId): Car
    {
        return Car::findOrFail($carId);
    }

    /**
     * @param  int  $carId
     * @param  array  $data
     * @return Car
     */
    public function update(int $carId, array $data): Car
    {
        $car = $this->getCarById($carId);
        $car->update($data);

        return $car;
    }

    /**
     * @param  int  $carId
     * @throws UsedInOtherTableException
     */
    public function delete(int $carId): void
    {
        try {
            Car::where('id', $carId)->delete();
        } catch (Throwable) {
            throw new UsedInOtherTableException(
                'Автомобиль нельзя удалить, так как он уже используется в других таблицах'
            );
        }
    }
}
