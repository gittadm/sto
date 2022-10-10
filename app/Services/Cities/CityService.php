<?php

namespace App\Services\Cities;

use App\Exceptions\UsedInOtherTableException;
use App\Models\City;
use App\Models\Client;
use Illuminate\Support\Collection;
use Throwable;

class CityService
{
    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return City::orderBy('name')->get();
    }

    /**
     * @param  array  $data
     * @return City
     */
    public function store(array $data): City
    {
        return City::create($data);
    }

    /**
     * @param  int  $cityId
     * @return City
     */
    public function getCityById(int $cityId): City
    {
        return City::findOrFail($cityId);
    }

    /**
     * @param  int  $cityId
     * @param  array  $data
     * @return City
     */
    public function update(int $cityId, array $data): City
    {
        $city = $this->getCityById($cityId);
        $city->update($data);

        return $city;
    }

    /**
     * @param  int  $cityId
     * @throws UsedInOtherTableException
     */
    public function delete(int $cityId): void
    {
        if (Client::where('city_id', $cityId)->exists()) {
            throw new UsedInOtherTableException(
                'Город нельзя удалить, так как существует клиент из этого города'
            );
        }

        try {
            City::where('id', $cityId)->delete();
        } catch (Throwable) {
            throw new UsedInOtherTableException(
                'Город нельзя удалить, так как существует клиент из этого города'
            );
        }
    }
}
