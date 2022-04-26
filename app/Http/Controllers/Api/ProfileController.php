<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ProfileUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class ProfileController extends Controller
{
    /**
     * @throws AuthorizationException
     */

    /**
     * @return UserResource
     */
    public function index(): UserResource
    {
        return UserResource::make(auth('sanctum')->user());
    }

    /**
     * @param ProfileUpdateRequest $request
     * @param User $profile
     * @return Application|ResponseFactory|Response
     */
    public function update(ProfileUpdateRequest $request, User $profile)
    {
        $fields = $request->validated();
        $profile->fill($fields)->save();

        $response = [
            'message'   => "Your data has been updated.",
        ];

        return response($response, 200);
    }

    public function destroy(User $profile)
    {
        $profile->tokens()->delete();
        $profile->delete();

        $response = [
            'message'   => "Your account has been deleted."
        ];

        return response($response);
    }
}
