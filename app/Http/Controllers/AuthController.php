<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\UserService;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\LoginUserRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    private $userRepository, $userService;

    public function __construct(UserRepository $userRepository, UserService $userService)
    {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    public function Register(StoreUserRequest $request): Response
    {
        $validated = $request->safe()->only(['name', 'password']);
        $user = $this->userService->save($validated,null);

        $token = $user->createToken('token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function Login(LoginUserRequest $request): Response
    {

        $validated = $request->safe()->only(['name', 'password']);

        $user = $this->userRepository->byLoginName($validated);
        if($validated['name'] != $user->name)
        {
            return response('User does not exist.',401);
        }

        if($validated['password'] != $user->password)
        {
            return response('Invalid password.',401);
        }

        $token = $user->createToken('token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 200);
    }

    public function Logout(): Response
    {
        auth()->user()->tokens()->delete();

        return response(200);
    }

    public function GetUser(): Response
    {
        $user = auth()->user();
        return response($user, 200);
    }
}
