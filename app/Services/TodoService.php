<?php

namespace App\Services;

use App\Models\Tasks;
use App\Models\User;

class TodoService
{
    public function create(array $data, ?User $user): Tasks
    {
        return Tasks::create([
            'user_id' => $user->id,
            'task' => $data['description'],
            'date' => $data['date'],
            'status' => 'to do'
        ]);
    }

    public function update(array $data, Tasks $todo)
    {
        return $todo->update($data);
    }
}
