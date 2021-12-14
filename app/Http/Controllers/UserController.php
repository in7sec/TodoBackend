<?php

namespace App\Http\Controllers;

use App\Repositories\TodoRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private $todoRepository;

    public function __construct(TodoRepository $todoRepository)
    {
        $this->todoRepository = $todoRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): Response
    {
        $userTodo = $this->todoRepository->allByID(Auth::user()->id);

        return response($userTodo, 200);
    }

}
