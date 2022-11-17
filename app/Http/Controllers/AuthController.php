<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login(UserLoginRequest $request){
        // return "yes you hit it";
        if(!$token = auth()->attempt($request->only(['email', 'password']))){
            return response()->json([
                'errors' => [
                    'message' => ['Sorry we cant find you with those details.'],
                ],
            ], 422);
        }

        return (new UserResource($request->user()))->additional([
            'meta' => [
                'token' => $token,
            ],
        ]);
    }

    // Get the authenticated User
    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function dataset() {
        return User::all();
    }
}