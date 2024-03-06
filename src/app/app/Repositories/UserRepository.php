<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    /**
     * @param User $user
     * @param array $attributes
     * @return User
     */
    public function saveUser(User $user, array $attributes)
    {
        $user->fill($attributes);
        $user->save();

        return $user;
    }
}
