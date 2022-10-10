<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Requests\Users\UpdatePasswordRequest;
use App\Http\Controllers\Controller;
use App\Models\RoleConst;
use App\Models\User;
use App\Services\Users\UserPasswordService;
use Illuminate\Http\JsonResponse;

class UserPasswordController extends Controller
{
    /**
     * UserPasswordController constructor.
     * @param  UserPasswordService  $userPasswordService
     */
    public function __construct(private UserPasswordService $userPasswordService)
    {
        $this->middleware(['permission:' . RoleConst::PERMISSION_USERS_CRUD]);
    }

    /**
     * Обновление пароля
     *
     * Права: `crud users`
     *
     * @group Сотрудники
     *
     * @bodyParam password string required Пароль должен содержать не менее 8 символов
     *
     * @param  UpdatePasswordRequest  $request
     * @param  User  $user
     * @return JsonResponse
     */
    public function update(UpdatePasswordRequest $request, User $user): JsonResponse
    {
        $this->userPasswordService->update($user, $request->validated()['password']);

        return response_success();
    }
}
