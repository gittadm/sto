<?php

namespace App\Services\Users;

use App\Models\User;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class UserAvatarService
{
    /**
     * @param  User  $user
     * @return string
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function update(User $user): string
    {info(request()->file('avatar')->getFilename());
        $user->addMediaFromRequest('avatar')
            ->sanitizingFileName(function ($fileName) {
                return sanitize_file_name($fileName);
            })
            ->usingFileName(gen_file_name('avatar'))
            ->toMediaCollection('avatar', User::AVATAR_DISK);

        return $user->avatar_url;
    }
}
