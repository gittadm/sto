<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Requests\Users\UpdateAvatarRequest;
use App\Http\Controllers\Controller;
use App\Models\RoleConst;
use App\Services\Users\UserAvatarService;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class UserAvatarController extends Controller
{
    /**
     * UserAvatarController constructor.
     * @param  UserAvatarService  $userAvatarService
     */
    public function __construct(private UserAvatarService $userAvatarService)
    {
        $this->middleware(['permission:' . RoleConst::PERMISSION_USERS_CRUD]);
    }

    /**
     * Обновление аватара
     *
     * Права: `crud users`
     *
     * @group Сотрудники
     *
     * @bodyParam avatar file required Изображение, размер не более 10000 Кб
     *
     * @param  UpdateAvatarRequest  $request
     * @param  User  $user
     * @return JsonResponse
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function update(UpdateAvatarRequest $request, User $user): JsonResponse
    {
        $avatar = $this->userAvatarService->update($user);

        return response_json(['avatar' => $avatar]);
    }
}
