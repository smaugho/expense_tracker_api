<?php

namespace App\Http\Controllers;

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

    public function register(Request $request)
    {
        // required -> name, lastname, email , phone number
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'lastname' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
            'phonenumber' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }

        // Create user
        $user = $this->userService->createUser($request);
        $token = JWTAuth::fromUser($user);

        return response()->json([
            'success' => true,
            'token' => $token
        ]);
    }


    public function edit(Request $request)
    {
        // required -> name, lastname, email , phone number
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required',
            'lastname' => 'sometimes|required',
            'email' => 'sometimes|required|string|email|max:255|unique:users',
            'phonenumber' => 'sometimes|required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }

        // Update Data
        $user = auth()->user();
        $user = $this->userService->updateData($user, $request->all());

        return response()->json([
            'success' => true,
            'user' => $user
        ]);

    }
}
