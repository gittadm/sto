<?php

namespace App\Services\Products;

use App\Exceptions\UsedInOtherTableException;
use App\Models\Storage;
use Illuminate\Support\Collection;
use Throwable;

class StorageService
{
    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Storage::orderBy('name')->get();
    }

    /**
     * @param  array  $data
     * @return Storage
     */
    public function store(array $data): Storage
    {
        return Storage::create($data);
    }

    /**
     * @param  int  $storageId
     * @return Storage
     */
    public function getStorageById(int $storageId): Storage
    {
        return Storage::findOrFail($storageId);
    }

    /**
     * @param  int  $storageId
     * @param  array  $data
     * @return Storage
     */
    public function update(int $storageId, array $data): Storage
    {
        $storage = $this->getStorageById($storageId);
        $storage->update($data);

        return $storage;
    }

    /**
     * @param  int  $storageId
     * @throws UsedInOtherTableException
     */
    public function delete(int $storageId): void
    {
        try {
            Storage::where('id', $storageId)->delete();
        } catch (Throwable) {
            throw new UsedInOtherTableException(
                'Склад нельзя удалить, так как он уже используется в других таблицах'
            );
        }
    }
}
