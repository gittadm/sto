<?php

namespace App\Http\Controllers\Api\MapQuestions;

use App\Exceptions\UsedInOtherTableException;
use App\Http\Controllers\Controller;
use App\Http\Requests\MapQuestions\StoreRequest;
use App\Http\Requests\MapQuestions\UpdateRequest;
use App\Http\Resources\MapQuestions\MapQuestionResource;
use App\Models\MapQuestion;
use App\Services\MapQuestions\MapQuestionService;
use Illuminate\Http\JsonResponse;
use App\Models\RoleConst;

class MapQuestionController extends Controller
{
    /**
     * MapQuestionController constructor.
     * @param  MapQuestionService  $mapQuestionService
     */
    public function __construct(private MapQuestionService $mapQuestionService)
    {
        $this->middleware(['permission:' . RoleConst::PERMISSION_PROCESSES_CRUD]);
    }

    /**
     * Список вопросов
     *
     * Список вопросов диагностической карты
     *
     * Права: `crud processes`
     *
     * @group Процессы
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $mapQuestions = $this->mapQuestionService->getAll();

        return response_json(['map_questions' => MapQuestionResource::collection($mapQuestions)]);
    }

    /**
     * Получение вопроса
     *
     * Получение вопроса диагностической карты
     *
     * Права: `crud processes`
     *
     * @group Процессы
     *
     * @urlParam map_question integer required
     *
     * @param  MapQuestion  $mapQuestion
     * @return JsonResponse
     */
    public function show(MapQuestion $mapQuestion): JsonResponse
    {
        return response_json(['map_question' => MapQuestionResource::make($mapQuestion)]);
    }

    /**
     * Добавление вопроса
     *
     * Добавление вопроса диагностической карты
     *
     * Права: `crud processes`
     *
     * @bodyParam question string required
     * @bodyParam answer string
     * @bodyParam recommendations string
     *
     * @group Процессы
     *
     * @param  StoreRequest  $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $mapQuestion = $this->mapQuestionService->store($request->validated());

        return response_json(['map_question' => MapQuestionResource::make($mapQuestion)]);
    }

    /**
     * Обновление вопроса
     *
     * Обновление вопроса диагностической карты
     *
     * Права: `crud processes`
     *
     * @group Процессы
     *
     * @urlParam map_question integer required
     *
     * @param  UpdateRequest  $request
     * @param  int  $mapQuestionId
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, int $mapQuestionId): JsonResponse
    {
        $mapQuestion = $this->mapQuestionService->update($mapQuestionId, $request->validated());

        return response_json(['map_question' => MapQuestionResource::make($mapQuestion)]);
    }

    /**
     * Удаление вопроса
     *
     * Удаление вопроса диагностической карты
     *
     * Права: `crud processes`
     *
     * Удаление только если нет связанных таблиц
     *
     * @group Процессы
     *
     * @urlParam map_question integer required
     *
     * @param  int  $mapQuestionId
     * @return JsonResponse
     * @throws UsedInOtherTableException
     */
    public function destroy(int $mapQuestionId): JsonResponse
    {
        $this->mapQuestionService->delete($mapQuestionId);

        return response_success();
    }
}
