<?php

namespace App\Http\Controllers\Api\Documents;

use App\Exceptions\UsedInOtherTableException;
use App\Http\Requests\DocumentTemplates\StoreRequest;
use App\Http\Requests\DocumentTemplates\UpdateRequest;
use App\Http\Resources\Documents\DocumentTemplateResource;
use App\Services\Documents\DocumentTemplateService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\DocumentTemplate;
use App\Models\RoleConst;

class DocumentTemplateController extends Controller
{
    /**
     * DocumentTemplateController constructor.
     * @param  DocumentTemplateService  $documentTemplateService
     */
    public function __construct(private DocumentTemplateService $documentTemplateService)
    {
        $this->middleware(['permission:' . RoleConst::PERMISSION_DOCUMENT_TEMPLATES_CRUD]);
    }

    /**
     * Список шаблонов документов
     *
     * Права: `crud document templates`
     *
     * @group Документы
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $documentTemplates = $this->documentTemplateService->getAll();

        return response_json(['document_templates' => DocumentTemplateResource::collection($documentTemplates)]);
    }

    /**
     * Получение шаблона документов
     *
     * Права: `crud document templates`
     *
     * @group Документы
     *
     * @urlParam document_template integer required
     *
     * @param  DocumentTemplate  $documentTemplate
     * @return JsonResponse
     */
    public function show(DocumentTemplate $documentTemplate): JsonResponse
    {
        return response_json(['document_template' => DocumentTemplateResource::make($documentTemplate)]);
    }

    /**
     * Добавление шаблона документов
     *
     * Права: `crud document templates`
     *
     * @bodyParam name string required
     *
     * @group Документы
     *
     * @param  StoreRequest  $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $documentTemplate = $this->documentTemplateService->store($request->validated());

        return response_json(['document_template' => DocumentTemplateResource::make($documentTemplate)]);
    }

    /**
     * Обновление шаблона документов
     *
     * Права: `crud document templates`
     *
     * @group Документы
     *
     * @urlParam document_template integer required
     *
     * @param  UpdateRequest  $request
     * @param  int  $documentTemplateId
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, int $documentTemplateId): JsonResponse
    {
        $documentTemplate = $this->documentTemplateService->update($documentTemplateId, $request->validated());

        return response_json(['document_template' => DocumentTemplateResource::make($documentTemplate)]);
    }

    /**
     * Удаление шаблона документов
     *
     * Права: `crud document templates`
     *
     * Удаление только если нет связанных таблиц
     *
     * @group Документы
     *
     * @urlParam document_template integer required
     *
     * @param  int  $documentTemplateId
     * @return JsonResponse
     * @throws UsedInOtherTableException
     */
    public function destroy(int $documentTemplateId): JsonResponse
    {
        $this->documentTemplateService->delete($documentTemplateId);

        return response_success();
    }
}
