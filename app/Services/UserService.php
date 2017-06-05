<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Collection;

class UserService
{
    /**
     * Create user.
     *
     * @param  \Illuminate\Support\Collection  $data
     * @return \App\Models\User
     */
    public function create(Collection $data)
    {
        return User::create($data->toArray());
    }

    /**
     * Update user.
     *
     * @param  \App\Models\User  $user
     * @param  \Illuminate\Support\Collection  $data
     * @return \App\Models\User
     */
    public function update(User $user, Collection $data)
    {
        $data = $data->reject(function ($value) {
            return is_null($value);
        });

        $user->update($data->toArray());

        return $user;
    }
}
