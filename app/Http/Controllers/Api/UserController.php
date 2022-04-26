<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return UserResource::collection(User::paginate(25));
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return AnonymousResourceCollection
     */
    public function show(User $user): AnonymousResourceCollection
    {
        return UserResource::collection(User::find($user));
    }

    /**
     * @param UserUpdateRequest $request
     * @param User $user
     * @return Application|Response|ResponseFactory
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $fields = $request->validated();
        $user->roles()->sync($request->role);
        $user->fill($fields)->save();

        $response = [
            'message' => "User has been updated.",
        ];

        return response($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return Response
     */
    public function destroy(User $user): Response
    {
        if ($user->id === 1)
        {
            return response(['message' => 'Access denied'], 403);
        }

        if (auth('sanctum')->user()->id === $user->id)
        {
            $user->tokens()->delete();
        }

        $user->delete();

        return response(['message' => 'User has been deleted.'], 200);
    }
}
