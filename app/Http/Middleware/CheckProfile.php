<?php

namespace App\Http\Middleware;

use App\Http\Requests\Api\ProfileUpdateRequest;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CheckProfile
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->route()->parameter('profile')->id != auth()->user()->id)
        {
            return response(['message' => 'User has not found.'], 404);
        }

        return $next($request);
    }
}
