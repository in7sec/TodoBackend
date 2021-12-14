<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Services\UserService;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Response;

class AdminController extends Controller
{

    private $userRepository, $userService;

    public function __construct(UserRepository $userRepository, UserService $userService)
    {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): Response
    {
        $users = $this->userRepository->all();

        return response($users, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request): Response
    {

        $validated = $request->safe()->only(['name', 'password']);
        $user = $this->userService->save($validated,null);

        return response($user, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, int $id): Response
    {
        $user = $this->userRepository->findOne($id);

        $validated = $request->safe()->only(['name']);
        $this->userService->save($validated,$user);

        return response(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(int $id): Response
    {
        $user = $this->userRepository->findOne($id);
        $this->userService->delete($user);

        return response(202);
    }
}
