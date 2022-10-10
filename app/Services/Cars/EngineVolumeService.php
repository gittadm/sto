<?php

namespace App\Services\Cars;

use App\Exceptions\UsedInOtherTableException;
use App\Models\EngineVolume;
use App\Models\Car;
use Illuminate\Support\Collection;
use Throwable;

class EngineVolumeService
{
    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return EngineVolume::orderBy('value')->get();
    }

    /**
     * @param  array  $data
     * @return EngineVolume
     */
    public function store(array $data): EngineVolume
    {
        return EngineVolume::create($data);
    }

    /**
     * @param  int  $engineVolumeId
     * @return EngineVolume
     */
    public function getEngineVolumeById(int $engineVolumeId): EngineVolume
    {
        return EngineVolume::findOrFail($engineVolumeId);
    }

    /**
     * @param  int  $engineVolumeId
     * @param  array  $data
     * @return EngineVolume
     */
    public function update(int $engineVolumeId, array $data): EngineVolume
    {
        $engineVolume = $this->getEngineVolumeById($engineVolumeId);
        $engineVolume->update($data);

        return $engineVolume;
    }

    /**
     * @param  int  $engineVolumeId
     * @throws UsedInOtherTableException
     */
    public function delete(int $engineVolumeId): void
    {
        if (Car::where('engine_volume_id', $engineVolumeId)->exists()) {
            throw new UsedInOtherTableException(
                'Объем двигателя нельзя удалить, так как существует авто с таким объемом'
            );
        }

        try {
            EngineVolume::where('id', $engineVolumeId)->delete();
        } catch (Throwable) {
            throw new UsedInOtherTableException(
                'Объем двигателя нельзя удалить, так как он уже используется в других таблицах'
            );
        }
    }
}
