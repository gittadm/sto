<?php

namespace App\Services\Tasks;

use App\Exceptions\UsedInOtherTableException;
use App\Models\Checkbox;
use Throwable;

class CheckboxService
{
    /**
     * @param  Checkbox  $checkbox
     * @param  array  $data
     * @return Checkbox
     */
    public function update(Checkbox $checkbox, array $data): Checkbox
    {
        $checkbox->update($data);

        return $checkbox;
    }

    /**
     * @param  Checkbox  $checkbox
     * @param  array  $data
     * @return Checkbox
     */
    public function updateStatus(Checkbox $checkbox, array $data): Checkbox
    {
        $checkbox->update($data);

        return $checkbox;
    }

    /**
     * @param  Checkbox  $checkbox
     * @throws UsedInOtherTableException
     */
    public function delete(Checkbox $checkbox): void
    {
        try {
            $checkbox->delete();
        } catch (Throwable) {
            throw new UsedInOtherTableException(
                'Чекбокс нельзя удалить, так как он уже используется в других таблицах'
            );
        }
    }
}
