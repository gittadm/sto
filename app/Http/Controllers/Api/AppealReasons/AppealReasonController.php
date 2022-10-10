<?php

namespace App\Http\Controllers\Api\AppealReasons;

use App\Exceptions\UsedInOtherTableException;
use App\Http\Requests\AppealReasons\StoreRequest;
use App\Http\Requests\AppealReasons\UpdateRequest;
use App\Http\Resources\AppealReasons\AppealReasonResource;
use App\Services\AppealReasons\AppealReasonService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\AppealReason;
use App\Models\RoleConst;

class AppealReasonController extends Controller
{
    /**
     * AppealReasonController constructor.
     * @param  AppealReasonService  $appealReasonService
     */
    public function __construct(private AppealReasonService $appealReasonService)
    {
        $this->middleware(['permission:' . RoleConst::PERMISSION_PROCESSES_CRUD]);
    }

    /**
     * Список причин обращения
     *
     * Права: `crud processes`
     *
     * @group Процессы
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $appealReasons = $this->appealReasonService->getAll();

        return response_json(['appeal_reasons' => AppealReasonResource::collection($appealReasons)]);
    }

    /**
     * Получение причины обращения
     *
     * Права: `crud processes`
     *
     * @group Процессы
     *
     * @urlParam appeal_reason integer required
     *
     * @param  AppealReason  $appealReason
     * @return JsonResponse
     */
    public function show(AppealReason $appealReason): JsonResponse
    {
        return response_json(['appeal_reason' => AppealReasonResource::make($appealReason)]);
    }

    /**
     * Добавление причины обращения
     *
     * Права: `crud processes`
     *
     * @bodyParam name string required
     *
     * @group Процессы
     *
     * @param  StoreRequest  $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $appealReason = $this->appealReasonService->store($request->validated());

        return response_json(['appeal_reason' => AppealReasonResource::make($appealReason)]);
    }

    /**
     * Обновление причины обращения
     *
     * Права: `crud processes`
     *
     * @group Процессы
     *
     * @urlParam appeal_reason integer required
     *
     * @param  UpdateRequest  $request
     * @param  int  $appealReasonId
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, int $appealReasonId): JsonResponse
    {
        $appealReason = $this->appealReasonService->update($appealReasonId, $request->validated());

        return response_json(['appeal_reason' => AppealReasonResource::make($appealReason)]);
    }

    /**
     * Удаление причины обращения
     *
     * Права: `crud processes`
     *
     * Удаление только если нет связанных таблиц
     *
     * @group Процессы
     *
     * @urlParam appeal_reason integer required
     *
     * @param  int  $appealReasonId
     * @return JsonResponse
     * @throws UsedInOtherTableException
     */
    public function destroy(int $appealReasonId): JsonResponse
    {
        $this->appealReasonService->delete($appealReasonId);

        return response_success();
    }
}
