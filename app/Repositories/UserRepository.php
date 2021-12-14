<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function all()
    {
        return User::all();
    }

    public function findOne(int $id): User
    {
        return User::find($id);
    }

    public function byLoginName(array $data): User
    {
        return User::where('name', $data['name'])->first();
    }
}
