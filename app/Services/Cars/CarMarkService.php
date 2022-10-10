<?php

namespace App\Services\Cars;

use App\Exceptions\UsedInOtherTableException;
use App\Models\CarMark;
use App\Models\CarModel;
use Illuminate\Support\Collection;
use Throwable;

class CarMarkService
{
    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return CarMark::orderBy('name')->get();
    }

    /**
     * @param  array  $data
     * @return CarMark
     */
    public function store(array $data): CarMark
    {
        return CarMark::create($data);
    }

    /**
     * @param  int  $carMarkId
     * @return CarMark
     */
    public function getCarMarkById(int $carMarkId): CarMark
    {
        return CarMark::findOrFail($carMarkId);
    }

    /**
     * @param  int  $carMarkId
     * @param  array  $data
     * @return CarMark
     */
    public function update(int $carMarkId, array $data): CarMark
    {
        $carMark = $this->getCarMarkById($carMarkId);
        $carMark->update($data);

        return $carMark;
    }

    /**
     * @param  int  $carMarkId
     * @throws UsedInOtherTableException
     */
    public function delete(int $carMarkId): void
    {
        if (CarModel::where('car_mark_id', $carMarkId)->exists()) {
            throw new UsedInOtherTableException(
                'Марку нельзя удалить, так как существует модель авто с этой маркой'
            );
        }

        try {
            CarMark::where('id', $carMarkId)->delete();
        } catch (Throwable) {
            throw new UsedInOtherTableException(
                'Марку нельзя удалить, так как она уже используется в других таблицах'
            );
        }
    }
}
