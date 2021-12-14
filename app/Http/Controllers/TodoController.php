<?php

namespace App\Http\Controllers;

use App\Repositories\TodoRepository;
use App\Repositories\UserRepository;
use App\Services\TodoService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateTodoRequest;
use App\Http\Requests\UpdateTodoRequest;

class TodoController extends Controller
{

    private $userRepository, $todoRepository, $todoService;

    public function __construct(UserRepository $userRepository, TodoRepository $todoRepository, TodoService $todoService)
    {
        $this->userRepository = $userRepository;
        $this->todoRepository = $todoRepository;
        $this->todoService = $todoService;
    }

    public function createTodo(CreateTodoRequest $request, int $id): Response
    {
        $user = $this->userRepository->findOne($id);

        $validated = $request->safe()->only(['description', 'date']);
        $this->todoService->create($validated,$user);

        return response(201);
    }

    public function updateStatus(UpdateTodoRequest $request, int $id): Response
    {
        $todo = $this->todoRepository->findOne($id);

        if (Auth::user()->id == $todo->user_id)
        {
            $validated = $request->safe()->only(['status']);
            $this->todoService->update($validated,$todo);

            return response(200);
        }

        return response(401);
    }

    public function show(int $id): Response
    {
        $userTodo = $this->todoRepository->allByID($id);

        return response($userTodo, 200);
    }
}
