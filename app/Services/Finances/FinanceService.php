<?php

namespace App\Services\Finances;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Exceptions\UsedInOtherTableException;
use App\Models\Finance;
use Carbon\Carbon;
use Throwable;

class FinanceService
{
    /**
     * @param  array  $filter
     * @return LengthAwarePaginator
     */
    public function getPaginatedFinances(array $filter): LengthAwarePaginator
    {
        $finances = Finance::with('financeGroup');

        if (!empty($filter['order'])) {
            if ($filter['order'] === 'name') {
                $finances->orderBy('name');
            } elseif ($filter['order'] === 'sum') {
                $finances->orderBy('sum');
            } elseif ($filter['order'] === 'type') {
                $finances->orderBy('operation_type');
            } elseif ($filter['order'] === 'date') {
                $finances->orderBy('created_at', 'desc');
            } elseif ($filter['order'] === 'department') {
                $finances->orderBy('department_id');
            } else { // id or other
                $finances->orderBy('id', 'desc');
            }
        } else {
            $finances->orderBy('id', 'desc');
        }

        if (!empty($filter['name'])) {
            $finances->where('name', 'like', '%'.$filter['name'].'%');
        }

        if (!empty($filter['type'])) {
            $finances->where('operation_type', $filter['type']);
        }

        if (!empty($filter['department_id'])) {
            $finances->where('department_id', $filter['department_id']);
        }

        if (!empty($filter['sum'])) {
            $finances->where('sum', $filter['sum']);
        }

        if (!empty($filter['start_date'])) {
            $date = Carbon::parse($filter['start_date'])->startOfDay()->format('Y-m-d H:i:s');
            $finances->where('created_at', '>=', $date);
        }

        if (!empty($filter['end_date'])) {
            $date = Carbon::parse($filter['end_date'])->endOfDay()->format('Y-m-d H:i:s');
            $finances->where('created_at', '<=', $date);
        }

        return $finances->paginate(30);
    }

    /**
     * @param  array  $data
     * @return Finance
     */
    public function store(array $data): Finance
    {
        return Finance::create($data);
    }

    /**
     * @param  int  $financeId
     * @return Finance
     */
    public function getFinanceById(int $financeId): Finance
    {
        return Finance::findOrFail($financeId);
    }

    /**
     * @param  int  $financeId
     * @param  array  $data
     * @return Finance
     */
    public function update(int $financeId, array $data): Finance
    {
        $finance = $this->getFinanceById($financeId);
        $finance->update($data);

        return $finance;
    }

    /**
     * @param  int  $financeId
     * @throws UsedInOtherTableException
     */
    public function delete(int $financeId): void
    {
        try {
            Finance::where('id', $financeId)->delete();
        } catch (Throwable) {
            throw new UsedInOtherTableException(
                'Финансовую операцию нельзя удалить, так как она уже используется в других таблицах'
            );
        }
    }
}
