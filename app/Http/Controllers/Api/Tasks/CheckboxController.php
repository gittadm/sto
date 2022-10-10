<?php

namespace App\Http\Controllers\Api\Tasks;

use App\Http\Requests\Tasks\Checkboxes\UpdateRequest;
use App\Http\Requests\Tasks\Checkboxes\UpdateStatusRequest;
use App\Http\Resources\Tasks\CheckboxResource;
use App\Models\Checkbox;
use Illuminate\Auth\Access\AuthorizationException;
use App\Exceptions\UsedInOtherTableException;
use App\Services\Tasks\CheckboxService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\Task;

class CheckboxController extends Controller
{
    /**
     * CheckboxController constructor.
     * @param  CheckboxService  $checkboxService
     */
    public function __construct(private CheckboxService $checkboxService) {}

    /**
     * Обновление статуса чебокса
     *
     * Права: `update tasks` или `update department tasks` или `update own tasks`
     *
     * @group Задачи
     *
     * @urlParam checkbox integer required
     *
     * @param  UpdateStatusRequest  $request
     * @param  Checkbox  $checkbox
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function changeIsCheckedStatus(UpdateStatusRequest $request, Checkbox $checkbox): JsonResponse
    {
        $this->authorize('update-own-tasks', $checkbox->task);

        $this->checkboxService->updateStatus($checkbox, $request->validated());

        return response_json(['checkbox' => CheckboxResource::make($checkbox)]);
    }

    /**
     * Обновление чекбокса задачи
     *
     * Права: `update tasks` или `update department tasks` или `update own tasks`
     *
     * @group Задачи
     *
     * @urlParam checkbox integer required
     *
     * @param  UpdateRequest  $request
     * @param  Checkbox  $checkbox
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(UpdateRequest $request, Checkbox $checkbox): JsonResponse
    {
        $this->authorize('update-own-tasks', $checkbox->task);

        $this->checkboxService->update($checkbox, $request->validated());

        return response_json(['checkbox' => CheckboxResource::make($checkbox)]);
    }

    /**
     * Удаление чекбокса задачи
     *
     * Права: `update tasks` или `update department tasks` или `update own tasks`
     *
     * @group Задачи
     *
     * @urlParam checkbox integer required
     *
     * @param  Checkbox  $checkbox
     * @return JsonResponse
     * @throws AuthorizationException
     * @throws UsedInOtherTableException
     */
    public function destroy(Checkbox $checkbox): JsonResponse
    {
        $this->authorize('update-own-tasks', $checkbox->task);

        $this->checkboxService->delete($checkbox);

        return response_success();
    }
}
