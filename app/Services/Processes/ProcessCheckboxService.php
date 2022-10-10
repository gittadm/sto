<?php

namespace App\Services\Processes;

use App\Exceptions\UsedInOtherTableException;
use App\Models\ProcessCheckbox;
use Throwable;

class ProcessCheckboxService
{
    /**
     * @param  ProcessCheckbox  $checkbox
     * @param  array  $data
     * @return ProcessCheckbox
     */
    public function update(ProcessCheckbox $checkbox, array $data): ProcessCheckbox
    {
        $checkbox->update($data);

        return $checkbox;
    }

    /**
     * @param  ProcessCheckbox  $checkbox
     * @param  array  $data
     * @return ProcessCheckbox
     */
    public function updateStatus(ProcessCheckbox $checkbox, array $data): ProcessCheckbox
    {
        $checkbox->update($data);

        return $checkbox;
    }

    /**
     * @param  ProcessCheckbox  $checkbox
     * @throws UsedInOtherTableException
     */
    public function delete(ProcessCheckbox $checkbox): void
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
