<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdateRequest;
use App\Http\Resources\Profile\ProfileResource;
use App\Services\Profile\ProfileService;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    /**
     * ProfileController constructor.
     * @param  ProfileService  $profileService
     */
    public function __construct(private ProfileService $profileService) {}

    /**
     * Обновление основных данных
     *
     * @group Профиль
     *
     * @bodyParam email string required
     * @bodyParam office_position string Должность
     * @bodyParam born_at string Дата рождения в формате Y-m-d
     *
     * @param  UpdateRequest  $request
     * @return JsonResponse
     */
    public function update(UpdateRequest $request): JsonResponse
    {
        $user = $this->profileService->update(user(), $request->validated());

        return response_json(['user' => ProfileResource::make($user)]);
    }
}
