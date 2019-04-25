<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApiController extends Controller
{

    public function login(LoginRequest $request)
    {

        $credentials = $request->only('email', 'password');
        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'error' => 'invalid credentials'
            ], 401);
        }

        return response()->json(compact('token'));
    }

    // todo: finish
    public function logout()
    {

    }


}
