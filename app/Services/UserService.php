<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function save(array $data, ?User $user)
    {
        if($user) {
            return $user->update($data);
        }

        return User::create([
            'name' => $data['name'],
            'password' => $data['password'],
        ]);
    }

    public function delete(User $user)
    {
        return $user->delete();
    }

}
