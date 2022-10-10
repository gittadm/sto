<?php

namespace App\Http\Controllers\Api\Pipelines;

use App\Exceptions\UsedInOtherTableException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Stages\PipelineRequest;
use App\Http\Requests\Stages\StoreRequest;
use App\Http\Requests\Stages\UpdateRequest;
use App\Http\Resources\Pipelines\StageResource;
use App\Models\Stage;
use App\Services\Pipelines\StageService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class StageController extends Controller
{
    /**
     * StageController constructor.
     * @param  StageService  $stageService
     */
    public function __construct(private StageService $stageService) {}

    /**
     * Список этапов воронки
     *
     * Получение списка этапов по id воронки
     *
     * @urlParam pipeline_id integer required ID воронки
     *
     * @group Воронки
     *
     * @param  PipelineRequest  $request
     * @return JsonResponse
     */
    public function index(PipelineRequest $request): JsonResponse
    {
        $stages = $this->stageService->getByPipelineId($request->validated()['pipeline_id']);

        return response_json(['stages' => StageResource::collection($stages)]);
    }

    /**
     * Получение этапа
     *
     * @group Воронки
     *
     * @urlParam stage integer required
     *
     * @param  Stage  $stage
     * @return JsonResponse
     */
    public function show(Stage $stage): JsonResponse
    {
        return response_json(['stage' => StageResource::make($stage)]);
    }

    /**
     * Добавление воронки
     *
     * Права: `crud pipelines`
     *
     * @bodyParam name string required
     *
     * @group Воронки
     *
     * @param  StoreRequest  $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $this->authorize('pipelines-crud');

        $stage = $this->stageService->store($request->validated());

        return response_json(['stage' => StageResource::make($stage)]);
    }

    /**
     * Обновление этапа
     *
     * Права: `crud pipelines`
     *
     * @group Воронки
     *
     * @urlParam stage integer required
     * @bodyParam name string required
     *
     * @param  UpdateRequest  $request
     * @param  int  $stageId
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(UpdateRequest $request, int $stageId): JsonResponse
    {
        $this->authorize('pipelines-crud');

        $stage = $this->stageService->update($stageId, $request->validated());

        return response_json(['stage' => StageResource::make($stage)]);
    }

    /**
     * Удаление этапа
     *
     * Права: `crud pipelines`
     *
     * @group Воронки
     *
     * @urlParam stage integer required
     *
     * @param  int  $stageId
     * @return JsonResponse
     * @throws UsedInOtherTableException
     * @throws AuthorizationException
     */
    public function destroy(int $stageId): JsonResponse
    {
        $this->authorize('pipelines-crud');

        $this->stageService->delete($stageId);

        return response_success();
    }
}
