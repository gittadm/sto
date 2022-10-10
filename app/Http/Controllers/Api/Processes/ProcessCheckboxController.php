<?php

namespace App\Http\Controllers\Api\Processes;

use App\Http\Requests\ProcessTasks\Checkboxes\UpdateRequest;
use App\Http\Requests\ProcessTasks\Checkboxes\UpdateStatusRequest;
use App\Http\Resources\Processes\ProcessCheckboxResource;
use App\Services\Processes\ProcessCheckboxService;
use App\Exceptions\UsedInOtherTableException;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\ProcessCheckbox;
use App\Models\RoleConst;

class ProcessCheckboxController extends Controller
{
    /**
     * ProcessCheckboxController constructor.
     * @param  ProcessCheckboxService  $processCheckboxService
     */
    public function __construct(private ProcessCheckboxService $processCheckboxService)
    {
        $this->middleware(['permission:' . RoleConst::PERMISSION_PROCESSES_CRUD]);
    }

    /**
     * Обновление статуса чебокса
     *
     * Права: `crud processes`
     *
     * @group Процессы
     *
     * @urlParam process_checkbox integer required
     *
     * @param  UpdateStatusRequest  $request
     * @param  ProcessCheckbox  $processCheckbox
     * @return JsonResponse
     */
    public function changeIsCheckedStatus(UpdateStatusRequest $request, ProcessCheckbox $processCheckbox): JsonResponse
    {
        $this->processCheckboxService->updateStatus($processCheckbox, $request->validated());

        return response_json(['process_checkbox' => ProcessCheckboxResource::make($processCheckbox)]);
    }

    /**
     * Обновление чекбокса задачи
     *
     * Права: `crud processes`
     *
     * @group Процессы
     *
     * @urlParam process_checkbox integer required
     *
     * @param  UpdateRequest  $request
     * @param  ProcessCheckbox  $processCheckbox
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, ProcessCheckbox $processCheckbox): JsonResponse
    {
        $this->processCheckboxService->update($processCheckbox, $request->validated());

        return response_json(['process_checkbox' => ProcessCheckboxResource::make($processCheckbox)]);
    }

    /**
     * Удаление чекбокса задачи
     *
     * Права: `crud processes`
     *
     * @group Процессы
     *
     * @urlParam process_checkbox integer required
     *
     * @param  ProcessCheckbox  $processCheckbox
     * @return JsonResponse
     * @throws UsedInOtherTableException
     */
    public function destroy(ProcessCheckbox $processCheckbox): JsonResponse
    {
        $this->processCheckboxService->delete($processCheckbox);

        return response_success();
    }
}
