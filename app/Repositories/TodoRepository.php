<?php

namespace App\Repositories;

use App\Models\Tasks;

class TodoRepository
{
    public function findOne(int $id): Tasks
    {
        return Tasks::find($id);
    }

    public function allByID(int $id)
    {
        return Tasks::all()->where('user_id', $id);
    }


}
