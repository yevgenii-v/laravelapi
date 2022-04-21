<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserLoginRequest;
use App\Http\Requests\Api\UserRegisterRequest;
use App\Models\User;
use App\Notifications\RegisteredUser;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @param UserRegisterRequest $request
     * @return Application|ResponseFactory|Response
     */
    public function register(UserRegisterRequest $request)
    {
        if (auth('sanctum')->check()) {
            return response(['message'   => 'You are logged-in already.'], 403);
        }

        $user = User::create($request->validated());
        $user->notify(new RegisteredUser());

        $token = $user->createToken($user->name)->plainTextToken;

        $response = [
            'user'  => $user,
            'token' => $token,
        ];

        return response($response, 201);
    }

    /**
     * @param UserLoginRequest $request
     * @return Application|Response|ResponseFactory
     */
    public function login(UserLoginRequest $request)
    {
        if (auth('sanctum')->check()) {
            return response(['message'   => 'You are logged-in already.'], 403);
        }

        $fields = $request->validated();

        $user = User::where('email', $fields['email'])->first();

        if(!$user || !Hash::check($fields['password'], $user->password))
        {
            return response([
                'message'   => 'Wrong data.'
            ], 403
            );
        }

        $token = $user->createToken($user->name)->plainTextToken;

        $response = [
            'token' => $token,
        ];

        return response($response, 200);
    }

    /**
     * @return Application|Response|ResponseFactory
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response(['message' => 'Logged out.'], 200);
    }
}
