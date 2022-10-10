<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdateAvatarRequest;
use App\Services\Users\UserAvatarService;
use Illuminate\Http\JsonResponse;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class ProfileAvatarController extends Controller
{
    /**
     * UserAvatarController constructor.
     * @param  UserAvatarService  $userAvatarService
     */
    public function __construct(private UserAvatarService $userAvatarService) {}

    /**
     * Обновление аватара
     *
     * @group Профиль
     *
     * @bodyParam avatar file required Изображение, размер не более 10000 Кб
     *
     * @param  UpdateAvatarRequest  $request
     * @return JsonResponse
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function update(UpdateAvatarRequest $request): JsonResponse
    {
        $avatar = $this->userAvatarService->update(user());

        return response_json(['avatar' => $avatar]);
    }
}
