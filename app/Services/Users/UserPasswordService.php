<?php

namespace App\Services\Users;

class UserPasswordService
{
    /**
     * @param $user
     * @param  string  $password
     */
    public function update($user, string $password): void
    {
        $user->update(['password' => bcrypt($password)]);
    }
}
