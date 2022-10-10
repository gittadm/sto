<?php

namespace App\Services\Pipelines;

use App\Exceptions\CustomValidationException;
use App\Exceptions\UsedInOtherTableException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Pipeline;
use Throwable;

class PipelineService
{
    /**
     * @param  array  $filter
     * @return Builder[]|Collection
     * @throws CustomValidationException
     */
    public function getAll(array $filter): Collection|array
    {
        $pipelines = Pipeline::with('stages');

        if (!empty($filter['type'])) {
            $model = Pipeline::getModelClass($filter['type']);
            $pipelines->where('type', $model);
        } else {
            $pipelines->orderBy('type');
        }

        return $pipelines->orderBy('name')->get();
    }

    /**
     * @param  array  $data
     * @return Pipeline
     * @throws CustomValidationException
     */
    public function store(array $data): Pipeline
    {
        $data['type'] = Pipeline::getModelClass($data['type']);
        return Pipeline::create($data);
    }

    /**
     * @param  int  $pipelineId
     * @return Pipeline
     */
    public function getPipelineById(int $pipelineId): Pipeline
    {
        return Pipeline::findOrFail($pipelineId);
    }

    /**
     * @param  int  $pipelineId
     * @param  array  $data
     * @return Pipeline
     * @throws CustomValidationException
     */
    public function update(int $pipelineId, array $data): Pipeline
    {
        $pipeline = $this->getPipelineById($pipelineId);
        $data['type'] = Pipeline::getModelClass($data['type']);
        $pipeline->update($data);

        return $pipeline;
    }

    /**
     * @param  int  $pipelineId
     * @throws UsedInOtherTableException
     */
    public function delete(int $pipelineId): void
    {
        try {
            Pipeline::where('id', $pipelineId)->delete();
        } catch (Throwable) {
            throw new UsedInOtherTableException(
                'Воронку нельзя удалить, так как она уже используется в других таблицах'
            );
        }
    }
}
