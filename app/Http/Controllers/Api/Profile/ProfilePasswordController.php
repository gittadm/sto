<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdatePasswordRequest;
use App\Services\Users\UserPasswordService;
use Illuminate\Http\JsonResponse;

class ProfilePasswordController extends Controller
{
    /**
     * UserPasswordController constructor.
     * @param  UserPasswordService  $userPasswordService
     */
    public function __construct(private UserPasswordService $userPasswordService) {}

    /**
     * Обновление пароля
     *
     * @group Профиль
     *
     * @bodyParam password string required Пароль должен содержать не менее 8 символов
     *
     * @param  UpdatePasswordRequest  $request
     * @return JsonResponse
     */
    public function update(UpdatePasswordRequest $request): JsonResponse
    {
        $this->userPasswordService->update(user(), $request->validated()['password']);

        return response_success();
    }
}
