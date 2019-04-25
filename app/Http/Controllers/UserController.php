<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\UserService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    protected $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function register(RegisterRequest $request)
    {
        $request = $request->validated();

        $user = $this->userService->createUser($request);
        $token = JWTAuth::fromUser($user);

        return response()->json([
            'success' => true,
            'token' => $token
        ]);
    }


    public function edit(UpdateUserRequest $request)
    {
        $data = $request->validated();

        // Update Data
        $user = auth()->user();
        $user = $this->userService->updateData($user, $data);

        return response()->json([
            'success' => true,
            'user' => $user
        ]);

    }
}
