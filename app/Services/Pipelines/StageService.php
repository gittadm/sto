<?php

namespace App\Services\Pipelines;

use App\Exceptions\UsedInOtherTableException;
use App\Models\Stage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Throwable;

class StageService
{
    /**
     * @param  int  $pipelineId
     * @return Stage[]|Builder[]|Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public function getByPipelineId(int $pipelineId): array|Collection|\Illuminate\Support\Collection
    {
        return Stage::where('pipeline_id', $pipelineId)->orderBy('id')->get();
    }

    /**
     * @param  array  $data
     * @return Stage
     */
    public function store(array $data): Stage
    {
        return Stage::create($data);
    }

    /**
     * @param  int  $stageId
     * @return Stage
     */
    public function getStageById(int $stageId): Stage
    {
        return Stage::findOrFail($stageId);
    }

    /**
     * @param  int  $stageId
     * @param  array  $data
     * @return Stage
     */
    public function update(int $stageId, array $data): Stage
    {
        $stage = $this->getStageById($stageId);
        $stage->update($data);

        return $stage;
    }

    /**
     * @param  int  $stageId
     * @throws UsedInOtherTableException
     */
    public function delete(int $stageId): void
    {
        try {
            Stage::where('id', $stageId)->delete();
        } catch (Throwable) {
            throw new UsedInOtherTableException(
                'Этап нельзя удалить, так как он уже используется в других таблицах'
            );
        }
    }
}
