<?php

namespace App\Http\Controllers\Api\Pipelines;

use App\Exceptions\CustomValidationException;
use App\Exceptions\UsedInOtherTableException;
use App\Http\Requests\Pipelines\StoreRequest;
use App\Http\Requests\Pipelines\UpdateRequest;
use App\Http\Resources\Pipelines\PipelineResource;
use App\Models\Pipeline;
use App\Services\Pipelines\PipelineService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PipelineController extends Controller
{
    /**
     * PipelineController constructor.
     * @param  PipelineService  $pipelineService
     */
    public function __construct(private PipelineService $pipelineService) {}

    /**
     * Список воронок
     *
     * Получение списка воронок с этапами.
     * С помощью дополнительных параметров в url можно указать тип воронки
     *
     * @urlParam type string Например, type = `task`
     *
     * @group Воронки
     *
     * @param  Request  $request
     * @return JsonResponse
     * @throws CustomValidationException
     */
    public function index(Request $request): JsonResponse
    {
        $pipelines = $this->pipelineService->getAll($request->all());

        return response_json(['pipelines' => PipelineResource::collection($pipelines)]);
    }

    /**
     * Получение воронки
     *
     * @group Воронки
     *
     * @urlParam pipeline integer required
     *
     * @param  Pipeline  $pipeline
     * @return JsonResponse
     */
    public function show(Pipeline $pipeline): JsonResponse
    {
        return response_json(['pipeline' => PipelineResource::make($pipeline)]);
    }

    /**
     * Добавление воронки
     *
     * Права: `crud pipelines`
     *
     * @bodyParam name string required
     * @bodyParam type string required Например, type = `task`
     *
     * @group Воронки
     *
     * @param  StoreRequest  $request
     * @return JsonResponse
     * @throws CustomValidationException
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $pipeline = $this->pipelineService->store($request->validated());

        return response_json(['pipeline' => PipelineResource::make($pipeline)]);
    }

    /**
     * Обновление воронки
     *
     * Права: `crud pipelines`
     *
     * @group Воронки
     *
     * @urlParam pipeline integer required
     * @bodyParam name string required
     * @bodyParam type string required Например, type = `task`
     *
     * @param  UpdateRequest  $request
     * @param  int  $pipelineId
     * @return JsonResponse
     * @throws CustomValidationException
     */
    public function update(UpdateRequest $request, int $pipelineId): JsonResponse
    {
        $pipeline = $this->pipelineService->update($pipelineId, $request->validated());

        return response_json(['pipeline' => PipelineResource::make($pipeline)]);
    }

    /**
     * Удаление воронки
     *
     * Права: `crud pipelines`
     *
     * Удаление только если нет автомобилей с таким топливом или других связанных таблиц
     *
     * @group Воронки
     *
     * @urlParam pipeline integer required
     *
     * @param  int  $pipelineId
     * @return JsonResponse
     * @throws UsedInOtherTableException
     */
    public function destroy(int $pipelineId): JsonResponse
    {
        $this->pipelineService->delete($pipelineId);

        return response_success();
    }
}
