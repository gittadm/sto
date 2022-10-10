<?php

namespace App\Services\Profile;

use App\Models\User;

class ProfileService
{
    public function update($user, array $data): User
    {
        $user->fill($data);
        $user->save();

        return $user;
    }
}
